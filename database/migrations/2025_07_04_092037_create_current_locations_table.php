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
        Schema::create('current_locations', function (Blueprint $table) {
           $table->uuid('current_location_id')->primary();
            $table->uuid('user_id')->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->string('created_at');
            $table->string('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_locations');
    }
};
