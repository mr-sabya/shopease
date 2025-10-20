<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

Route::middleware('auth:admin')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Settings
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');

    Route::name('product.')->group(function () {

        // categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('create');
            Route::get('/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('edit');
        });

        // brands
        Route::get('/brands', [App\Http\Controllers\HomeController::class, 'brands'])->name('brands.index');

        // coupons
        Route::prefix('coupons')->name('coupons.')->group(function () {
            Route::get('/', [App\Http\Controllers\CouponController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\CouponController::class, 'create'])->name('create');
            Route::get('/{coupon}/edit', [App\Http\Controllers\CouponController::class, 'edit'])->name('edit');
        });

        // tags
        Route::get('/tags', [App\Http\Controllers\HomeController::class, 'tags'])->name('tags.index');

        // products
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('create');
            Route::get('/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
        });
    });


    Route::name('users.')->group(function () {
        // customers
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [App\Http\Controllers\UserController::class, 'customers'])->name('index');
            Route::get('/create', [App\Http\Controllers\UserController::class, 'createCustomer'])->name('create');
            Route::get('/{id}/edit', [App\Http\Controllers\UserController::class, 'editCustomer'])->name('edit');
        });


        // investors
        Route::prefix('investors')->name('investors.')->group(function () {
            Route::get('/', [App\Http\Controllers\UserController::class, 'investors'])->name('index');
            Route::get('/create', [App\Http\Controllers\UserController::class, 'createInvestor'])->name('create');
            Route::get('/{id}/edit', [App\Http\Controllers\UserController::class, 'editInvestor'])->name('edit');
        });


        // vendors
        Route::prefix('vendors')->name('vendors.')->group(function () {
            Route::get('/', [App\Http\Controllers\UserController::class, 'vendors'])->name('index');
            Route::get('/create', [App\Http\Controllers\UserController::class, 'createVendors'])->name('create');
            Route::get('/{id}/edit', [App\Http\Controllers\UserController::class, 'editVendors'])->name('edit');
        });
    });



    // locations
    Route::prefix('locations')->name('locations.')->group(function () {
        Route::get('/countries', [App\Http\Controllers\LocationController::class, 'countries'])->name('countries');
        Route::get('/states', [App\Http\Controllers\LocationController::class, 'states'])->name('states');
        Route::get('/cities', [App\Http\Controllers\LocationController::class, 'cities'])->name('cities');
    });

    // investment
    Route::prefix('investment')->name('investment.')->group(function () {
        Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
        Route::get('/investments', [App\Http\Controllers\InvestmentController::class, 'index'])->name('investments.index');
    });

    // attributes
    Route::prefix('attributes')->name('attribute.')->group(function () {
        Route::get('/', [App\Http\Controllers\AttributeController::class, 'attributes'])->name('attributes.index');
        Route::get('/attribute-values', [App\Http\Controllers\AttributeController::class, 'attributeValues'])->name('attribute-values.index');
        Route::get('/attribute-sets', [App\Http\Controllers\AttributeController::class, 'attributeSets'])->name('attribute-sets.index');
    });

    // website
    Route::prefix('website')->name('website.')->group(function () {
        // banners
        Route::get('/banners', [App\Http\Controllers\WebsiteController::class, 'banners'])->name('banner.index');
    });

    // orders
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');

    // deals
    Route::prefix('deals')->name('deal.')->group(function () {
        Route::get('/', [App\Http\Controllers\DealController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\DealController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [App\Http\Controllers\DealController::class, 'edit'])->name('edit');
    });
});
