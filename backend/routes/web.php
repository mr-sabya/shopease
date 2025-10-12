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
});
