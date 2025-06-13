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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['text', 'number', 'radio', 'checkbox', 'select', 'textarea']);
            $table->boolean('is_required')->default(false);
            $table->json('metadata')->nullable(); // for options etc.
            $table->json('conditional_logic')->nullable(); // for conditional show
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
