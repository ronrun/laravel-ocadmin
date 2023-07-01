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
        Schema::create('product_term_headers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('term_id');
            $table->timestamps();
        });

        Schema::create('product_term_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('product_term_header_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('header_term_id');
            $table->timestamps();
        });

        Schema::create('product_term_item_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('item_term_id');
            $table->timestamps();
        });

        Schema::create('product_term_header_meta', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('term_id');
            $table->string('meta_key');
            $table->longText('meta_value');
            $table->unique(['product_id', 'term_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_term_header_meta');
        Schema::dropIfExists('product_term_item_relations');
        Schema::dropIfExists('product_term_header_relations');
        Schema::dropIfExists('product_term_items');
        Schema::dropIfExists('product_term_headers');
    }
};
