<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGhHuifangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gh_huifangs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gh_customer_id')->comment('患者id');
            $table->unsignedInteger('now_user_id')->nullable()->comment('本次回访人');
            $table->timestamp('now_at')->nullable()->comment('本次回访日期');
            $table->timestamp('next_at')->nullable()->comment('下次回访日期');
            $table->unsignedInteger('next_user_id')->nullable()->comment('下次回访人');
            $table->text('description')->nullable()->comment('本次回访记录');
            $table->index(['gh_customer_id']);
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
        Schema::dropIfExists('gh_huifangs');
    }
}
