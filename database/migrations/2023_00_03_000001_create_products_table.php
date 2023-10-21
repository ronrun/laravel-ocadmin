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
            $table->string('model', 50)->nullable();
            $table->boolean('is_active')->default('0');
            $table->timestamps();
        });

        // Schema::create('product_translations', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('product_id')->constrained()->onDelete('cascade');
        //     $table->string('locale',10);
        //     $table->string('name')->index()->default('');
        //     $table->string('slug')->default('');
        //     $table->longtext('content')->index()->default('');
        // });

        Schema::create('product_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('locale',10)->nullable();
            $table->string('meta_key');
            $table->longText('meta_value')->default('');
            $table->index(['product_id','locale','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_metas');
        //Schema::dropIfExists('product_translations');
        Schema::dropIfExists('products');
    }
};
