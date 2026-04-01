<?php

use App\Http\Controllers\Admin\{
    CustomerController,
    OrderController,
    OrderItemController,
    ProductController,
    UserController
};
use App\Http\Controllers\{
    AuthController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('auth.register');
    Route::post('login', 'login')->name('auth.login');
    Route::post('forgotPassword', 'forgotPassword')->name('auth.forgotPassword');
    Route::post('resetPassword', 'resetPassword')->name('auth.resetPassword');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function() {
        Route::post('logout', 'logout')->name('auth.logout');
        Route::post('changePassword', 'changePassword')->name('auth.changePassword');
    });

    // Profile
    Route::prefix('profile')->controller(ProfileController::class)->group(function() {
        Route::get('', 'index')->name('profile.index');
        Route::put('', 'update')->name('profile.update');
        Route::post('', 'uploadAvatar')->name('profile.uploadAvatar');
    });

    // ── ADMIN ONLY
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    });

    // ── ADMIN + MANAGER
    Route::middleware('role:admin,manager')->group(function () {

        // Product
        Route::prefix('product')->controller(ProductController::class)->group(function() {
            Route::get('', 'index')->name('product.index');
            Route::post('', 'create')->name('product.create');
            Route::prefix('{product_id}')->group(function() {
                Route::get('', 'read')->name('product.read');
                Route::put('', 'update')->name('product.update');
                Route::delete('', 'delete')->name('product.delete');
            });
        });

        // Customer
        Route::prefix('customer')->controller(CustomerController::class)->group(function() {
            Route::get('', 'index')->name('customer.index');
            Route::post('', 'create')->name('customer.create');
            Route::prefix('{customer_id}')->group(function() {
                Route::get('', 'read')->name('customer.read');
                Route::put('', 'update')->name('customer.update');
                Route::delete('', 'delete')->name('customer.delete');
            });
        });

        // Order
        Route::prefix('order')->controller(OrderController::class)->group(function() {
            Route::get('', 'index')->name('order.index');
            Route::post('', 'create')->name('order.create');
            Route::prefix('{order_id}')->group(function() {
                Route::get('', 'read')->name('order.read');
                Route::put('', 'update')->name('order.update');
                Route::delete('', 'delete')->name('order.delete');

                // Order Items
                Route::prefix('items')->controller(OrderItemController::class)->group(function() {
                    Route::get('', 'index')->name('orderItem.items.index');
                    Route::post('', 'create')->name('orderItem.items.create');
                    Route::prefix('{item_id}')->group(function() {
                        Route::get('', 'read')->name('orderItem.items.read');
                        Route::put('', 'update')->name('orderItem.items.update');
                        Route::delete('', 'delete')->name('orderItem.items.delete');
                    });
                });
            });
        });
    });
});