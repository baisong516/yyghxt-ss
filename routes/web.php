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
    return view('welcome');
});

Auth::routes();


Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    //排班
//    Route::group(['middleware'=>['role:administrator|superadministrator']],function(){
//        Route::resource('arrangements', 'ArrangementController');
//    });
    //用户菜单
    Route::group(['prefix' => 'sys','middleware'=>['role:administrator|superadministrator']],function(){
        Route::resource('users','UserController');
        Route::resource('roles','RoleController');
        Route::resource('permissions','PermissionController');
        Route::resource('departments','DepartmentController');
    });
    //个人资料
//    Route::get('/sys/profiles/{user}','ProfileController@edit')->name('profiles.edit');
//    Route::put('/sys/profiles/{user}','ProfileController@update')->name('profiles.update');
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
//    Route::group(['prefix' => 'zx'],function(){
//        Route::resource('zxcustomers','ZxCustomerController');
//        Route::post('customersearch','ZxCustomerController@customerSearch')->name('customers.search');
//        Route::resource('huifangs','HuifangController');
//        Route::get('huifangs/{customer_id}/add','HuifangController@add')->name('huifangs.add');
//        Route::get('huifangs/{customer_id}/records','HuifangController@huifangRecords')->name('huifangs.records');
//        Route::post('gethuifangfromcustomer','HuifangController@getHuifangFromCustomer');
//        Route::get('menzhen','ZxCustomerController@menzhenIndex')->name('menzhen.index');
//        Route::get('menzhen/{customer_id}','ZxCustomerController@menzhenEdit')->name('menzhen.edit');
//        Route::put('menzhen/{customer_id}','ZxCustomerController@menzhenUpdate')->name('menzhen.update');
//    });
    //上传
});