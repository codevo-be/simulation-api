<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //TODO mettreun on update update pourles clefs étrangères ?
    {
        Schema::create('simulations', function (Blueprint $table) {
            $table->string('spreadsheet_id', 50)->primary();
            $table->foreignId('contact_id')
                ->nullable()->constrained('contacts')
                ->nullOnDelete();
            $table->enum('status', ['draft', 'completed', 'ordered', 'contacted']);
            $table->string('current_step', 100);
            $table->timestamps();
        });

        Schema::create('questions',  function (Blueprint $table) {
            $table->string('label', 100)->primary();
            $table->string('cell_reference', 10);
            $table->timestamps();
        });

        Schema::create('simulation_entries',  function (Blueprint $table) {
            $table->string('spreadsheet_id', 50);
            $table->string('label', 100);
            $table->unique(['spreadsheet_id', 'label'], 'unique_simulation_question_ids');
            $table->string('response', 255);
            $table->timestamps();

            $table->foreign('spreadsheet_id')->references('spreadsheet_id')->on('simulations');
            $table->foreign('label')->references('label')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulation_entries');
        Schema::dropIfExists('simulations');
        Schema::dropIfExists('questions');
    }
};
