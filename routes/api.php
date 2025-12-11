<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\OrderApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Product API Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductApiController::class, 'index'])->name('api.products.index');
    Route::get('/{id}', [ProductApiController::class, 'show'])->name('api.products.show');
    Route::get('/category/{category}', [ProductApiController::class, 'byCategory'])->name('api.products.by-category');
});

// Category API Routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryApiController::class, 'index'])->name('api.categories.index');
    Route::get('/{id}', [CategoryApiController::class, 'show'])->name('api.categories.show');
});

// Review API Routes
Route::prefix('reviews')->group(function () {
    Route::get('/', [ReviewApiController::class, 'index'])->name('api.reviews.index');
    Route::get('/product/{productId}', [ReviewApiController::class, 'byProduct'])->name('api.reviews.by-product');
    Route::get('/{id}', [ReviewApiController::class, 'show'])->name('api.reviews.show');
});

// Order API Routes (authentication checked in controller)
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderApiController::class, 'index'])->name('api.orders.index');
    Route::get('/{id}', [OrderApiController::class, 'show'])->name('api.orders.show');
});


