<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('op_type')->comment('1发帖 2评帖 3赞帖 4藏帖 5赞评 6回评');
            $table->integer('op_user_id')->comment('操作人id');
            $table->integer('op_user_article_id')->comment('操作人发帖id');
            $table->integer('op_user_comment_id')->comment('操作人评论id');

            $table->integer('article_id')->comment('文章id');
            $table->integer('article_user_id');

            $table->integer('comment_id');
            $table->integer('comment_user_id');
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
        Schema::dropIfExists('dynamics');
    }
}
