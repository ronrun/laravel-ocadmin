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
        Schema::dropIfExists('role_metas');

        Schema::create('role_metas', function (Blueprint $table) {
            $table->id();
            $table->string('locale',10);
            $table->unsignedInteger('role_id');
            $table->string('meta_key');
            $table->longText('meta_value',30)->default('');
            $table->softDeletes();
            $table->unique(['role_id','locale','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_metas');
    }
};
