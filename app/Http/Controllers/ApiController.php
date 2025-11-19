<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signup;
use App\Models\Order;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Helpers\GoogleImageUpload;

class ApiController extends Controller
{
    /* ----------------------------- SIGNUP ----------------------------- */
    public function signup(Request $request)
    {
        $request->validate(
            [
                "username" => "required",
                "email" => "required",
            ]
        );

        $existingUser = Signup::where('username', $request->username)
            ->orWhere('email', $request->email)
            ->first();

        if ($existingUser) {
            return response()->json(['error' => true, 'message' => 'User already exists'], 401);
        }

        $user = new Signup;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->mobile = $request->mobile ?? '';
        $user->name = $request->name ?? '';
        $user->userlevel = "10";
        $user->actnum = "0";
        $user->save();

        return response()->json(['error' => false,'message' => 'Signup successful'], 200);
    }

    /* ----------------------------- LOGIN ----------------------------- */
    public function login(Request $request)
    {
        $user = Signup::where('username', $request->username)->orWhere('mobile', $request->username)->orWhere('email', $request->username)->first();

        if (!$user) {
            return response()->json(['error' => true, 'message' => 'Invalid email or password'], 401);
        }

        if ($user->userlevel != "10") {
            return response()->json(['error' => true, 'message' => 'Provide valid user'], 401);
        }

        if ($user->actnum != "0") {
            return response()->json(['error' => true, 'message' => 'Your account is inactive'], 401);
        }

        // Create Token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'error' => false,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    /* ---------------------------- DASHBOARD ---------------------------- */
    public function dashboard(Request $request)
    {
        return response()->json([
            'error' => false,
            'message' => 'Dashboard Data',
            'user' => $request->user(),
        ]);
    }

    /* ------------------------------ LOGOFF ------------------------------ */
    public function logoff(Request $request)
    {
        $request->user()->tokens()->delete();  // delete all tokens

        return response()->json([
            'error' => false,
            'message' => 'Logged out successfully'
        ]);
    }

    /* -------------------------- CREATE ORDER --------------------------- */
/*     public function create_order(Request $request)
    {
        $request->validate(
            [
                "customer_id" => "required",
                "order_type" => "required",
                "note" => "nullable",
                "file" => "nullable|file|max:2048|mimes:jpg,jpeg,png",
            ]
        );

        $user = $request->user();
        $order_number = Helper::GenerateUniqueId('Order', 8, 'ORD');
        $order = new Order();
        $order->order_number = $order_number;
        $order->customer_id = $user->customer_id;
        $order->note = $request->note;
        $order->image_path = $request->image_path;
        $order->order_type = $request->order_type;
        $order->save();

        return response()->json([
            'error' => false,
            'message' => 'Order created successfully'
        ]);
    } */

    public function create_order(Request $request)
    {
        $request->validate([
            "customer_id" => "required",
            "order_type" => "required",
            "note" => "nullable",
            "file" => "nullable|file|max:2048|mimes:jpg,jpeg,png",
        ]);

        $user = $request->user();
        $order_number = Helper::GenerateUniqueId('Order', 8, 'ORD');
        $order = new Order();
        $order->order_number = $order_number;
        $order->customer_id = $request->customer_id;
        $order->note = $request->note;
        $order->order_type = $request->order_type;

        // Handle image upload
        $image_path = null;
        if ($request->hasFile('file')) {
            try {
                $uploader = new GoogleImageUpload(
                    env('GOOGLE_CREDENTIALS_PATH', base_path('app/google/credentials.json')),
                    env('GOOGLE_TOKEN_PATH', storage_path('app/google/token.json')),
                    env('GOOGLE_REDIRECT_URI', env('APP_URL') . '/google-callback')
                );

                if (!$uploader->isAuthorized()) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Google Drive not authorized'
                    ], 400);
                }

                $result = $uploader->upload($request->file('file'), 'Uploads/SKP/Orders');
                $image_path = $result['preview_url'];
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'Image upload failed: ' . $e->getMessage()
                ], 400);
            }
        }

        $order->image_path = $image_path;
        $order->save();

        return response()->json([
            'error' => false,
            'message' => 'Order created successfully',
            'data' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'image_url' => $image_path
            ]
        ]);
    }

}
