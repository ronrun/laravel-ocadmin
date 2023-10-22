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
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('code',50)->nullable()->unique();
            $table->string('model')->nullable();
            $table->boolean('is_active')->default('1');
            $table->timestamps();
        });

        // Schema::create('taxonomy_translations', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedInteger('taxonomy_id');
        //     $table->string('locale',10)->index();
        //     $table->string('name');
        // });

        Schema::create('taxonomy_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxonomy_id')->constrained()->onDelete('cascade');
            $table->string('locale',10)->nullable();
            $table->string('meta_key');
            $table->longText('meta_value')->default('');
            $table->unique(['taxonomy_id','locale','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomy_metas');
        Schema::dropIfExists('taxonomies');
    }
};
