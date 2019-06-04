<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id号');
            $table->string('username')->comment('账号');
            $table->tinyInteger('sms_type')->default(1)->comment('类型1手机号 2邮箱');
            $table->tinyInteger('type')->default(1)->comment('类型1注册通知2重置密码等');
            $table->string('code', 6)->nullable()->comment('验证码');
            $table->tinyInteger('status')->default(0)->comment('发送状态0 失败 1成功');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
