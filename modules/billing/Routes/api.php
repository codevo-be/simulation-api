<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'api',
], function () {
    Route::middleware(["auth:api","auth.tenant"])->group(function(){
        Route::resource("/invoices", Diji\Billing\Http\Controllers\InvoiceController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
        Route::resource("/invoices/{invoice}/items", \Diji\Billing\Http\Controllers\BillingItemController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::delete("/invoices/batch", [\Diji\Billing\Http\Controllers\InvoiceController::class, "batchDestroy"]);
        Route::get("/invoices/{invoice}/pdf", [\Diji\Billing\Http\Controllers\InvoiceController::class, "viewPdf"]);

        Route::get("/nordigen/institutions", [\Diji\Billing\Http\Controllers\NordigenController::class, 'institutions']);
    });
});

Route::get("/nordigen/callback", [\Diji\Billing\Http\Controllers\NordigenController::class, 'handleCallback']);
