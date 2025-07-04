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
        Schema::create('question_answers', function (Blueprint $table) {
            $table->uuid('question_answer_id')->primary();
            $table->uuid('survey_answer_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('survey_id');
            $table->string('type');
            $table->text('answer_text')->nullable();
            $table->boolean('is_answered')->default(false);
            $table->uuid('user_id')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_answers');
    }
};
