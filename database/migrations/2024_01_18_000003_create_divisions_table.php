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
        Schema::connection('sysdata')->create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable();
            //$table->unsignedInteger('country_id');
            $table->string('country_code',2)->comment('國別碼 ISO 3166-1');
            $table->tinyInteger('level');
            $table->unsignedInteger('parent_id');
            $table->string('name',100)->nullable();
            $table->string('english_name',100)->nullable();
            $table->string('native_name',100)->nullable();
            $table->string('postal_code',10)->nullable();
            $table->boolean('is_active')->default('1');
            $table->index(['country_code','level','parent_id']);
            $table->unsignedSmallInteger('sort_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sysdata')->dropIfExists('divisions');
    }
};
