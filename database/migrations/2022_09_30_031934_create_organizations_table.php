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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->default('0')->comment('organization_id');
            $table->string('code')->nullable()->unique();
            $table->string('name');
            $table->string('short_name');
            $table->string('country_code',2)->nullable();
            $table->unsignedInteger('corporation_id')->default('0')->comment('anscetor\'s organization_id');
            $table->unsignedInteger('company_id')->default('0')->comment('anscetor\'s organization_id');
            $table->unsignedInteger('brand_id')->default('0')->comment('anscetor\'s organization_id');
            $table->boolean('is_corporation')->default('0')->comment('Is this a corporation, Corp.');
            $table->boolean('is_juridical_entity')->default('0')->comment('Like a company or school, Inc. If 0, maybe a department');
            $table->boolean('is_brand')->default('0')->comment('Generally used for our brand');
            $table->boolean('is_location')->default('0')->comment('');
            $table->boolean('is_ours')->default('0')->comment('');
            $table->boolean('is_active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
};
