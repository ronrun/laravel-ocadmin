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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->default('0');
            $table->string('code',50)->nullable();
            $table->unsignedInteger('taxonomy_id');
            $table->string('taxonomy_code',50)->default('')->nullable();
            $table->boolean('is_active')->default('1');
            $table->smallInteger('sort_order')->default('0');
            $table->unsignedInteger('count')->default('0');
            $table->timestamps();
            $table->unique(['taxonomy_code', 'code']);
        });

        // Schema::create('term_translations', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('term_id')->constrained()->onDelete('cascade');
        //     $table->string('locale',5);
        //     $table->string('name');
        //     $table->string('slug')->default('');
        //     $table->longtext('description')->nullable();
        //     $table->unique(['term_id', 'locale']);
        // });

        Schema::create('term_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('object_id');  //id of terms->taxonomy's entity. If product_category, then object_id is product_id, term_id means category_id
            $table->foreignId('term_id')->constrained()->onDelete('cascade');
            $table->index(['term_id','object_id']);
        });

        Schema::create('term_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('term_id')->constrained()->onDelete('cascade');
            $table->string('locale',10)->nullable();
            $table->string('meta_key');
            $table->longText('meta_value')->default('');
            $table->unique(['term_id','locale','meta_key']);
        });

        Schema::create('term_paths', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('term_id');
            $table->unsignedInteger('path_id')->nullable();
            $table->unsignedSmallInteger('level');
            $table->unique(['term_id','path_id']);
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_metas');
        Schema::dropIfExists('term_relations');
        //Schema::dropIfExists('term_translations');
        Schema::dropIfExists('term_paths');
        Schema::dropIfExists('terms');
    }
};
