<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique()->nullable();
            $table->unsignedInteger('identifier_number')->nullable();
            $table->enum('status', \Diji\Billing\Models\CreditNote::STATUSES)->default(\Diji\Billing\Models\CreditNote::STATUS_DRAFT);
            $table->json('issuer')->nullable();
            $table->date("date");
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->decimal('subtotal', 10)->default(0)->nullable();
            $table->json('taxes')->nullable();
            $table->decimal('total', 10)->default(0)->nullable();

            $table->string('contact_name')->nullable();
            $table->string("vat_number", 12)->nullable();
            $table->string("email", 150)->nullable();
            $table->string("phone", 150)->nullable();

            $table->string("street")->nullable();
            $table->string("street_number", 100)->nullable();
            $table->string("city")->nullable();
            $table->string("zipcode", 50)->nullable();
            $table->string("country", 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_notes');
    }
};
