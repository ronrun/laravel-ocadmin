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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_status',20)->default('');
            $table->string('comment_status',20)->default('');
            $table->timestamps();
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('locale',5)->default('');
            $table->string('name')->index()->default('');
            $table->string('slug')->default('');
            $table->longtext('content')->index()->default('');
        });

        Schema::create('post_meta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('meta_key');
            $table->longText('meta_value')->default('');
            $table->index(['post_id','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_meta');
        Schema::dropIfExists('post_translations');
        Schema::dropIfExists('posts');
    }
};
