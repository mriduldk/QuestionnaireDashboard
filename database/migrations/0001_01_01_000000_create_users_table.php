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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 36);
            $table->string('name', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->boolean('is_email_verified')->nullable()->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('otp', 4)->nullable();
            $table->timestamp('otp_valid_upto')->nullable();
            $table->text('fcm_token')->nullable();
            $table->text('access_token')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('is_delete')->nullable()->default(false);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
