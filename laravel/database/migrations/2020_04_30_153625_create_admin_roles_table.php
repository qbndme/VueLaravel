<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('code')->unique()->comment('角色code');
            $table->string('name', 30)->unique();
            $table->unsignedTinyInteger('status')->default(0);
            $table->string('introduction')->default('');
            $table->string('operator')->default('');
            $table->string('operate_ip')->default('');
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
        Schema::dropIfExists('admin_roles');
    }
}
