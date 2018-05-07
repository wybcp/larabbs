<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarAndLastLoginAndIntroductionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('last_login_at')->nullable()->comment('最后登录时间');
            $table->string('last_login_ip',15)->nullable()->comment('最后登录ip');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('introduction')->nullable()->comment('用户简介');
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
            $table->dropColumn('last_login_at');
            $table->dropColumn('last_login_ip');
            $table->dropColumn('avatar');
            $table->dropColumn('introduction');
        });
    }
}
