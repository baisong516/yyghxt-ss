<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //咨询产出  项目	咨询员	咨询量	预约量	留联系	到院量	电话量	预约量	到院量	回访量	预约量	到院量	咨询量	预约量	到院量	就诊量	预约率	到院率	就诊率	咨询转化率
        Schema::create('zxoutputs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('人员');
            $table->unsignedInteger('office_id')->comment('项目');
            $table->unsignedInteger('swt_zixun_count')->comment('swt咨询量');
            $table->unsignedInteger('swt_yuyue_count')->comment('swt预约量');
            $table->unsignedInteger('swt_contact_count')->comment('swt留联量');
            $table->unsignedInteger('swt_arrive_count')->comment('swt到院量');
            $table->unsignedInteger('tel_zixun_count')->comment('tel电话量');
            $table->unsignedInteger('tel_yuyue_count')->comment('tel预约量');
            $table->unsignedInteger('tel_arrive_count')->comment('tel到院量');
            $table->unsignedInteger('hf_zixun_count')->comment('hf回访量');
            $table->unsignedInteger('hf_yuyue_count')->comment('hf预约量');
            $table->unsignedInteger('hf_arrive_count')->comment('hf到院量');
            $table->unsignedInteger('total_zixun_count')->comment('合计咨询量');
            $table->unsignedInteger('total_yuyue_count')->comment('合计预约量');
            $table->unsignedInteger('total_arrive_count')->comment('合计到院量');
            $table->unsignedInteger('total_jiuzhen_count')->comment('合计就诊量');

            $table->string('yuyue_rate')->comment('合计预约率');
            $table->string('arrive_rate')->comment('合计到院率');
            $table->string('jiuzhen_rate')->comment('合计就诊率');
            $table->string('trans_rate')->comment('合计转化率');
            $table->timestamp('date_tag')->comment('日期');
            $table->index(['user_id','office_id']);
            $table->timestamps();
        });
        //竞价产出 项目	竞价员	班次	预算	消费	点击	咨询量	预约量	到院量	咨询成本	预约成本	到院成本
        Schema::create('jjoutputs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('人员');
            $table->unsignedInteger('office_id')->comment('项目');
            $table->integer('rank')->comment('班次');
            $table->decimal('budget')->comment('预算');
            $table->decimal('cost')->comment('消费');
            $table->unsignedInteger('click')->comment('点击');
            $table->unsignedInteger('zixun')->comment('咨询');
            $table->unsignedInteger('yuyue')->comment('预约');
            $table->unsignedInteger('arrive')->comment('到院');
            $table->decimal('zixun_cost')->comment('咨询成本');
            $table->decimal('yuyue_cost')->comment('预约成本');
            $table->decimal('arrive_cost')->comment('到院成本');
            $table->timestamp('date_tag')->comment('日期');
            $table->index(['user_id','office_id']);
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
        Schema::dropIfExists('zxoutputs');
        Schema::dropIfExists('jjoutputs');
    }
}
