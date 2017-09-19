<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        /*
 * blog_id           博客id    数字       not null    20       int
 * content           评论内容  字符串     not null    255     varchar
 * delete_user_id    删除者id  数字       not null    11      int
 * user_id           用户id    数字       not null    11       int
 */
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_id', false,true)->length(20)->comment('博客id');
            $table->string('content',255)->comment('评价内容');
            $table->integer('user_id', false, true)->length(11)->comment('用户id');
            $table->boolean('is_delete')->comment('是否删除')->default(false);
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
        Schema::dropIfExists('comment');
    }
}
