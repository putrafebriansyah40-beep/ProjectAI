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
        Schema::create('bugs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('severity');
            $table->integer('impact');
            $table->integer('affected_users');
            $table->decimal('mamdani_score', 5, 2)->nullable();
            $table->string('mamdani_label')->nullable();
            $table->decimal('sugeno_score', 5, 2)->nullable();
            $table->string('sugeno_label')->nullable();
            $table->decimal('tsukamoto_score', 5, 2)->nullable();
            $table->string('tsukamoto_label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bugs');
    }
};
