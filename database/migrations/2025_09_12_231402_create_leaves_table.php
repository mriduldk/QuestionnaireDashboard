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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id(); // auto-increment int
            $table->string('leave_application_id')->unique();
            $table->date('date_from');
            $table->date('date_to');
            $table->string('leave_type');
            $table->string('attachment')->nullable();
            $table->text('reason');

            $table->string('submitted_by'); // user_id (FK)
            $table->timestamp('submitted_on')->nullable();

            $table->boolean('is_deleted')->default(false);
            $table->integer('is_approved')->default(0);
            $table->text('remarks')->nullable();

            $table->string('approved_by')->nullable(); // user_id (FK)
            $table->timestamp('approved_on')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
