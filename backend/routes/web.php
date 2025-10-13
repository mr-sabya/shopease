<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

Route::middleware('auth:admin')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Settings
    Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings.index');

    // categories
    Route::get('/categories', [App\Http\Controllers\HomeController::class, 'categories'])->name('categories.index');
    Route::get('/categories/create', [App\Http\Controllers\HomeController::class, 'addCategory'])->name('categories.create');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\HomeController::class, 'editCategory'])->name('categories.edit');

    // brands
    Route::get('/brands', [App\Http\Controllers\HomeController::class, 'brands'])->name('brands.index');

    // coupons
    Route::get('/coupons', [App\Http\Controllers\HomeController::class, 'coupons'])->name('coupons.index');
    Route::get('/coupons/create', [App\Http\Controllers\HomeController::class, 'createCoupon'])->name('coupons.create');

    // tags
    Route::get('/tags', [App\Http\Controllers\HomeController::class, 'tags'])->name('tags.index');
});
