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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('is_active')->default('1');
            $table->timestamps();
        });

        Schema::create('term_metas', function (Blueprint $table) {
            $table->id();
            $table->string('locale',10);
            $table->unsignedInteger('term_id');
            $table->string('meta_key');
            $table->longText('meta_value',30)->default('');
            $table->softDeletes();
            $table->unique(['term_id','locale','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_metas');
        Schema::dropIfExists('terms');
    }
};
