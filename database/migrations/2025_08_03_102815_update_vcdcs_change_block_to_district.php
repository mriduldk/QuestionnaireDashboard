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
        Schema::table('vcdcs', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['block_id']);
            $table->dropColumn('block_id');

            // Add new district_id column
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vcdcs', function (Blueprint $table) {
            // Rollback: drop district_id and re-add block_id
            $table->dropForeign(['district_id']);
            $table->dropColumn('district_id');

            $table->foreignId('block_id')->constrained()->onDelete('cascade');
        });
    }
};
