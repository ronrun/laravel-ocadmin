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
            $table->string('code',20)->unique()->nullable();//編號
            $table->string('username',30)->unique()->nullable();//帳號
            $table->string('name'); //姓名
            $table->string('first_name')->nullable(); //名
            $table->string('last_name')->nullable(); //姓
            $table->string('mobile', 20)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_photo_path', 2048)->nullable();

            $table->string('shipping_country_code', 10)->nullable();
            $table->string('shipping_postal_code', 10)->nullable();
            $table->unsignedBigInteger('shipping_div1_id')->nullable();
            $table->unsignedBigInteger('shipping_div2_id')->nullable();
            $table->string('shipping_address1', 200)->nullable();
            $table->string('shipping_address2', 200)->nullable();
            $table->string('shipping_recipient', 50)->nullable();
            $table->string('shipping_phone', 20)->nullable();

            $table->boolean('is_active')->default('1');
            $table->boolean('is_admin')->default('0');
            $table->rememberToken();
            $table->softDeletes();
            
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_metas', function (Blueprint $table) {
            //$table->id();
            $table->unsignedInteger('user_id');
            $table->string('locale',10);
            $table->string('meta_key');
            $table->longText('meta_value')->default('')->nullable();
            //$table->unique(['locale', 'user_id','meta_key']);
            $table->primary(['user_id', 'locale', 'meta_key']);
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_metas');
        Schema::dropIfExists('users');
    }
};
