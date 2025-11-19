<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Signup;
use App\Models\Order;
use App\Helpers\Helper;
use App\Helpers\GoogleImageUpload;

use Carbon\Carbon;

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
    public function create_order(Request $request)
    {
        $err = false;
        $validator = Validator::make($request->all(), [
            "order_type" => "required|string",
            "note" => "nullable|string",
            "file" => "nullable|file|max:5072|mimes:jpg,jpeg,png,webp",
        ]);
        if ($validator->fails()) {
            $err = true;
            $resp['error'] = true;
            $resp['message'] = $validator->errors()->all();
        }

        $order_number = Helper::GenerateUniqueId('Order', 8, 'ORD');
        $order = new Order();
        $order->order_number = $order_number;
        // Use the authenticated user as the customer. Ensure route is protected with auth middleware.
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => true, 'message' => 'Unauthenticated'], 401);
        }
        $order->customer_id = $user->id;
        $order->note = $request->note;
        $order->order_type = $request->order_type;

        // Handle image upload to Google Drive
        $image_path = null;
        if ($request->hasFile('file')) {
            try {
                $uploader = GoogleImageUpload::gAuthorized();
                $result = $uploader->upload($request->file('file'), 'Orders');
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
            'data' => $order
        ]);
    }

    /* -------------------------- ORDER LIST --------------------------- */
    public function order_list(Request $request)
    {
        // Use authenticated user to list their orders.
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => true, 'message' => 'Unauthenticated'], 401);
        }

        $orders = Order::where('customer_id', $user->id)->get();
        return response()->json([
            'error' => false,
            'message' => 'Order List',
            'data' => $orders
        ]);
    }


}
