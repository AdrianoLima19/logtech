<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;

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
