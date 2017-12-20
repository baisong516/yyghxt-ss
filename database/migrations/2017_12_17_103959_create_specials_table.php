<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id')->comment('科室');
            $table->string('name')->comment('页面名称');
            $table->string('url')->comment('页面路径');
            $table->json('type')->comment('病种|词性|类别');
            $table->timestamp('change_date')->nullable()->comment('更换链接时间');
            $table->timestamps();
        });
        Schema::create('specialtrans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('special_id')->comment('专题id');
            $table->string('cost')->comment('消费');
            $table->unsignedInteger('click')->comment('点击');
            $table->unsignedInteger('show')->comment('展现');
            $table->unsignedInteger('view')->comment('唯一身份浏览量');
            $table->string('skip_rate')->comment('跳出率');
            $table->unsignedInteger('swt_lg_one')->comment('商务通大于等于1');
            $table->unsignedInteger('swt_lg_three')->comment('商务通大于等于3');
            $table->string('click_trans_rate')->comment('点击转化率');
            $table->unsignedInteger('yuyue')->comment('预约');
            $table->unsignedInteger('arrive')->comment('到院');
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
        Schema::dropIfExists('specials');
        Schema::dropIfExists('specialtrans');
    }
}
