<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //按钮数据统计表
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain')->comment('域名');
            $table->string('flag')->comment('所统计按钮标识');
            $table->string('date_tag')->comment('日期标识');
            $table->unsignedInteger('count')->default(0)->comment('点击次数');
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
        Schema::dropIfExists('statistics');
    }
}
