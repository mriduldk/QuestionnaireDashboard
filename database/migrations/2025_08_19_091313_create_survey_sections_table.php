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
        Schema::create('survey_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');                       // e.g. "Demographic Information"
            $table->unsignedBigInteger('survey_id');       // FK to surveys table
            $table->json('components');                    // Store all component definitions as JSON
            $table->timestamps();

            // If you have surveys table
            $table->foreign('survey_id')
                  ->references('id')->on('surveys')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_sections');
    }
};
