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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique()->nullable();
            $table->unsignedInteger('identifier_number')->nullable();
            $table->enum('status', \Diji\Billing\Models\Invoice::STATUSES)->default(\Diji\Billing\Models\Invoice::STATUS_DRAFT);
            $table->date("date");
            $table->date("due_date")->nullable();
            $table->date("payment_date")->nullable();
            $table->string("structured_communication", 12)->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
