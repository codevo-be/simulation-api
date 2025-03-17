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
        Schema::rename("questions", "simulation_inputs");

        Schema::table("simulation_inputs", function (Blueprint $table) {
            $table->string('cell_reference')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('simulation_inputs', 'questions');

        Schema::table('questions', function (Blueprint $table) {
            $table->string('cell_reference')->nullable(false)->change();  // Make the column NOT NULL again
        });
    }
};
