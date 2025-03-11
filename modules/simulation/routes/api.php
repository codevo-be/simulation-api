<?php

use DigicoSimulation\Http\Controllers\SimulationController;
use \Illuminate\Support\Facades\Route;

Route::group([
   'prefix' => 'api',
], function () {
    Route::middleware(['auth:api', "auth.tenant"])->group(function () {
        Route::resource("/simulation", SimulationController::class)->only(['show', 'store',  'update']);
    });
});
