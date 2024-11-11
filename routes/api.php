<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::middleware('auth.guest')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });

    Route::middleware('auth.user')->group(function () {
        Route::get('profile', 'show');
        Route::put('profile', 'update');
        Route::delete('profile', 'delete');
        Route::post('logout', 'logout');
    });
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::middleware('auth.admin')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'search')->whereNumber('id');
        Route::put('/{id}', 'change')->whereNumber('id');
        Route::delete('/{id}', 'remove')->whereNumber('id');
    });
});
