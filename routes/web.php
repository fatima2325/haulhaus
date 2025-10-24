<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\homeController;
use App\Http\Controllers\frontend\contactController;
use App\Http\Controllers\frontend\backpacksController;
use App\Http\Controllers\frontend\crossbodyController;
use App\Http\Controllers\frontend\hoboController;
use App\Http\Controllers\frontend\shopController;
use App\Http\Controllers\frontend\toteController;
use App\Http\Controllers\frontend\cartController;
use App\Http\Controllers\Frontend\staticPagesController;

// Main navigation
Route::get('/', [homeController::class, 'home']);
Route::get('/shop', [shopController::class, 'shop'])->name('shop');
Route::get('/contact', [contactController::class, 'home']);
Route::get('/tote', [toteController::class, 'home']);
Route::get('/cb', [crossbodyController::class, 'home']);
Route::get('/hobo', [hoboController::class, 'home']);
Route::get('/bp', [backpacksController::class, 'home']);


// Static Pages
Route::get('/terms', [StaticPagesController::class, 'terms']);
Route::get('/returns', [StaticPagesController::class, 'returns']);

// Cart Routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
