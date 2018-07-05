<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //日期 消费 到院量 展现量 点击 总对话 有效对话 留联系 总预约
        //竞价报表
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id')->comment('科室');
            $table->unsignedInteger('source_id')->comment('竞价来源');
            $table->string('type')->comment('类型：按病种|按地域|按平台');
            $table->unsignedInteger('type_id');
            $table->date('date_tag')->comment('日期');
            $table->float('cost')->comment('消费');
            $table->unsignedInteger('show')->default(0)->comment('展现');
            $table->unsignedInteger('click')->default(0)->comment('点击');
            $table->unsignedInteger('achat')->default(0)->comment('总对话');
            $table->unsignedInteger('chat')->default(0)->comment('有效对话');
            $table->unsignedInteger('contact')->default(0)->comment('留联系');
            $table->unsignedInteger('yuyue')->default(0)->comment('总预约');
            $table->unsignedInteger('arrive')->default(0)->comment('总到院');
            $table->index(['office_id']);
            $table->timestamps();
        });
        //竞价数据来源 健康网站、医疗网站
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
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
        Schema::dropIfExists('reports');
        Schema::dropIfExists('sources');
    }
}
