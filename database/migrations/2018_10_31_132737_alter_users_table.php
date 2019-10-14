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
            $table->text('focus_ids')->comment('用丨隔开的ids 关注的人的ids');
            $table->text('fans_ids')->comment('用丨隔开的ids 关注我的人的ids');
            $table->integer('focus_num')->comment('关注的数量');
            $table->integer('fans_num')->comment('粉丝数');
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
