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
            $table->date('op_date')->comment('����');
            $table->integer('login_num')->comment('��¼��');
            $table->integer('register_num')->comment('ע����');
            $table->integer('read_num')->comment('������');
            $table->integer('comment_num')->comment('������');
            $table->integer('zan_num')->comment('������');
            $table->integer('article_write_num')->comment('������');
            $table->integer('article_check_ok_num')->comment('���ͨ����');
            $table->integer('article_check_not_ok_num')->comment('���δͨ����');
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
