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
            $table->string('username',30)->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_active')->default('1');
            $table->boolean('is_admin')->default('0');
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });

        Schema::create('usermeta', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(); 
            $table->string('meta_key')->unique()->nullable();
            $table->longText('meta_value',30)->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usermeta');
        Schema::dropIfExists('users');
    }
};
