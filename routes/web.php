<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\frontend\contactController;
use App\Http\Controllers\Frontend\BackpacksController;
use App\Http\Controllers\Frontend\CrossbodyController;
use App\Http\Controllers\Frontend\HoboController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ToteController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\ReviewController;
use App\Http\Controllers\Frontend\StaticPagesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ProfileController;

// -----------------------------
// Profile routes (require authentication, but exclude admin)
// -----------------------------
Route::middleware(['auth', 'not.admin'])->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// -----------------------------
// Admin routes (require authentication and admin username)
// -----------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});

// -----------------------------
// Dashboard (requires authentication and admin username)
// -----------------------------
Route::middleware(['auth', 'admin'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// -----------------------------
// Main navigation routes
// -----------------------------
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/contact', [contactController::class, 'home'])->name('contact');
Route::post('/contact', [contactController::class, 'store'])->name('contact.store');
Route::get('/tote', [ToteController::class, 'home'])->name('tote');
Route::get('/cb', [CrossbodyController::class, 'home'])->name('crossbody');
Route::get('/hobo', [HoboController::class, 'home'])->name('hobo');
Route::get('/bp', [BackpacksController::class, 'home'])->name('backpacks');

// -----------------------------
// Static pages
// -----------------------------
Route::get('/terms', [StaticPagesController::class, 'terms'])->name('terms');
Route::get('/returns', [StaticPagesController::class, 'returns'])->name('returns');

// -----------------------------
// Cart routes (exclude admin)
// -----------------------------
Route::middleware(['not.admin'])->group(function () {
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    // Checkout page routes
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/confirm', [CartController::class, 'confirmCheckout'])->name('checkout.confirm');
});

Route::middleware(['not.admin'])->get('/thankyou', function () {
    // Try to get payment method from session, or from the latest order if session is cleared
    $paymentMethod = session('payment_method');
    $orderId = session('orderId');

    // If payment method is not in session, try to get it from the database
    if (!$paymentMethod && $orderId) {
        $order = \App\Models\Order::where('order_number', $orderId)->first();
        if ($order) {
            $paymentMethod = $order->payment_method;
        }
    }

    return view('frontend.thankyou', [
        'paymentMethod' => $paymentMethod,
    ]);
})->name('thankyou');


// Review routes (exclude admin, allow guests) - must be before product detail route
Route::post('/product/{category}/{id}/review', [ReviewController::class, 'store'])->middleware(['not.admin'])->name('reviews.store');

// Product detail page
Route::get('/product/{category}/{id}', [ShopController::class, 'productDetail'])->name('product.detail');

