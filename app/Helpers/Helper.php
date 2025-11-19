<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
// use App\Mail\SendMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/* for excel */
/* composer require maatwebsite/excel */
// use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Concerns\FromArray;
// use Maatwebsite\Excel\Concerns\WithHeadings;


class Helper
{
    private const OPENSSL_CIPHER_NAME = "aes-128-cbc";
    private const CIPHER_KEY_LEN = 16;

    private static function fixKey($key)
    {
        if (strlen($key) < Helper::CIPHER_KEY_LEN) {
            return str_pad("$key", Helper::CIPHER_KEY_LEN, "0");
        }

        if (strlen($key) > Helper::CIPHER_KEY_LEN) {
            return substr($key, 0, Helper::CIPHER_KEY_LEN);
        }
        return $key;
    }

    static function encrypt($data, $key = 'lIxib9EihRp6Virw', $iv = 'eXS7Dz4wbNJcvOMt')
    {
        $encodedEncryptedData = base64_encode(openssl_encrypt($data, Helper::OPENSSL_CIPHER_NAME, Helper::fixKey($key), OPENSSL_RAW_DATA, $iv));
        $encodedIV = base64_encode($iv);
        $encryptedPayload = $encodedEncryptedData . ":" . $encodedIV;
        return $encryptedPayload;
    }

    static function decrypt($data, $key = 'lIxib9EihRp6Virw', $iv = 'eXS7Dz4wbNJcvOMt')
    {
        $parts = explode(':', $data); //Separate Encrypted data from iv.
        $encrypted = $parts[0];
        //$iv = $parts[1];
        $decryptedData = openssl_decrypt(base64_decode($encrypted), Helper::OPENSSL_CIPHER_NAME, Helper::fixKey($key), OPENSSL_RAW_DATA, $iv);
        return $decryptedData;
    }

    public static function GenerateId($modelClass)
    {
        $id = 0;
        $model = 'App\Models\\' . $modelClass;
        $latestModel = $model::latest('id')->first();
        if ($latestModel != null) {
            $id = $latestModel->id + 1;
        } else {
            $id += 1;
        }
        return $id;
    }

    public static function GenerateUniqueId($modelClass = '', $length = 6, $prefix = '', $primarry = 'id')
    {
        $id = 0;
        $model = 'App\Models\\' . $modelClass;
        $latestModel = $model::latest('id')->first();
        if ($latestModel != null) {
            $id = $latestModel->$primarry + 1;
        } else {
            $id += 1;
        }
        $prefix = $prefix ?? '';
        $formattedId = $prefix . str_pad($id, $length, '0', STR_PAD_LEFT);
        return $formattedId;
    }

    public static function GenerateRandUniqueId($prefix = '', $length = 5)
    {
        $id = $prefix;
        $characters = '0123456789';
        $charactersLength = strlen($characters);

        for ($i = strlen($prefix); $i < $length; $i++) {
            $id .= $characters[rand(0, $charactersLength - 1)];
        }

        $id = $prefix;
        for ($i = strlen($prefix); $i < $length; $i++) {
            $id .= $characters[rand(0, $charactersLength - 1)];
        }
        return $id;
    }

    public static function Act($model = '', $upload_field = '', $update_value = null, $id = '')
    {
        return $model::where('id', $id)->update([$upload_field => $update_value]);
    }

    public static function deleteFileFromUrl($url)
    {
        // Get the path from the URL
        $path = parse_url($url, PHP_URL_PATH);
        // Remove the leading slash if present
        $path = ltrim($path, '/');
        // Get the path from the project path
        // $arr = explode('/', $path); //for offline
        // Remove the project path
        // $path = Str::after($path, $arr[0] . '/'); //for offline
        if (file_exists($path)) {
            unlink($path);
            return true;
        } else {
            return false;
        }
    }

    public static function TagifyToComma($tags = '')
    {
        $value = '';
        if ($tags != '') {
            $array = json_decode($tags, true);
            $tagi = array();
            if ($array) {
                foreach ($array as $item) {
                    $tagi[] = $item['value'];
                }
            }
            $value = implode(',', $tagi);
        } else {
            $value = null;
        }
        return $value;
    }

    public static function sendSms($phone, $msg, $template_id)
    {
        $sender_id = 'UBONLN';
        $username = 'ubonline';
        $apikey = '3CBBE-B2F1E';
        $uri = 'http://sms.onnetsolution.com/sms-panel/api/http/index.php';
        $data = array(
            'username' => $username,
            'apikey' => $apikey,
            'apirequest' => 'Text',
            'sender' => $sender_id,
            'route' => 'TRANS',
            'format' => 'JSON',
            'message' => $msg,
            'mobile' => $phone,
            'TemplateID' => $template_id,
        );

        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        $resp = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        return json_encode(compact('resp', 'error'));
    }

    public static function searchForId($id, $array, $chkfld, $sendfld)
    {
        foreach ($array as $val) {
            if ($val[$chkfld] == $id) {
                return $val[$sendfld];
            }
        }
        return null;
    }

    public static function findNestedArrayValue(array $nestedArray, string $chkfld, string $id, string $sendfld)
    {
        foreach ($nestedArray as $val) {
            // check current menu
            if (isset($val[$chkfld]) && $val[$chkfld] == $id) {
                return $val[$sendfld] ?? null;
            }

            // check inside sub_menus recursively
            if (!empty($val['sub_menus'])) {
                $result = self::findNestedArrayValue($val['sub_menus'], $chkfld, $id, $sendfld);
                if ($result !== null) {
                    return $result;
                }
            }
        }
        return null;
    }

    public static function checkPermission($find_field)
    {
        $current = request()->path();
        $menus = session()->get("menu");
        // $result = self::searchForId($current, $menus, 'route_name', $find_field);
        $result = self::findNestedArrayValue($menus, 'route_name', $current, $find_field);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public static function validateRequestSpecialCharacters($request, $allowedSpecialChars = [])
    {
        // Base pattern for special characters
        $basePattern = "[<*>'{%};\/|\=!#$`~]";

        // Escape allowed special characters for use in a regex pattern
        $escapedAllowedChars = preg_quote(implode('', $allowedSpecialChars), '/');

        // Build the final pattern to exclude allowed characters
        if (!empty($allowedSpecialChars)) {
            // Remove the allowed characters from the base pattern
            $pattern = "/[" . str_replace($escapedAllowedChars, '', $basePattern) . "]/";
        } else {
            // No allowed special characters
            $pattern = "/$basePattern/";
        }

        // Iterate over each field in the request
        foreach ($request as $field => $value) {
            // Check if the value is an array
            if (is_array($value)) {
                foreach ($value as $val) {
                    // Check if the value contains any special characters not allowed
                    if (preg_match($pattern, $val)) {
                        // Alert the user with the specific field name
                        echo "<script>
                                alert('The data in the field \"$field\" contains invalid characters. Special characters are not allowed.');
                                history.go(-1);
                              </script>";
                        exit; // Stop further execution
                    }
                }
            } else {
                // Check if the value contains any special characters not allowed
                if (preg_match($pattern, $value)) {
                    // Alert the user with the specific field name
                    echo "<script>
                            alert('The data in the field \"$field\" contains invalid characters. Special characters are not allowed.');
                            history.go(-1);
                          </script>";
                    exit; // Stop further execution
                }
            }
        }

        return true;
    }

    public static function validateUploadedFile($file, $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'], $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'])
    {
        $msg = "";
        // Get the file extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Check if the extension is in the allowed list
        if (!in_array($fileExtension, $allowedExtensions)) {
            $msg = "Invalid file extension. Only JPG, JPEG, and PNG files are allowed.";
        }

        // Check the actual MIME type of the file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $actualMimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        // Check if the actual MIME type matches the allowed list
        if (!in_array($actualMimeType, $allowedMimeTypes)) {
            $msg = "Invalid file content. The file is not a valid image (JPG, JPEG, or PNG).";
        }

        if ($msg) {
            echo "<script>
                alert('\"$msg\"');
                history.go(-1);
            </script>";
            exit;
        }
        // If all checks pass, return blank
        // return $msg;
    }

    public static function generateCaptcha()
    {

        // Generate a random string of 6 characters
        $captchaText = substr(str_shuffle("23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ"), 0, 6);

        // Store the CAPTCHA text in the session
        Session::put('captcha', $captchaText);

        // Create a blank image
        $image = imagecreatetruecolor(150, 50);

        // Set background color (white) and text color (black)
        $backgroundColor = imagecolorallocate($image, 255, 255, 255); // white
        $textColor = imagecolorallocate($image, 0, 0, 0);             // black

        // Fill the background with white color
        imagefilledrectangle($image, 0, 0, 150, 50, $backgroundColor);

        // Add some noise to the image (random dots)
        for ($i = 0; $i < 1000; $i++) {
            $dotColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($image, rand(0, 150), rand(0, 50), $dotColor);
        }

        // Set font size and position of the text
        $fontSize = 20;
        $x = 15;
        $y = 35;

        // Load a built-in font or use a custom font (TTF)
        // For a TTF font, you can download a font file and use it like this:
        // imagettftext($image, $fontSize, 0, $x, $y, $textColor, 'path-to-font.ttf', $captchaText);

        // Alternatively, use GD library's built-in fonts:
        imagestring($image, 5, $x, $y - 20, $captchaText, $textColor);

        // Output the image as a PNG file
        header("Content-type: image/png");
        imagepng($image);

        // Destroy the image resource
        imagedestroy($image);
    }

    public static function createEditLog($tableName, $oldData = null, $newData = null, $eby = null)
    {
        $edit_logs = new \App\Models\edit_logs();
        $edit_logs->tbl = $tableName;
        $edit_logs->old = json_encode($oldData);
        $edit_logs->new = json_encode($newData);
        $edit_logs->eby = $eby ? $eby : session()->get("username");
        $edit_logs->save();
    }

    /* public static function getData($table, $field, $whereField, $whereValue)
    {
        $result = DB::table($table)
            ->where($whereField, $whereValue)
            ->value($field);
        return $result;
    } */
    public static function getData($table, $field, $whereField, $whereValue)
    {
        $query = DB::table($table);

        if (is_array($whereValue)) {
            $query->whereIn($whereField, $whereValue);
        } else {
            $query->where($whereField, $whereValue);
        }

        return $query->pluck($field)->toArray();
    }

    public static function imageUpload($file, $path = 'uploads', $customName = null, $allowedExtensions = null)
    {
        // Validate input
        if (!$file || !$file->isValid()) {
            return null;
        }

        // Sanitize filename
        $extension = strtolower($file->getClientOriginalExtension());

        // Default allowed extensions if not provided
        if ($allowedExtensions === null) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx'];
        }

        // Validate file extension
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception("Invalid file type. Allowed types: " . implode(', ', $allowedExtensions));
        }

        // Ensure path exists inside public directory
        $destinationPath = public_path($path);

        // Use Laravel's directory creation method with proper permissions
        File::makeDirectory($destinationPath, 0755, true, true);

        // Generate filename
        if ($customName) {
            // Sanitize custom name
            $customName = Str::slug($customName);
            $fileName = $customName . '.' . $extension;
        } else {
            // Generate unique filename
            $fileName = Str::random(20) . '.' . $extension;
        }

        // Prevent filename conflicts
        // $counter = 1;
        // $originalFileName = $fileName;
        // while (File::exists($destinationPath . '/' . $fileName)) {
        //     $fileName = pathinfo($originalFileName, PATHINFO_FILENAME)
        //         . '_' . $counter++
        //         . '.' . $extension;
        // }

        try {
            // Move file with error handling
            $file->move($destinationPath, $fileName);

            // Return full path
            return "$path/$fileName";
        } catch (\Exception $e) {
            // Log the error
            Log::error('File upload failed: ' . $e->getMessage());
            return null;
        }
    }

    public static function multipleImagesUpload($files, $userId, $path = 'uploads', $allowedExtensions = null)
    {
        // Validate input
        if (!$files || !is_array($files)) {
            return null;
        }

        // Define user-specific folder
        $userPath = $path . '/' . $userId;
        $destinationPath = public_path($userPath);

        // Ensure directory exists with proper permissions
        File::makeDirectory($destinationPath, 0755, true, true);

        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file->isValid()) {
                try {
                    $uploadedFile = self::imageUpload(
                        $file,
                        $userPath,
                        null,
                        $allowedExtensions ?? ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx']
                    );

                    if ($uploadedFile) {
                        $uploadedFiles[] = $uploadedFile;
                    }
                } catch (\Exception $e) {
                    // Log individual file upload errors
                    Log::error('Multiple file upload failed: ' . $e->getMessage());
                }
            }
        }

        // Return array of uploaded file paths or null if no files uploaded
        // return !empty($uploadedFiles) ? $uploadedFiles : null; // save array of uploaded file paths
        return !empty($userPath) ? $userPath : null; // save directory path
    }

    public static function getMultipleImagesPath($path = null)
    {
        if (!$path) {
            return [];
        }

        // Ensure path starts without a leading slash
        $path = trim($path, '/');
        $destinationPath = public_path($path);

        if (!File::exists($destinationPath)) {
            Log::error("Path does not exist: " . $destinationPath);
            return [];
        }

        $files = File::files($destinationPath);

        $relativePaths = array_map(function ($file) use ($path) {
            // Use the original path to create relative paths
            return '/' . $path . '/' . basename($file);
        }, $files);

        return $relativePaths;
    }

    public static function multipleFileDeleteFromUrl($url)
    {
        try {
            // Validate and sanitize path
            $path = parse_url($url, PHP_URL_PATH);
            $path = ltrim($path, '/');

            // Ensure path is within allowed directory
            $fullPath = public_path($path);

            if (!Str::startsWith($fullPath, public_path())) {
                throw new \Exception('Invalid path');
            }

            if (is_dir($fullPath)) {
                $files = File::files($fullPath);

                foreach ($files as $file) {
                    if (is_file($file)) {
                        File::delete($file);
                    }
                }

                // Optionally remove the directory
                File::deleteDirectory($fullPath);

                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('File deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public static function multipleImagesPath($path, $baseUrl)
    {
        // Validate inputs
        if (!$path || !$baseUrl) {
            return [];
        }

        // Ensure path is within public directory
        $fullPath = public_path($path);

        if (!is_dir($fullPath)) {
            return [];
        }

        $images = [];
        $files = File::files($fullPath);

        foreach ($files as $file) {
            // Validate file is an image
            $mimeType = mime_content_type($file);
            if (strpos($mimeType, 'image/') === 0) {
                $relativePath = str_replace(public_path(), '', $file);
                $images[] = rtrim($baseUrl, '/') . $relativePath;
            }
        }

        return $images;
    }

    public static function exportExcel(array $headers, array $data, string $fileName = 'export.xlsx')
    {
        return Excel::download(new class($headers, $data) implements FromArray, WithHeadings {

            private $headers, $data;

            public function __construct($headers, $data)
            {
                $this->headers = $headers;
                $this->data = $data;
            }

            public function headings(): array
            {
                return $this->headers;
            }

            public function array(): array
            {
                return $this->data;
            }
        }, $fileName);
    }

    public static function arraySearch($signupArray = [], $field = '', $whereField = '', $whereValue = '')
    {
        $index = array_search($whereValue, array_column($signupArray, $whereField));
        $result = $index !== false ? $signupArray[$index][$field] : 'NA';
        return $result;
    }

}

