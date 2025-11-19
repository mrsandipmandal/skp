<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


/* Signup and Login */
Route::post('/signup', [ApiController::class,'signup']);
Route::post('/login', [ApiController::class,'login']);

/* User Strict Routes */
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/dashboard', [ApiController::class,'dashboard']);
    Route::post('/logoff', [ApiController::class,'logoff']);

    // Delivery Type
    Route::get('/delivery-type', [ApiController::class,'delivery_type']);

    // Create Order
    Route::post('/create-order', [ApiController::class,'create_order']);

    // Order List
    Route::get('/order-list', [ApiController::class,'order_list']);

});
