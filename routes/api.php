<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::get('products', [ProductController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('orders', [OrderController::class, 'index']);
    });
});
