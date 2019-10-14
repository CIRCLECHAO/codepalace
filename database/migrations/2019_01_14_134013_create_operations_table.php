<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('op_date')->comment('日期');
            $table->integer('login_num')->comment('登录数');
            $table->integer('register_num')->comment('注册数');
            $table->integer('read_num')->comment('访问数');
            $table->integer('comment_num')->comment('评论数');
            $table->integer('zan_num')->comment('评论数');
            $table->integer('article_write_num')->comment('评论数');
            $table->integer('article_check_ok_num')->comment('审核通过数');
            $table->integer('article_check_not_ok_num')->comment('审核未通过数');
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
