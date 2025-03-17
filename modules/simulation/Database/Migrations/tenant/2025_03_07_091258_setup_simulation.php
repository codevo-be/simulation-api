<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('simulations', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('spreadsheet_id', 50)->nullable();
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
            $table->id();
            $table->uuid('simulation_id');
            $table->string('label', 100);
            $table->unique(['simulation_id', 'label'], 'unique_simulation_question_ids');
            $table->string('response', 255);
            $table->timestamps();

            $table->foreign('simulation_id')->references('id')->on('simulations');
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
