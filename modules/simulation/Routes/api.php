<?php

use DigicoSimulation\Http\Controllers\GoogleSheetController;
use \Illuminate\Support\Facades\Route;

Route::group([
   'prefix' => 'api',
], function () {
    Route::middleware(['auth:api', "auth.tenant"])->group(function () {
        Route::resource("/simulation", \DigicoSimulation\Http\Controllers\SimulationController::class);
    });


    Route::get('/test', [GoogleSheetController::class, 'read']);
});
