<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GoogleImageUpload;

class GoogleDriveController extends Controller
{
    public function get_google_auth_url()
    {
        $uploader = new GoogleImageUpload(
            env('GOOGLE_CREDENTIALS_PATH'),
            env('GOOGLE_TOKEN_PATH'),
            env('GOOGLE_REDIRECT_URI', env('APP_URL') . '/google-callback')
        );
        return response()->json(['auth_url' => $uploader->getAuthUrl()]);
    }

    public function google_callback(Request $request)
    {
        $uploader = new GoogleImageUpload(
            env('GOOGLE_CREDENTIALS_PATH'),
            env('GOOGLE_TOKEN_PATH'),
            env('GOOGLE_REDIRECT_URI', env('APP_URL') . '/google-callback')
        );
        $result = $uploader->authorize($request->get('code'));
        return response()->json($result);
    }

    public function check_google_auth()
    {
        $uploader = new GoogleImageUpload(
            env('GOOGLE_CREDENTIALS_PATH'),
            env('GOOGLE_TOKEN_PATH'),
            env('GOOGLE_REDIRECT_URI', env('APP_URL') . '/google-callback')
        );
        return response()->json(['authorized' => $uploader->isAuthorized()]);
    }
}
