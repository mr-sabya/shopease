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

    // customers
    Route::get('/customers', [App\Http\Controllers\UserController::class, 'customers'])->name('users.customers.index');

    // create customer
    Route::get('/customers/create', [App\Http\Controllers\UserController::class, 'createCustomer'])->name('users.customers.create');

    // edit customer
    Route::get('/customers/{id}/edit', [App\Http\Controllers\UserController::class, 'editCustomer'])->name('users.customers.edit');

    // investors
    Route::get('/investors', [App\Http\Controllers\UserController::class, 'investors'])->name('users.investors.index');

    // create investor
    Route::get('/investors/create', [App\Http\Controllers\UserController::class, 'createInvestor'])->name('users.investors.create');

    // edit investor
    Route::get('/investors/{id}/edit', [App\Http\Controllers\UserController::class, 'editInvestor'])->name('users.investors.edit');

    // locations
    Route::get('/locations/countries', [App\Http\Controllers\LocationController::class, 'countries'])->name('locations.countries');
    Route::get('/locations/states', [App\Http\Controllers\LocationController::class, 'states'])->name('locations.states');
    Route::get('/locations/cities', [App\Http\Controllers\LocationController::class, 'cities'])->name('locations.cities');
});
