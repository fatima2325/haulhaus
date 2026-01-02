<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\AuthApiController;

use App\Http\Controllers\Api\ReviewApiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

// Auth Routes (Login/Register)
Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

// Public Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductApiController::class, 'index']);
    Route::get('/{id}', [ProductApiController::class, 'show']);
    Route::get('/category/{category}', [ProductApiController::class, 'byCategory']);

    // Public Product Reviews
    Route::get('/{id}/reviews', [ReviewApiController::class, 'byProduct']);
});

// Reviews Routes
Route::prefix('reviews')->group(function () {
    Route::get('/', [ReviewApiController::class, 'index']);
    Route::get('/{id}', [ReviewApiController::class, 'show']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryApiController::class, 'index']);
    Route::get('/{id}', [CategoryApiController::class, 'show']);
});

// Protected Routes  (PASSPORT AUTHENTICATION)
Route::middleware('auth:api')->group(function () {


    // Auth
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::get('user', [AuthApiController::class, 'user']);

    // Admin Products (CRUD)
    Route::post('products', [ProductApiController::class, 'store']);
    Route::put('products/{id}', [ProductApiController::class, 'update']);
    Route::delete('products/{id}', [ProductApiController::class, 'destroy']);

    // Admin Categories (CRUD)
    Route::post('categories', [CategoryApiController::class, 'store']);
    Route::put('categories/{id}', [CategoryApiController::class, 'update']);
    Route::delete('categories/{id}', [CategoryApiController::class, 'destroy']);

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderApiController::class, 'index']);
        Route::get('/{id}', [OrderApiController::class, 'show']);
        Route::post('/', [OrderApiController::class, 'store']); // Create order
    });

    // Reviews (Create/Update)
    Route::post('reviews', [ReviewApiController::class, 'store']);
});
