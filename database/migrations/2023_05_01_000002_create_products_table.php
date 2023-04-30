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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->index()->default('');
            $table->unsignedBigInteger('master_id')->default('0');
            $table->unsignedInteger('sort_order')->default('0');
            $table->string('slug')->default('');
            $table->string('model',20)->default('');
            $table->decimal('quantity', $precision = 13, $scale = 4)->default('0');
            $table->decimal('price', $precision = 13, $scale = 4)->default('0');
            $table->boolean('is_active')->default('1');
            $table->boolean('is_salable')->default('1');
            $table->timestamps();
        });

        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('locale',10);
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->index(['product_id', 'locale']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('products');
    }
};
