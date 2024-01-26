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
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->unique();
            $table->string('comment')->nullable();
            $table->boolean('is_active')->default('1');
            $table->timestamps();
        });

        Schema::create('taxonomy_metas', function (Blueprint $table) {
            $table->id();
            $table->string('locale',10);
            $table->unsignedInteger('taxonomy_id');
            $table->string('meta_key');
            $table->longText('meta_value',30)->default('');
            $table->softDeletes();
            $table->unique(['taxonomy_id','locale','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxonomy_metas');
        Schema::dropIfExists('taxonomies');
    }
};
