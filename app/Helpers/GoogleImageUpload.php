<?php

namespace App\Helpers;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\Permission;

/**
 * GoogleImageUpload - Single unified helper for Google Drive image uploads
**/
class GoogleImageUpload
{
    protected $client;
    protected $service;
    protected $credentialsPath;
    protected $tokenPath;
    protected $redirectUri;
    protected $rootFolderId = '1YPTh5Ae7BMIIbbDyMQPrTB0ziNEwxDZn'; // Default root folder
    protected $projectFolderName = 'KSP';

    /**
     * Resolve a storage path to an absolute path
     */
    protected function resolvePath($path)
    {
        if (empty($path)) {
            return null;
        }

        // If already an absolute path, return as-is
        if (strpos($path, ':') !== false || strpos($path, '/') === 0) {
            return $path;
        }

        // Resolve relative storage paths
        if (strpos($path, 'storage/') === 0) {
            return storage_path(str_replace('storage/', '', $path));
        }

        return $path;
    }

    public function __construct($credentialsPath, $tokenPath, $redirectUri, $rootFolderId = null, $projectFolderName = null)
    {
        if ($rootFolderId) {
            $this->rootFolderId = $rootFolderId;
        }

        if ($projectFolderName) {
            $this->projectFolderName = $projectFolderName;
        }

        $this->credentialsPath = $this->resolvePath($credentialsPath);
        $this->tokenPath = $this->resolvePath($tokenPath);

        // Resolve redirect URI: prefer explicit param, then env GOOGLE_REDIRECT_URI, then APP_URL, then server host
        $resolved = $redirectUri ?: env('GOOGLE_REDIRECT_URI') ?: env('APP_URL');

        if ($resolved && filter_var($resolved, FILTER_VALIDATE_URL)) {
            $this->redirectUri = $resolved;
        } else {
            // Try to build from server host if available (useful in web request contexts)
            if (empty($resolved) && !empty($_SERVER['HTTP_HOST'])) {
                $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                $built = $scheme . '://' . $_SERVER['HTTP_HOST'] . ($_SERVER['REQUEST_URI'] ?? '/');
                if (filter_var($built, FILTER_VALIDATE_URL)) {
                    $this->redirectUri = $built;
                } else {
                    throw new \InvalidArgumentException("Redirect URI must be absolute. Provide a valid absolute URL via constructor or set the 'GOOGLE_REDIRECT_URI' environment variable.");
                }
            } else {
                throw new \InvalidArgumentException("Redirect URI must be absolute. Provide a valid absolute URL via constructor or set the 'GOOGLE_REDIRECT_URI' environment variable (and register the same URL in Google Cloud Console's Authorized redirect URIs).");
            }
        }

        $this->initializeClient();
    }

    /**
     * Initialize Google Client
     */
    protected function initializeClient()
    {
        if (!file_exists($this->credentialsPath)) {
            throw new \InvalidArgumentException("Google credentials file not found at: {$this->credentialsPath}");
        }

        $this->client = new Client();
        $this->client->setAuthConfig($this->credentialsPath);
        $this->client->addScope(Drive::DRIVE_FILE);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
        $this->client->setRedirectUri($this->redirectUri);

        // Load token if exists
        if (file_exists($this->tokenPath)) {
            $raw = file_get_contents($this->tokenPath);
            $token = json_decode($raw, true);

            if (!is_array($token)) {
                throw new \RuntimeException("Saved token file '{$this->tokenPath}' contains invalid JSON or is empty. Remove the file and re-authorize via OAuth.");
            }

            $this->client->setAccessToken($token);

            // Refresh if expired
            if ($this->client->isAccessTokenExpired()) {
                $refreshToken = $this->client->getRefreshToken();
                if ($refreshToken) {
                    $newToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
                    if (!isset($newToken['error'])) {
                        if (!isset($newToken['refresh_token'])) {
                            $newToken['refresh_token'] = $refreshToken;
                        }
                        file_put_contents($this->tokenPath, json_encode($newToken));
                        $this->client->setAccessToken($newToken);
                    }
                }
            }
        }

        $this->service = new Drive($this->client);
    }

    /**
     * Get Google OAuth authorization URL
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Handle OAuth callback - exchange code for token
     */
    public function authorize($code)
    {
        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                return ['success' => false, 'message' => $token['error_description'] ?? $token['error']];
            }

            @mkdir(dirname($this->tokenPath), 0755, true);
            file_put_contents($this->tokenPath, json_encode($token));

            $this->client->setAccessToken($token);

            return ['success' => true, 'message' => 'Authorized successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Check if user is authorized
     */
    public function isAuthorized()
    {
        return file_exists($this->tokenPath);
    }

    /**
     * Upload image to Google Drive
     */
    public function upload($file, $folder = 'Images')
    {
        if (!$this->isAuthorized()) {
            throw new \Exception('Not authorized. Call authorize() first.');
        }

        // Get file path and name
        if (is_string($file)) {
            $filePath = $file;
            $fileName = basename($file);
        } elseif (is_array($file) && isset($file['tmp_name'])) {
            $filePath = $file['tmp_name'];
            $fileName = basename($file['name']);
        } elseif (is_object($file) && method_exists($file, 'getRealPath')) {
            $filePath = $file->getRealPath();
            $fileName = $file->getClientOriginalName() ?? basename($filePath);
        } else {
            throw new \Exception('Invalid file input');
        }

        // Ensure folder chain: <rootFolderId> / <projectFolderName> / <dynamic folder provided by caller>
        $rootFolderId = $this->rootFolderId;
        $projectFolderId = $this->getOrCreateFolder($this->projectFolderName, $rootFolderId);

        // If caller provided a folder name, create/get it under project folder, otherwise use project folder itself
        if (!empty($folder)) {
            $targetFolderId = $this->getOrCreateFolder($folder, $projectFolderId);
            $fullFolderPath = $this->projectFolderName . '/' . $folder;
        } else {
            $targetFolderId = $projectFolderId;
            $fullFolderPath = $this->projectFolderName;
        }

        // Upload file
        $fileMetadata = new Drive\DriveFile([
            'name' => $fileName,
            'parents' => [$targetFolderId]
        ]);

        $uploadedFile = $this->service->files->create($fileMetadata, [
            'data' => file_get_contents($filePath),
            'mimeType' => mime_content_type($filePath) ?: 'image/jpeg',
            'uploadType' => 'multipart',
            'supportsAllDrives' => true,
            'fields' => 'id, name'
        ]);

        $fileId = $uploadedFile->getId();

        // Make public
        $permission = new Permission([
            'type' => 'anyone',
            'role' => 'reader'
        ]);
        $this->service->permissions->create($fileId, $permission);

        // Return URLs
        return [
            'id' => $fileId,
            'name' => $fileName,
            'folder' => $folder,
            'view_url' => "https://drive.google.com/file/d/{$fileId}/view",
            'download_url' => "https://drive.google.com/uc?id={$fileId}&export=download",
            'preview_url' => "https://drive.google.com/uc?export=view&id={$fileId}",
            'thumbnail_url' => "https://drive.google.com/thumbnail?id={$fileId}&sz=w300"
        ];
    }

    /**
     * Create or get folder in Google Drive
    */
    public function createFolder($folderPath)
    {
        if (!$this->isAuthorized()) {
            throw new \Exception('Not authorized. Call authorize() first.');
        }

        // Split path into folder names
        $folderNames = array_filter(explode('/', trim($folderPath, '/')));

        if (empty($folderNames)) {
            throw new \Exception('Folder path cannot be empty.');
        }

        // Start from root folder
        $currentParentId = $this->rootFolderId;
        $createdFolders = [];

        // Create each folder in the path
        foreach ($folderNames as $folderName) {
            $currentParentId = $this->getOrCreateFolder($folderName, $currentParentId);
            $createdFolders[] = $folderName;
        }

        return [
            'path' => implode('/', $createdFolders),
            'folder_id' => $currentParentId,
            'message' => 'Folder(s) created successfully.'
        ];
    }

    /**
     * Create or get folder in Google Drive
     */
    protected function getOrCreateFolder($folderName, $parentId = null)
    {
        $escapedName = str_replace("'", "\\'", $folderName);
        $query = "mimeType='application/vnd.google-apps.folder' and name='{$escapedName}' and trashed=false";
        if ($parentId) {
            $query .= " and '{$parentId}' in parents";
        }

        $response = $this->service->files->listFiles([
            'q' => $query,
            'fields' => 'files(id)',
            'includeItemsFromAllDrives' => true,
            'supportsAllDrives' => true,
        ]);

        $folders = $response->getFiles();
        if (count($folders) > 0) {
            return $folders[0]->getId();
        }

        $folderMetadata = new Drive\DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);
        if ($parentId) {
            $folderMetadata->setParents([$parentId]);
        }

        $folder = $this->service->files->create($folderMetadata, ['fields' => 'id']);
        return $folder->getId();
    }
}
