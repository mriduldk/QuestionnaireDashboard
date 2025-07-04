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
        Schema::create('location_histories', function (Blueprint $table) {
            $table->uuid('location_history_id')->primary();
            $table->uuid('user_id')->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->string('created_at');
            $table->string('updated_at')->nullable();
            $table->boolean('updated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_histories');
    }
};
