<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laravel_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 15)->nullable()->comment('手机号');
            $table->string('code', 6)->nullable()->comment('验证码');
            $table->boolean('status')->default(0)->comment('状态0未使用1已使用');
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
        Schema::dropIfExists('laravel_sms');
    }
}
