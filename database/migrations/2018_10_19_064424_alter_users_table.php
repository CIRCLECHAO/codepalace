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
            $table->integer('age');

            $table->date('birthday');


            $table->string('province');
            $table->string('country');
            $table->string('city');
            $table->string('citycode');

            $table->string('qq_name');
            /*是否封号*/
            $table->integer('is_close')->default(0);
            /*封号开始时间戳*/
            $table->string('close_start');
            /*封号天数*/
            $table->integer('close_days')->default(0);
            /*等级*/
            $table->integer('level')->default(0);
            /*经验*/
            $table->integer('experience')->default(0);
            /*专家号*/
            $table->integer('is_expert');
            /*牛人*/
            $table->integer('is_fantastic');
            /*QQ_ID*/
            $table->integer('qq_token');


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
