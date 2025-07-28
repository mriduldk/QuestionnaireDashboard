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
        Schema::table('users', function (Blueprint $table) {
            $table->string('district')->nullable()->after('survey_id');
            $table->string('sub_division')->nullable()->after('district');
            $table->string('block')->nullable()->after('sub_division');
            $table->string('vcdc')->nullable()->after('block');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['district', 'sub_division', 'block', 'vcdc']);
        });
    }
};
