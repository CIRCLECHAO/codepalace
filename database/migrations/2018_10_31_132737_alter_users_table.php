<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('focus_ids')->comment('��ح������ids ��ע���˵�ids');
            $table->text('fans_ids')->comment('��ح������ids ��ע�ҵ��˵�ids');
            $table->integer('focus_num')->comment('��ע������');
            $table->integer('fans_num')->comment('��˿��');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
