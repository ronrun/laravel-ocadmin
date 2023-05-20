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
            $table->string('username',30)->index()->default('');
            $table->string('user_nicename',30)->index()->default('');
            $table->string('display_name',30);
            $table->string('email')->index()->default('');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('');
            $table->rememberToken();
            $table->boolean('is_active')->default('1');
            $table->boolean('is_admin')->default('0');
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });

        Schema::create('user_meta', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('meta_key');
            $table->longText('meta_value')->default('');
            $table->index(['user_id','meta_key']);
        });

        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('ip',40)->default('');
            $table->string('user_agent',40)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logins');
        Schema::dropIfExists('user_meta');
        Schema::dropIfExists('users');
    }
};
