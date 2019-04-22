<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id')->comment('科室');
            $table->string('type')->comment('类型：按病种|按地域|按平台');
            $table->unsignedInteger('type_id');
            $table->string('budget')->comment('预算');
            $table->string('cost')->comment('消费');
            $table->unsignedInteger('click')->default(0)->comment('点击');
            $table->unsignedInteger('zixun')->default(0)->comment('咨询量');
            $table->unsignedInteger('yuyue')->default(0)->comment('预约量');
            $table->unsignedInteger('arrive')->default(0)->comment('总到院');
            $table->string('zixun_cost')->comment('咨询成本');
            $table->string('arrive_cost')->comment('到院成本');
            $table->timestamp('date_tag')->comment('日期');
            $table->timestamps();
        });
        //平台|渠道
        Schema::create('platforms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        //地域
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('auctions');
        Schema::dropIfExists('platforms');
        Schema::dropIfExists('areas');
    }
}
