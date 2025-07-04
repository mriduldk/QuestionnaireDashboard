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
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->uuid('survey_answer_id')->primary();

            $table->string('district')->nullable();
            $table->string('sub_division')->nullable();
            $table->string('block')->nullable();
            $table->string('vcdc')->nullable();
            $table->string('village')->nullable();

            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('voter_id')->nullable();
            $table->string('caste')->nullable();

            $table->json('house_hold_member')->nullable();
            $table->string('house_hold_member_other')->nullable();

            $table->json('household_livelihood_activities')->nullable();
            $table->string('household_livelihood_activity_other')->nullable();

            $table->string('average_annual_income')->nullable();

            $table->string('status')->nullable(); // Assuming it's an enum stored as string
            $table->uuid('user_id')->nullable();
            
            $table->timestamps(); // created_at and updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_answers');
    }
};
