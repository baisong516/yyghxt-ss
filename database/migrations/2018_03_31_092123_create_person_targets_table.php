<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_targets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id')->comment('科室');
            $table->unsignedInteger('user_id')->comment('咨询员');
            $table->unsignedInteger('year')->comment('年');
            $table->unsignedInteger('month')->comment('月');
            $table->unsignedInteger('chat')->default(0)->comment('有效对话');
            $table->unsignedInteger('contact')->default(0)->comment('留联量');
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
        Schema::dropIfExists('person_targets');
    }
}
