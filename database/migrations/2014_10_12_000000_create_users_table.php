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
            $table->string('name')->default('');
            $table->string('email')->default('')->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('');
            $table->string('mobile')->default('');
            $table->rememberToken();
            $table->boolean('is_active')->default('1');
            $table->boolean('is_admin')->default('0');
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });

        Schema::create('usermeta', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('meta_key');
            $table->longText('meta_value',30)->default('');
            
            $table->index(['user_id','meta_key']);
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
