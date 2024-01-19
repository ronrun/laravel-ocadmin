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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable(); //主分類
            $table->string('code',20)->default('');//品號
            $table->string('slug')->nullable();//網址字串
            $table->string('model',50)->nullable();//型號
            $table->decimal('quantity', $precision = 13, $scale = 4)->nullable();
            $table->decimal('price', $precision = 13, $scale = 4)->nullable();
            $table->boolean('is_active')->default('1');
            $table->boolean('is_salable')->default('1');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_metas', function (Blueprint $table) {
            $table->id();
            $table->string('locale',10);
            $table->unsignedInteger('product_id');
            $table->string('meta_key');
            $table->longText('meta_value',30)->default('');
            $table->softDeletes();
            $table->index(['locale','product_id','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_metas');
        Schema::dropIfExists('products');
    }
};
