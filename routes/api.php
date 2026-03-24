<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {

    // Public routes
    Route::post('login', [AuthController::class, 'login'])
        ->name('auth.login');

    // End of Public routes


    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('logout', [AuthController::class, 'logout'])
            ->name('auth.logout');

        Route::get('me', [AuthController::class, 'me'])
            ->name('auth.me');

        Route::apiResource('users', UserController::class);
    });

});
