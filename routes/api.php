<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/register', 'register')->middleware('guest');
    Route::post('auth/login', 'login')->middleware('guest');
    Route::post('auth/logout', 'logout')->middleware('user');
});

Route::controller(UserController::class)->middleware('user')->group(function () {
    Route::get('user/profile', 'show');
    Route::put('user/profile', 'update');
    Route::delete('user/profile', 'destroy');
});

Route::controller(BrandController::class)->group(function () {
    Route::middleware('user')->group(function () {
        Route::get('brands/all', 'all');
        Route::get('brands', 'index');
        Route::get('brands/{brand}', 'show');
    });

    Route::middleware('admin')->group(function () {
        Route::post('brands', 'store');
        Route::put('brands/{brand}', 'update');
        Route::delete('brands/{brand}', 'destroy');
    });
});

Route::controller(CategoryController::class)->group(function () {
    Route::middleware('user')->group(function () {
        Route::get('categories/all', 'all');
        Route::get('categories', 'index');
        Route::get('categories/{category}', 'show');
    });

    Route::middleware('admin')->group(function () {
        Route::post('categories', 'store');
        Route::put('categories/{category}', 'update');
        Route::delete('categories/{category}', 'destroy');
    });
});

Route::controller(ProductController::class)->group(function () {
    Route::middleware('user')->group(function () {
        Route::get('products/all', 'all');
        Route::get('products', 'index');
        Route::get('products/{product}', 'show');
    });

    Route::middleware('admin')->group(function () {
        Route::post('products', 'store');
        Route::put('products/{product}', 'update');
        Route::delete('products/{product}', 'destroy');
    });
});
