<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);


Route::middleware(['auth.tenant'])->prefix('auth')->group(function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'getAuthenticatedUser']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

