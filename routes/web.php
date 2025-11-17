<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes - redirect to products page
Route::redirect('/', '/products');

// Product listing (public, but will show login prompt if not authenticated)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::patch('/{cart}', [CartController::class, 'update'])
            ->name('update')
            ->can('update', 'cart');
        Route::delete('/{cart}', [CartController::class, 'destroy'])
            ->name('destroy')
            ->can('delete', 'cart');
    });

    // Order routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    });
});

require __DIR__.'/auth.php';
