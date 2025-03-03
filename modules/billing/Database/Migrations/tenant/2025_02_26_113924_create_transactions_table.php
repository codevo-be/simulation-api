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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('transaction_id')->unique();
            $table->nullableMorphs('model');
            $table->string('structured_communication', 12)->nullable();
            $table->string('creditor_name');
            $table->string('creditor_account');
            $table->string('debtor_name');
            $table->string('debtor_account');
            $table->decimal('amount', 10);
            $table->json('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
