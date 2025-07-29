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
        Schema::create('survey_answer_images', function (Blueprint $table) {
            $table->id();
            $table->uuid('survey_answer_id');
            $table->string('image_url');
            $table->string('caption')->nullable();
            $table->timestamps();

            $table->foreign('survey_answer_id')
                ->references('survey_answer_id')
                ->on('survey_answers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_answer_images');
    }
};
