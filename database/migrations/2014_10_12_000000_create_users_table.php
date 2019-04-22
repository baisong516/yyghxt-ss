<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //日志表
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('path');
            $table->string('method', 10);
            $table->string('ip', 15);
            $table->text('input');
            $table->index('user_id');
            $table->timestamps();
        });
        //用户
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('realname')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->smallInteger('is_active')->default(1);
            $table->smallInteger('is_online')->default(0);
            $table->unsignedInteger('department_id')->nullable()->comment('所在部门');
            $table->string('qq')->nullable();
            $table->string('phone')->nullable();
            $table->string('wechat')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        //医院
        Schema::create('hospitals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('tel')->nullable();
            $table->string('qq')->nullable();
            $table->string('wechat')->nullable();
            $table->string('addr')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        //用户与医院多对多
        Schema::create('user_hospital', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('hospital_id');
            $table->timestamps();
        });
        //项目（科室）表
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hospital_id');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('tel')->nullable();
            $table->index('hospital_id');
            $table->timestamps();
        });
        //项目（科室）与用户多对多
        Schema::create('user_office', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('office_id');
            $table->index(['user_id','office_id']);
            $table->timestamps();
        });
        //病种
        Schema::create('diseases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hospital_id')->comment('所属医院');
            $table->unsignedInteger('office_id')->comment('所属科室');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->index(['hospital_id','office_id']);
            $table->timestamps();
        });
        //医生
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hospital_id')->comment('所属医院');
            $table->unsignedInteger('office_id')->comment('所属科室');
            $table->string('name');
            $table->string('display_name');
            $table->string('doctor_number')->nullable()->comment('专家号');
            $table->text('description')->nullable();
            $table->index(['hospital_id','office_id']);
            $table->timestamps();
        });
        //部门表
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        //媒体类型
        Schema::create('medias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        //网站类型
        Schema::create('web_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        //患者类型
        Schema::create('customer_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        //患者状态
        Schema::create('customer_conditions', function (Blueprint $table) {
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
        Schema::dropIfExists('operations');
        Schema::dropIfExists('users');
        Schema::dropIfExists('hospitals');
        Schema::dropIfExists('user_hospital');
        Schema::dropIfExists('offices');
        Schema::dropIfExists('user_office');
        Schema::dropIfExists('diseases');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('medias');
        Schema::dropIfExists('web_types');
        Schema::dropIfExists('customer_types');
        Schema::dropIfExists('customer_conditions');
    }
}
