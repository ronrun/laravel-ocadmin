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
            $table->unsignedInteger('parent_id');
            $table->string('slug',200);
            $table->string('post_status',20)->comment('publish:發佈; draft:草稿; pending:等待審核; private:私密文章; future:未來發布; inherit:繼承');
            $table->string('comment_status',20)->comment('open:開放; closed:關閉');
            $table->string('post_type',20)->comment('page:頁面; post:文章; revision:修訂記錄; attachment:附件');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('post_metas', function (Blueprint $table) {
            $table->id();
            $table->string('locale',10);
            $table->unsignedInteger('post_id');
            $table->string('meta_key');
            $table->longText('meta_value')->default('');
            $table->softDeletes();
            $table->unique(['post_id','locale','meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
