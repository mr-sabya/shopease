<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Public routes for banners (no authentication needed for simple gets)
Route::middleware(['api.key'])->group(function () {
    Route::prefix('categories')->group(function () {
        // Specific endpoint for top/homepage categories
        // Access at: /api/categories/top
        Route::get('/top', [\App\Http\Controllers\Api\CategoryController::class, 'topCategories']);

        // General category listing (can be used for more flexible lists if needed)
        // Access at: /api/categories
        Route::get('/', [\App\Http\Controllers\Api\CategoryController::class, 'index']);

        // Endpoint for a single category page (by slug)
        // Access at: /api/categories/{slug}
        Route::get('/{slug}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);
    });



    // --- Products API Routes ---
    Route::prefix('products')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\ProductController::class, 'index']); // All products (shop page)
        Route::get('/top', [\App\Http\Controllers\Api\ProductController::class, 'topProducts']); // Top 10 products
        Route::get('/recently-viewed', [\App\Http\Controllers\Api\ProductController::class, 'recentlyViewedProducts']); // Recently viewed
        Route::get('/{slug}', [\App\Http\Controllers\Api\ProductController::class, 'show']); // Single product by slug
    });

    // --- Other API routes can go here ---
    // Example for the Banner API
    Route::prefix('banners')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\BannerController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Api\BannerController::class, 'show']);
    });


    // --- Deals API Routes ---
    Route::prefix('deals')->group(function () {
        Route::get('/featured', [\App\Http\Controllers\Api\DealController::class, 'getFeaturedDeal']);
        Route::get('/best', [\App\Http\Controllers\Api\DealController::class, 'getBestDeals']);
    });
});
