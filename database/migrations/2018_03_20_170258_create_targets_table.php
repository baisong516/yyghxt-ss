<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //年度经营计划表
        Schema::create('targets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id')->comment('科室');
            $table->unsignedInteger('year')->comment('年');
            $table->unsignedInteger('month')->comment('月');
            $table->float('cost')->comment('消费/广告宣传');
            $table->unsignedInteger('show')->default(0)->comment('展现');
            $table->unsignedInteger('click')->default(0)->comment('点击');
            $table->unsignedInteger('achat')->default(0)->comment('总对话');
            $table->unsignedInteger('chat')->default(0)->comment('有效对话');
            $table->unsignedInteger('yuyue')->default(0)->comment('总预约');
            $table->unsignedInteger('arrive')->default(0)->comment('总到院');
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
        Schema::dropIfExists('targets');
    }
}
