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
        Schema::create('simulations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')
                ->nullable()->constrained('contacts')
                ->nullOnDelete();
            $table->enum('status', ['draft', 'completed', 'ordered', 'contacted']);
            $table->string('current_step', 100);
            $table->timestamps();
        });

        Schema::create('questions',  function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->string('cell_reference', 10);
            $table->timestamps();
        });

        Schema::create('simulation_entries',  function (Blueprint $table) {
            $table->id();
            $table->foreignId('simulation_id')->constrained();
            $table->foreignId('question_id')->constrained();
            $table->string('response', 255);
            $table->timestamps();
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
