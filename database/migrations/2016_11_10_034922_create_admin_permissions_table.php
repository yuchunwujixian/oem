<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('权限名');
            $table->string('label')->comment('权限解释名称');
            $table->string('description')->comment('描述与备注');
            $table->tinyInteger('cid')->comment('级别');
            $table->string('icon')->comment('图标');
            $table->tinyInteger('is_menu')->default(0)->comment('是否菜单 0否 1是');
            $table->string('params')->nullable()->comment('额外参数，直接字符串拼接');
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
        Schema::dropIfExists('admin_permissions');
    }
}
