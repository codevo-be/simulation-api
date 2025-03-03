<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::middleware(['auth:api', 'auth.tenant'])->prefix('auth')->group(function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'getAuthenticatedUser']);
});

