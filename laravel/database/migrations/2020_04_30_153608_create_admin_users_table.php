<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30)->unique();
            $table->string('nickname',50);
            $table->string('password',50);
            $table->string('open-passwd',50);
            $table->unsignedInteger('role_id')->default(0)->comment('角色id')->index();
            $table->string('tell',50)->default('');
            $table->string('email',50)->default('');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 禁用，1 启用，2 删除');
            $table->string('avatar')->comment('头像')->default('');
            $table->string('remember_token')->default('')->unique();
            $table->unsignedInteger('last_login_time')->default(0);
            $table->string('last_login_ip')->default('');
            $table->unsignedInteger('crate_time')->default(0);
            $table->unsignedInteger('update_time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
