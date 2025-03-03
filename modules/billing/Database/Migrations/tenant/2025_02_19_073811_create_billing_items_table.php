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
        Schema::create('billing_items', function (Blueprint $table) {
            $table->id();

            $table->smallInteger('position')->default(0);

            $table->morphs('model');
            $table->longText("name");
            $table->integer("quantity")->nullable();
            $table->integer("vat")->default(21);

            $table->json("cost")->nullable();
            $table->json("retail")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_items');
    }
};
