<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'api',
], function () {
    Route::middleware(["auth:api","auth.tenant"])->group(function(){
        /* Invoice */
        Route::resource("/invoices", Diji\Billing\Http\Controllers\InvoiceController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
        Route::resource("/invoices/{invoice}/items", \Diji\Billing\Http\Controllers\BillingItemController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::delete("/invoices/batch", [\Diji\Billing\Http\Controllers\InvoiceController::class, "batchDestroy"]);
        Route::get("/invoices/{invoice}/pdf", [\Diji\Billing\Http\Controllers\InvoiceController::class, "pdf"]);
        Route::post("/invoices/{invoice}/email", [\Diji\Billing\Http\Controllers\InvoiceController::class, "email"]);

        /* Credit note */
        Route::resource("/credit-notes", Diji\Billing\Http\Controllers\CreditNoteController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
        Route::resource("/credit-notes/{credit_note}/items", \Diji\Billing\Http\Controllers\BillingItemController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get("/credit-notes/{credit_note}/pdf", [\Diji\Billing\Http\Controllers\CreditNoteController::class, "pdf"]);
        Route::post("/credit-notes/{credit_note}/email", [\Diji\Billing\Http\Controllers\CreditNoteController::class, "email"]);

        Route::get("/nordigen/institutions", [\Diji\Billing\Http\Controllers\NordigenController::class, 'institutions']);
    });
});

Route::get("/nordigen/callback", [\Diji\Billing\Http\Controllers\NordigenController::class, 'handleCallback']);
