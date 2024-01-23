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
        if (!Schema::connection('sysdata')->hasTable('languages')) {
            Schema::connection('sysdata')->create('languages', function (Blueprint $table) {
                $table->id();
                $table->string('locale',10);
                $table->string('name',100);
                $table->string('native_name',100);
                $table->string('script',20);
                $table->string('regional',10);
                $table->tinyInteger('sort_order');
                $table->boolean('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
