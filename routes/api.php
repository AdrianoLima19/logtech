<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtAuthMiddleware;
use App\Http\Controllers\JwtAuthController;

Route::controller(JwtAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::middleware(JwtAuthMiddleware::class)->group(function () {
        Route::get('profile', 'profile');
        Route::post('logout', 'logout');
    });
});
