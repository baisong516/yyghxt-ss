<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('order','OrderController@index');

Auth::routes();

Route::any('wechat','WechatController@index');


Route::group(['middleware' => ['auth','operationlog']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home', 'HomeController@index')->name('home.search');
    //排班
    Route::resource('arrangements', 'ArrangementController');
    //用户菜单
    Route::group(['prefix' => 'sys','middleware'=>['role:administrator|superadministrator']],function(){
        Route::resource('users','UserController');
        Route::resource('roles','RoleController');
        Route::resource('permissions','PermissionController');
        Route::resource('departments','DepartmentController');
    });
    //个人资料
    Route::get('/sys/profiles/{user}','ProfileController@edit')->name('profiles.edit');
    Route::put('/sys/profiles/{user}','ProfileController@update')->name('profiles.update');
    //系统设置（医院 科室 医生 媒体设置）
    Route::group(['prefix' => 'sysconf'],function(){
        Route::resource('hospitals','HospitalController');
        Route::resource('offices','OfficeController');
        Route::resource('diseases','DiseaseController');
        Route::resource('doctors','DoctorController');
        Route::resource('medias','MediaController');
        Route::resource('webtypes','WebTypeController');
        Route::resource('customertypes','CustomerTypeController');
        Route::resource('customerconditions','CustomerConditionController');
    });
    //咨询
    Route::group(['prefix' => 'zx'],function(){
        Route::resource('zxcustomers','ZxCustomerController');
        Route::post('zxcustomersearch','ZxCustomerController@customerSearch')->name('zxcustomers.search');
        Route::resource('huifangs','HuifangController');
	    Route::get('summaries','ZxCustomerController@summary')->name('summaries.index');
	    Route::post('summaries','ZxCustomerController@summary')->name('summaries.search');
	    Route::get('exportexcel','ExcelController@index')->name('excel.create');
	    Route::post('exportexcel','ExcelController@exportExcel')->name('excel.export');
    });
    //门诊
    Route::group(['prefix' => 'mz'],function(){
        Route::resource('menzhens','MzCustomerController');
        Route::post('mzcustomersearch','MzCustomerController@customerSearch')->name('mzcustomers.search');
    });
    //挂号
    Route::group(['prefix' => 'gh'],function(){
        Route::resource('ghcustomers','GhCustomerController');
        Route::resource('ghhuifangs','GhHuifangController');
        Route::post('ghcustomersearch','GhCustomerController@customerSearch')->name('ghcustomers.search');
    });
    //
    Route::group(['prefix' => 'statistics'],function(){
        Route::resource('buttons','StatisticController');
        Route::post('buttonsearch','StatisticController@search')->name('buttons.search');
    });
});
