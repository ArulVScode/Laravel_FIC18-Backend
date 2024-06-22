<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// userRegister
Route::post('/user/register', [App\Http\Controllers\Api\AuthController::class, 'UserRegister']);

// restauren register
Route::post('/restaurant/register', [App\Http\Controllers\Api\AuthController::class,'restaurantRegister']);

// driver register
Route::post('/driver/register', [App\Http\Controllers\Api\AuthController::class,'driverRegister']);

// login
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// logout
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class,'logout'])->middleware('auth:sanctum');

// update latLong
Route::put('/user/update-latlong', [App\Http\Controllers\Api\AuthController::class,'updateLatLong'])->middleware('auth:sanctum');

// get all restaurant
Route::get('/restaurant', [App\Http\Controllers\Api\AuthController::class,'getRestaurant']);

Route::apiResource('/product', App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');

// order
Route::post('/order', [App\Http\Controllers\Api\OrderController::class,'createNewOrder'])->middleware('auth:sanctum');

// get orderHistory by user id
Route::get('/order/user', [App\Http\Controllers\Api\OrderController::class,'orderHistory'])->middleware('auth:sanctum');

// get order by Status
Route::get('/order/restaurant', [App\Http\Controllers\Api\OrderController::class,'getOrderByStatus'])->middleware('auth:sanctum');

// get order by driver id
Route::get('/order/driver', [App\Http\Controllers\Api\OrderController::class,'getOrderByStatusDriver'])->middleware('auth:sanctum');

// update order status
Route::put('/order/restaurant/update/{id}', [App\Http\Controllers\Api\OrderController::class,'updateOrderStatus'])->middleware('auth:sanctum');

// update order status driver
Route::put('/order/driver/update/{id}', [App\Http\Controllers\Api\OrderController::class,'updateOrderStatusReadyForDelivery'])->middleware('auth:sanctum');

// update purchase status
Route::put('/order/user/update/{id}', [App\Http\Controllers\Api\OrderController::class,'updatePurchaseStatus'])->middleware('auth:sanctum');
