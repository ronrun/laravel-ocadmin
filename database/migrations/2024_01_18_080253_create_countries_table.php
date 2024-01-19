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
        if (!Schema::connection('sysdata')->hasTable('countries')) {
            Schema::connection('sysdata')->create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('code',2);
                $table->string('name',128); //English name
                $table->string('native_name',128)->nullable();
                $table->string('iso_code_3',3)->comment('ISO 3166-1 3-letter code');
                $table->boolean('postal_code_required')->default('0');            
                $table->boolean('is_active')->default('1');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sysdata')->dropIfExists('countries');
    }
};
