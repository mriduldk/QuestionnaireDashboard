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
        Schema::create('multiple_question_answers', function (Blueprint $table) {
            $table->uuid('multiple_question_answer_id')->primary();
            $table->uuid('question_answer_id');
            $table->uuid('survey_answer_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('survey_id');
            $table->string('type');
            $table->text('answer_text')->nullable();
            $table->boolean('is_answered')->default(false);
            $table->boolean('is_multiple')->default(false);
            $table->integer('sl_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multiple_question_answers');
    }
};
