<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->unique()->nullable(); 
            $table->string('username',30)->unique()->nullable(); 
            $table->string('email')->unique()->nullable(); 
            $table->unsignedInteger('organization_id')->nullable(); 
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile_prefix',5)->nullable(); 
            $table->unsignedInteger('mobile')->nullable(); //max unsigned bit int = 18446744073709551615 total 20 digits, max unsigned int = 4294967295 total 10 digits
            $table->string('job_title',20)->nullable(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default('1');
            $table->boolean('is_admin')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
