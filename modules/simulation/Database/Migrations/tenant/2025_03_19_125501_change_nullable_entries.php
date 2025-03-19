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
        Schema::table("simulation_entries", function (Blueprint $table) {
            $table->string('response')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('simulation_entries', function (Blueprint $table) {
            $table->string('response')->nullable(false)->change();  // Make the column NOT NULL again
        });
    }
};
