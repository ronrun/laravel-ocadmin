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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable()->comment('basically iso 3166');
            $table->string('country_code',2);
            $table->unsignedInteger('parent_id');
            $table->tinyInteger('level');
            $table->string('name',100)->nullable();
            $table->string('english_name',100)->nullable();
            $table->string('postal_code',10)->nullable();
            $table->boolean('is_active')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
};
