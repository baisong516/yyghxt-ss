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
    Route::post('/home/uploadimage', 'HomeController@uploadImage')->name('home.uploadImage');
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
        Route::resource('platforms','PlatFormController');
        Route::resource('areas','AreaController');
        Route::resource('causes','CauseController');
    });
    //咨询
    Route::group(['prefix' => 'zx'],function(){
        Route::resource('zxcustomers','ZxCustomerController');
        Route::post('zxcustomersearch','ZxCustomerController@customerSearch')->name('zxcustomers.search');
        Route::resource('huifangs','HuifangController');
	    Route::get('summaries','ZxCustomerController@summary')->name('summaries.all');
	    Route::get('zxdetail','ZxCustomerController@detailZx')->name('summaries.zxdetail');
	    Route::post('zxdetail','ZxCustomerController@detailZx')->name('summaries.search');
	    Route::get('exportexcel','ExcelController@index')->name('excel.create');
	    Route::post('exportexcel','ExcelController@exportExcel')->name('excel.export');
    });
    //竞价
    Route::group(['prefix' => 'jingjia'],function(){
        Route::resource('auctions','AuctionController');
        Route::resource('reports','ReportController');
        Route::post('auctionsearch','AuctionController@search')->name('auctions.search');
        Route::post('reportsearch','ReportController@search')->name('reports.search');
        Route::post('auctionsimport','AuctionController@import')->name('auctions.import');
        Route::post('reportsimport','ReportController@import')->name('reports.import');
    });
    //企划
    Route::group(['prefix' => 'qh'],function(){
        Route::resource('buttons','StatisticController');
        Route::post('buttonsearch','StatisticController@search')->name('buttons.search');

        Route::resource('specials','SpecialController');
        Route::resource('specialtrans','SpecialtranController');
        Route::post('specialtransearch','SpecialtranController@search')->name('specialtrans.search');

        Route::post('specialtransimport','SpecialtranController@import')->name('specialtrans.import');
        //素材
        Route::get('resources','ResDesginController@index')->name('resources.index');
        Route::post('resources','ResDesginController@search')->name('resources.search');
        Route::any('resource-download','ResDesginController@download')->name('resources.download');
    });
    //产出
    Route::group(['prefix' => 'outputs'],function(){
        Route::get('outputs','OutputController@index')->name('outputs.index');
        Route::post('outputsearch','OutputController@search')->name('outputs.search');
        Route::resource('zxoutputs','ZxOutputController');
        Route::post('zxoutputsimport','ZxOutputController@import')->name('zxoutputs.import');
        Route::resource('jjoutputs','JjOutputController');
        Route::post('jjoutputsimport','JjOutputController@import')->name('jjoutputs.import');

        Route::post('zxoutputsearch','ZxOutputController@search')->name('zxoutputs.search');
        Route::post('jjoutputsearch','JjOutputController@search')->name('jjoutputs.search');
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
});
