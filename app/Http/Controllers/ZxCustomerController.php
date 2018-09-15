<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Disease;
use App\Doctor;
use App\Http\Requests\StoreZxCustomerRequest;
use App\Huifang;
use App\Media;
use App\Office;
use App\SendMsg;
use App\User;
use App\WebType;
use App\ZxCustomer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZxCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-zx_customers')){
            //今日应到院
            $todayArrive =ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
                ['yuyue_at','>=',Carbon::now()->startOfDay()],
                ['yuyue_at','<=',Carbon::now()->endOfDay()],
            ])->count();
            //今日应回访
            $huifangCustomers=Huifang::select('zx_customer_id')->whereNotNull('next_at')->where([
                ['next_at','>=',Carbon::now()->startOfDay()],
                ['next_at','<=',Carbon::now()->endOfDay()],
            ])->get();
            $huifangCustomerIds=[];
            foreach ($huifangCustomers as $huifangCustomer){
                $huifangCustomerIds[]=$huifangCustomer->zx_customer_id;
            }
            $customerIdstemp = array_unique($huifangCustomerIds);//一次过滤
            //今日应回访数量
            $todayHuifang=ZxCustomer::whereIn('office_id',ZxCustomer::offices())->whereIn('id',$customerIdstemp)->count();
            //今日已回访
            $CustomerIds=[];
            foreach (ZxCustomer::whereIn('office_id',ZxCustomer::offices())->whereIn('id',$customerIdstemp)->get() as $c){
                $huifang=Huifang::where('zx_customer_id',$c->id)->orderBy('id', 'desc')->first();//最新回访
                if ($huifang->now_at>=Carbon::now()->startOfDay()||$huifang->next_at>=Carbon::now()->endOfDay()){
                    $CustomerIds[]=$huifang->zx_customer_id;
                }
            }
            //今日已回访数量
            $todayHuifangFinished=count($CustomerIds);
            //今日应回访但未回访数量
            $todayHuifangR=$todayHuifang-$todayHuifangFinished;
            //今日预约
            $todayyuyue=ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
                ['zixun_at','>=',Carbon::now()->startOfDay()],
                ['zixun_at','<=',Carbon::now()->endOfDay()],
            ])->whereNotNull('yuyue_at')->count();
            //今日到院
            $todayarrived=ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
                ['arrive_at','>=',Carbon::now()->startOfDay()],
                ['arrive_at','<=',Carbon::now()->endOfDay()],
            ])->count();
            return view('zxcustomer.read',[
                'pageheader'=>'患者',
                'pagedescription'=>'列表',
//                'customers'=>ZxCustomer::getCustomers(),
                'customers'=>ZxCustomer::getTodayCustomers(),
                'users'=>Aiden::getAllUserArray(),
                'zxusers'=>Aiden::getAllZxUserArray(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'doctors'=>Aiden::getAllModelArray('doctors'),
                'webtypes'=>Aiden::getAllModelArray('web_types'),
                'medias'=>Aiden::getAllModelArray('medias'),
                'customertypes'=>Aiden::getAllModelArray('customer_types'),
                'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
                'causes'=>Aiden::getAllModelArray('causes'),

                'enableRead'=>Auth::user()->hasPermission('read-zx_customers'),
                'enableUpdate'=>Auth::user()->hasPermission('update-zx_customers'),
                'enableDelete'=>Auth::user()->hasPermission('delete-zx_customers'),
                'enableHuifang'=>Auth::user()->hasPermission('create-huifangs'),
                'enableViewHuifang'=>Auth::user()->hasPermission('read-huifangs'),
                'enableViewPhone'=>Auth::user()->hasPermission('view-phone'),
                'enableViewWechat'=>Auth::user()->hasPermission('view-wechat'),
                'userid'=>Auth::user()->id,
                'isAdmin'=>Auth::user()->hasRole('superadministrator|administrator'),

                'todayArrive'=>$todayArrive,
                'todayHuifang'=>$todayHuifang,
                'todayHuifangFinished'=>$todayHuifangFinished,
                'todayyuyue'=>$todayyuyue,
                'todayarrived'=>$todayarrived,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->ability('superadministrator', 'create-zx_customers')){
            if (Auth::user()->hasRole('superadministrator|administrator|menzhen|zx-mast')){
                $customerconditions=Aiden::getAllModelArray('customer_conditions');
            }else{
                $customerconditions=[
                  3 => "预约",
                  4 => "咨询",
                ];
            }
            return view('zxcustomer.create', array(
                'pageheader'=>'患者',
                'pagedescription'=>'添加',
                'users'=>Aiden::getAllUserArray(),
                'activeUsers'=>Aiden::getAllActiveUserArray(),
                'activeJingjiaUsers'=>Aiden::getAllActiveJingjiaUserArray(),
                'activeZxUsers'=>Aiden::getAllActiveZiXunUserArray(),
                'offices'=>Aiden::getAuthdOffices(),
                'diseases'=>Aiden::getAuthdDiseases(),
                'doctors'=>Aiden::getAuthdDoctors(),
                'causes'=>Aiden::getAllModelArray('causes'),
                'webtypes'=>Aiden::getAllModelArray('web_types'),
                'medias'=>Aiden::getAllModelArray('medias'),
                'customertypes'=>Aiden::getAllModelArray('customer_types'),
                'customerconditions'=>$customerconditions,
            ));
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreZxCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZxCustomerRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-zx_customers')){
            if (ZxCustomer::createCustomer($request)){
                return redirect()->route('zxcustomers.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->ability('superadministrator', 'read-zx_customers')){
            return view('zxcustomer.detail', array(
                'pageheader'=>'患者',
                'pagedescription'=>'详情',
                'enableViewPhone'=>Auth::user()->hasPermission('view-phone'),
                'enableViewWechat'=>Auth::user()->hasPermission('view-wechat'),
                'isAdmin'=>Auth::user()->hasRole('superadministrator|administrator'),
                'userid'=>Auth::user()->id,
                'customer'=>ZxCustomer::findOrFail($id)
            ));
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if (Auth::user()->ability('superadministrator', 'update-zx_customers')){
            if (Auth::user()->hasRole('superadministrator|administrator|menzhen|zx-mast')){
                $customerconditions=Aiden::getAllModelArray('customer_conditions');
            }else{
                $customerconditions=[
                    3 => "预约",
                    4 => "咨询",
                ];
            }
            return view('zxcustomer.update', array(
                'pageheader'=>'患者',
                'pagedescription'=>'更新',
                'users'=>Aiden::getAllUserArray(),
                'activeJingjiaUsers'=>Aiden::getAllActiveJingjiaUserArray(),
                'activeZxUsers'=>Aiden::getAllActiveZiXunUserArray(),
                'activeUsers'=>Aiden::getAllActiveUserArray(),
                'offices'=>Aiden::getAuthdOffices(),
                'diseases'=>Aiden::getAuthdDiseases(),
                'doctors'=>Aiden::getAuthdDoctors(),
                'webtypes'=>Aiden::getAllModelArray('web_types'),
                'medias'=>Aiden::getAllModelArray('medias'),
                'causes'=>Aiden::getAllModelArray('causes'),
                'customertypes'=>Aiden::getAllModelArray('customer_types'),
                'customerconditions'=>$customerconditions,
                'customer'=>ZxCustomer::findOrFail($id),
                'enableViewPhone'=>Auth::user()->hasPermission('view-phone'),
                'enableViewWechat'=>Auth::user()->hasPermission('view-wechat'),
                'isAdmin'=>Auth::user()->hasRole('superadministrator|administrator'),
                'userid'=>Auth::user()->id,
                'parameters'=>$request->input('parameters')
            ));
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreZxCustomerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreZxCustomerRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'create-zx_customers')){
            if (ZxCustomer::updateCustomer($request,$id)){
                return redirect()->route('zxcustomers.search')->with([
                    'success'=>'Well Done!',
                    'parameters'=>$request->input('parameters')
                ]);
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->ability('superadministrator', 'delete-zx_customers')){
            $customer=ZxCustomer::findOrFail($id);
            //delete huifangs before delete customer
            foreach ($customer->huifangs as $huifang){
                $huifang->delete();
            }
            $bool=$customer->delete();
            if ($bool){
                return redirect()->route('zxcustomers.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    //咨询患者搜索
    public function customerSearch(Request $request)
    {
        //今日应到院
        $todayArrive =ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
            ['yuyue_at','>=',Carbon::now()->startOfDay()],
            ['yuyue_at','<=',Carbon::now()->endOfDay()],
        ])->count();
        //今日应回访
        $huifangCustomers=Huifang::select('zx_customer_id')->whereNotNull('next_at')->where([
            ['next_at','>=',Carbon::now()->startOfDay()],
            ['next_at','<=',Carbon::now()->endOfDay()],
        ])->get();
        $huifangCustomerIds=[];
        foreach ($huifangCustomers as $huifangCustomer){
            $huifangCustomerIds[]=$huifangCustomer->zx_customer_id;
        }
        $customerIdstemp = array_unique($huifangCustomerIds);//一次过滤
        //今日应回访数量
        $todayHuifang=ZxCustomer::whereIn('office_id',ZxCustomer::offices())->whereIn('id',$customerIdstemp)->count();
        //今日已回访
        $CustomerIds=[];
        foreach ($customerIdstemp as $id){
            if (in_array(ZxCustomer::findOrFail($id)->office_id,ZxCustomer::offices())){
                $huifang=Huifang::where('zx_customer_id',$id)->orderBy('id', 'desc')->first();//最新回访
                if ($huifang->now_at>=Carbon::now()->startOfDay()||$huifang->next_at>=Carbon::now()->endOfDay()){
                    $CustomerIds[]=$huifang->zx_customer_id;
                }
            }
        }
        //今日已回访数量
        $todayHuifangFinished=count($CustomerIds);
        //今日应回访但未回访数量
        $todayHuifangR=$todayHuifang-$todayHuifangFinished;
        //今日预约
        $todayyuyue=ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
            ['zixun_at','>=',Carbon::now()->startOfDay()],
            ['zixun_at','<=',Carbon::now()->endOfDay()],
        ])->whereNotNull('yuyue_at')->count();
        //今日到院
        $todayarrived=ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
            ['arrive_at','>=',Carbon::now()->startOfDay()],
            ['arrive_at','<=',Carbon::now()->endOfDay()],
        ])->count();
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//        $parameters=$request->input('parameters');
        $parameters=[];
//        if (!empty($parameters)){
//            $parameters=json_decode($parameters);
//        }
        $quickSearch=$request->input('quickSearch');
        $customers=null;
        if ($request->method()=='GET'){
            $ref=$request->input('ref');
            if ($ref=='index'){
                //从首页进入
                $start=Carbon::createFromFormat('Y-m-d H:i:s',urldecode($request->input('start')));
                $end=Carbon::createFromFormat('Y-m-d H:i:s',urldecode($request->input('end')));
                $office=$request->input('office');
                $q=$request->input('q');

                $parameters['office_id']=$office;
                //zixun contact tel total  yuyue should arrive jiuzhen
                if ($q=='total'||$q=='a'){//咨询量
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['zixun_at','>=',$start],
                        ['zixun_at','<=',$end],
                    ])->with('huifangs')->get();
                    $parameters['zixun_at_start']=$start;
                    $parameters['zixun_at_end']=$end;
                }elseif ($q=='zixun'){
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['zixun_at','>=',$start],
                        ['zixun_at','<=',$end],
                        ['media_id','<>',2],
                    ])->with('huifangs')->get();
                }elseif ($q=='tel'){
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['zixun_at','>=',$start],
                        ['zixun_at','<=',$end],
                        ['media_id','=',2],
                    ])->with('huifangs')->get();
                    $parameters['media_id']=2;
                }elseif ($q=='contact'){
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['zixun_at','>=',$start],
                        ['zixun_at','<=',$end],
                    ])->where(function ($query) {
                        $query->where('tel', '<>', null)
                            ->orWhere('qq', '<>', null)
                            ->orWhere('wechat', '<>', null);
                    })->with('huifangs')->get();
                }elseif ($q=='yuyue'){
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['created_at','>=',$start],
                        ['created_at','<=',$end],
                        ['yuyue_at','>=',$start],
                    ])->with('huifangs')->get();
                    $parameters['yuyue_at_start']=$start;
                }elseif ($q=='should'){
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['yuyue_at','>=',$start],
                        ['yuyue_at','<=',$end],
                    ])->with('huifangs')->get();
                    $parameters['yuyue_at_start']=$start;
                    $parameters['yuyue_at_end']=$end;
                }elseif ($q=='arrive'){
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['arrive_at','>=',$start],
                        ['arrive_at','<=',$end],
                    ])->with('huifangs')->get();
                    $parameters['arrive_start']=$start;
                    $parameters['arrive_end']=$end;
                }elseif ($q=='jiuzhen'){
                    $customers =ZxCustomer::where('office_id',$office)->where([
                        ['arrive_at','>=',$start],
                        ['arrive_at','<=',$end],
                    ])->where('customer_condition_id',1)->with('huifangs')->get();
                    $parameters['arrive_start']=$start;
                    $parameters['arrive_end']=$end;
                    $parameters['customer_condition_id']=1;
                }
            }else{//更新时返回
                $sess=session('parameters');
//                dd($sess);
                if (!empty($sess)){
                    $sess=json_decode($sess,true);
                    if (isset($sess['name'])){$parameters['name']=$sess['name'];$customerName=$sess['name'];}
                    if (isset($sess['tel'])){$parameters['tel']=$sess['tel'];$customerTel=$sess['tel'];}
                    if (isset($sess['qq'])){$parameters['qq']=$sess['qq'];$customerQQ=$sess['qq'];}
                    if (isset($sess['wechat'])){$parameters['wechat']=$sess['wechat'];$customerWechat=$sess['wechat'];}
                    if (isset($sess['swt'])){$parameters['swt']=$sess['swt'];$customerIdCard=$sess['swt'];}
                    if (isset($sess['zx_user_id'])){$parameters['zx_user_id']=$sess['zx_user_id'];$zxUser=$sess['zx_user_id'];}
                    if (isset($sess['media_id'])){$parameters['media_id']=$sess['media_id'];$media=$sess['media_id'];}
                    if (isset($sess['office_id'])){$parameters['office_id']=$sess['office_id'];$officeId=$sess['office_id'];}
                    if (isset($sess['disease_id'])){$parameters['disease_id']=$sess['disease_id'];$diseaseId=$sess['disease_id'];}
                    if (isset($sess['customer_condition_id'])){$parameters['customer_condition_id']=$sess['customer_condition_id'];$customerConditionId=$sess['customer_condition_id'];}
                    if (isset($sess['last_user_id'])){$parameters['last_user_id']=$sess['last_user_id'];$last_huifang_user_id=$sess['last_user_id'];}

                    if (isset($sess['zixun_at_start'])){$zx_start=$parameters['zixun_at_start']=Carbon::parse($sess['zixun_at_start']['date']);}
                    if (isset($sess['zixun_at_end'])){$zx_end=$parameters['zixun_at_end']=Carbon::parse($sess['zixun_at_end']['date']);}
                    if (isset($sess['yuyue_at_start'])){$yy_start=$parameters['yuyue_at_start']=Carbon::parse($sess['yuyue_at_start']['date']);}
                    if (isset($sess['yuyue_at_end'])){$yy_end=$parameters['yuyue_at_end']=Carbon::parse($sess['yuyue_at_end']['date']);}
                    if (isset($sess['arrive_start'])){$arrive_start=$parameters['arrive_start']=Carbon::parse($sess['arrive_start']['date']);}
                    if (isset($sess['arrive_end'])){$arrive_end=$parameters['arrive_end']=Carbon::parse($sess['arrive_end']['date']);}
                    if (isset($sess['last_start'])){$last_huifang_start=$parameters['last_start']=Carbon::parse($sess['last_start']['date']);}
                    if (isset($sess['last_end'])){$last_huifang_end=$parameters['last_end']=Carbon::parse($sess['last_end']['date']);}
                    if (isset($sess['next_at_start'])){$next_huifang_start=$parameters['next_at_start']=Carbon::parse($sess['next_at_start']['date']);}
                    if (isset($sess['next_at_end'])){$next_huifang_end=$parameters['next_at_end']=Carbon::parse($sess['next_at_end']['date']);}
                    //条件为空
                    if (empty($customerName)&&empty($customerTel)&&empty($customerQQ)&&empty($customerWechat)&&empty($customerIdCard)&&empty($zxUser)&&empty($media)&&empty($officeId)&&empty($zx_start)&&empty($yy_start)&&empty($arrive_start)&&empty($last_huifang_start)&&empty($next_huifang_start)&&empty($last_huifang_user_id)&&empty($customerConditionId)){
                        $customers=ZxCustomer::getTodayCustomers();
                    }else{
                        //按回访
                        $customerIds=[];
                        if (!empty($last_huifang_start)||!empty($next_huifang_start)||!empty($last_huifang_user_id)){
                            $huifangParms=array();
                            if (!empty($last_huifang_start)){
                                array_push($huifangParms,['now_at','>=',$last_huifang_start],['now_at','<=',$last_huifang_end]);
                                $parameters['last_start']=$last_huifang_start;
                                $parameters['last_end']=$last_huifang_end;
                            }
                            if (!empty($next_huifang_start)){
                                array_push($huifangParms,['next_at','>=',$next_huifang_start],['next_at','<=',$next_huifang_end]);
                                $parameters['next_at_start']=$next_huifang_start;
                                $parameters['next_at_end']=$next_huifang_end;
                            }
                            if (!empty($last_huifang_user_id)){
                                array_push($huifangParms,['now_user_id',$last_huifang_user_id]);
                                $parameters['last_user_id']=$last_huifang_user_id;
                            }
                            $huifangCustomers=Huifang::select('zx_customer_id','now_user_id')->where($huifangParms)->get();

                            $huifangCustomerIds=[];
                            foreach ($huifangCustomers as $huifangCustomer){
                                $huifangCustomerIds[]=$huifangCustomer->zx_customer_id;
                            }
                            $huifangCustomerIds = array_unique($huifangCustomerIds);
                            $customerIds=$huifangCustomerIds;


                        }
                        //按患者搜索
                        $parms=array();
                        if (!empty($customerName)){
                            array_push($parms,['name','like','%'.$customerName.'%']);
                            $parameters['name']=$customerName;
                        }
                        if (!empty($customerTel)){
                            array_push($parms,['tel','like','%'.$customerTel.'%']);
                            $parameters['tel']=$customerTel;
                        }
                        if (!empty($customerQQ)){
                            array_push($parms,['qq','like','%'.$customerQQ.'%']);
                            $parameters['qq']=$customerQQ;
                        }
                        if (!empty($customerWechat)){
                            array_push($parms,['wechat','like','%'.$customerWechat.'%']);
                            $parameters['wechat']=$customerWechat;
                        }
                        if (!empty($customerIdCard)){
                            array_push($parms,['idcard','like','%'.$customerIdCard.'%']);
                            $parameters['swt']=$customerIdCard;
                        }
                        if (!empty($zxUser)){
                            array_push($parms,['user_id','=',$zxUser]);
                            $parameters['zx_user_id']=$zxUser;
                        }
                        if (!empty($media)){
                            array_push($parms,['media_id','=',$media]);
                            $parameters['media_id']=$media;
                        }
                        if (!empty($officeId)){
                            array_push($parms,['office_id','=',$officeId]);
                            $parameters['office_id']=$officeId;
                        }
                        if (!empty($diseaseId)){
                            array_push($parms,['disease_id','=',$diseaseId]);
                            $parameters['disease_id']=$diseaseId;
                        }
                        if (!empty($customerConditionId)){
                            array_push($parms,['customer_condition_id','=',$customerConditionId]);
                            $parameters['customer_condition_id']=$customerConditionId;
                        }
                        if (!empty($zx_start)){
                            array_push($parms,['zixun_at','>=',$zx_start],['zixun_at','<=',$zx_end]);
                            $parameters['zixun_at_start']=$zx_start;
                            $parameters['zixun_at_end']=$zx_end;
                        }
                        if (!empty($yy_start)){
                            array_push($parms,['yuyue_at','>=',$yy_start],['yuyue_at','<=',$yy_end]);
                            $parameters['yuyue_at_start']=$yy_start;
                            $parameters['yuyue_at_end']=$yy_end;
                        }
                        if (!empty($arrive_start)){
                            array_push($parms,['arrive_at','>=',$arrive_start],['arrive_at','<=',$arrive_end]);
                            $parameters['arrive_start']=$arrive_start;
                            $parameters['arrive_end']=$arrive_end;
                        }
                        if (!empty($customerIds)){
                            $customers =ZxCustomer::whereIn('id',$customerIds)->whereIn('office_id',ZxCustomer::offices())->where($parms)->with('huifangs')->get();
                        }else{
                            $customers =ZxCustomer::where($parms)->whereIn('office_id',ZxCustomer::offices())->with('huifangs')->get();
                        }
                    }
                }else{
                    $customers=ZxCustomer::getTodayCustomers();
                }
            }

//            $customers =ZxCustomer::where($parms)->where('office_id',$office)->with('huifangs')->get();
        }else{
            //快捷查询  今日应回访
            $customerName=$request->input('searchCustomerName');
            $customerTel=$request->input('searchCustomerTel');
            $customerQQ=$request->input('searchCustomerQQ');
            $customerWechat=$request->input('searchCustomerWechat');
            $customerIdCard=$request->input('searchIdCard');
            $zxUser=$request->input('searchUserId');
            $media=$request->input('searchMediaId');
            $last_huifang_user_id=$request->input('searchLastHuifangUserId');//最近回访人
            $officeId=$request->input('searchOfficeId');
            $diseaseId=$request->input('searchDiseaseId');
            $customerConditionId=$request->input('searchCustomerCondition');
            $zx_start=$request->input('searchZxStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchZxStart'))->startOfDay():null;
            $zx_end=$request->input('searchZxEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchZxEnd'))->endOfDay():Carbon::now()->endOfDay();
            $yy_start=$request->input('searchYuyueStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchYuyueStart'))->startOfDay():null;
            $yy_end=$request->input('searchYuyueEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchYuyueEnd'))->endOfDay():Carbon::now()->endOfDay();
            $arrive_start=$request->input('searchArriveStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchArriveStart'))->startOfDay():null;
            $arrive_end=$request->input('searchArriveEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchArriveEnd'))->endOfDay():Carbon::now()->endOfDay();
            $last_huifang_start=$request->input('searchLastHuifangStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchLastHuifangStart'))->startOfDay():null;
            $last_huifang_end=$request->input('searchLastHuifangEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchLastHuifangEnd'))->endOfDay():Carbon::now()->endOfDay();
            $next_huifang_start=$request->input('searchNextHuifangStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchNextHuifangStart'))->startOfDay():null;
            $next_huifang_end=$request->input('searchNextHuifangEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchNextHuifangEnd'))->endOfDay():Carbon::now()->endOfDay();

            if (!empty($quickSearch)){
                if ($quickSearch=='todayhuifang'){
                    $parameters['next_at_start']=Carbon::now()->startOfDay();
                    $parameters['next_at_end']=Carbon::now()->endOfDay();
                    //今日应回访
                    $huifangCustomers=Huifang::select('zx_customer_id')->where([
                        ['next_at','>=',Carbon::now()->startOfDay()],
                        ['next_at','<=',Carbon::now()->endOfDay()],
                    ])->get();

                    $huifangCustomerIds=[];
                    foreach ($huifangCustomers as $huifangCustomer){
                        $huifangCustomerIds[]=$huifangCustomer->zx_customer_id;
                    }
                    $customerIdstemp = array_unique($huifangCustomerIds);//一次过滤

                    $customers =ZxCustomer::whereIn('id',$customerIdstemp)->whereIn('office_id',ZxCustomer::offices())->with('huifangs')->get();
                }
                if ($quickSearch=='todayarrive'){
                    //今日应到院
                    $parameters['yuyue_at_start']=Carbon::now()->startOfDay();
                    $parameters['yuyue_at_end']=Carbon::now()->endOfDay();
                    $customers =ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
                        ['yuyue_at','>=',Carbon::now()->startOfDay()],
                        ['yuyue_at','<=',Carbon::now()->endOfDay()],
                    ])->with('huifangs')->get();
                }
                if ($quickSearch=='todayyuyue'){
                    //今日预约
                    $parameters['zixun_at_start']=Carbon::now()->startOfDay();
                    $parameters['zixun_at_end']=Carbon::now()->endOfDay();
                    $customers =ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
                        ['zixun_at','>=',Carbon::now()->startOfDay()],
                        ['zixun_at','<=',Carbon::now()->endOfDay()],
                    ])->whereNotNull('yuyue_at')->with('huifangs')->get();
                }
                if ($quickSearch=='todayarrived'){
                    //今日预约
                    $parameters['arrive_start']=Carbon::now()->startOfDay();
                    $parameters['arrive_end']=Carbon::now()->endOfDay();
                    $customers =ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
                        ['arrive_at','>=',Carbon::now()->startOfDay()],
                        ['arrive_at','<=',Carbon::now()->endOfDay()],
                    ])->with('huifangs')->get();
                }
            }else{
                //条件为空
                if (empty($customerName)&&empty($customerTel)&&empty($customerQQ)&&empty($customerWechat)&&empty($customerIdCard)&&empty($zxUser)&&empty($media)&&empty($officeId)&&empty($zx_start)&&empty($yy_start)&&empty($arrive_start)&&empty($last_huifang_start)&&empty($next_huifang_start)&&empty($last_huifang_user_id)&&empty($customerConditionId)){
                    $customers=ZxCustomer::getCustomers();
                }else{
                    //按回访
                    $customerIds=[];
                    if (!empty($last_huifang_start)||!empty($next_huifang_start)||!empty($last_huifang_user_id)){
                        $huifangParms=array();
                        if (!empty($last_huifang_start)){
                            array_push($huifangParms,['now_at','>=',$last_huifang_start],['now_at','<=',$last_huifang_end]);
                            $parameters['last_start']=$last_huifang_start;
                            $parameters['last_end']=$last_huifang_end;
                        }
                        if (!empty($next_huifang_start)){
                            array_push($huifangParms,['next_at','>=',$next_huifang_start],['next_at','<=',$next_huifang_end]);
                            $parameters['next_at_start']=$next_huifang_start;
                            $parameters['next_at_end']=$next_huifang_end;
                        }
                        if (!empty($last_huifang_user_id)){
                            array_push($huifangParms,['now_user_id',$last_huifang_user_id]);
                            $parameters['last_user_id']=$last_huifang_user_id;
                        }
                        $huifangCustomers=Huifang::select('zx_customer_id','now_user_id')->where($huifangParms)->get();

                        $huifangCustomerIds=[];
                        foreach ($huifangCustomers as $huifangCustomer){
                            $huifangCustomerIds[]=$huifangCustomer->zx_customer_id;
                        }
                        $huifangCustomerIds = array_unique($huifangCustomerIds);
                        $customerIds=$huifangCustomerIds;


                    }
                    //按患者搜索
                    $parms=array();
                    if (!empty($customerName)){
                        array_push($parms,['name','like','%'.$customerName.'%']);
                        $parameters['name']=$customerName;
                    }
                    if (!empty($customerTel)){
                        array_push($parms,['tel','like','%'.$customerTel.'%']);
                        $parameters['tel']=$customerTel;
                    }
                    if (!empty($customerQQ)){
                        array_push($parms,['qq','like','%'.$customerQQ.'%']);
                        $parameters['qq']=$customerQQ;
                    }
                    if (!empty($customerWechat)){
                        array_push($parms,['wechat','like','%'.$customerWechat.'%']);
                        $parameters['wechat']=$customerWechat;
                    }
                    if (!empty($customerIdCard)){
                        array_push($parms,['idcard','like','%'.$customerIdCard.'%']);
                        $parameters['swt']=$customerIdCard;
                    }
                    if (!empty($zxUser)){
                        array_push($parms,['user_id','=',$zxUser]);
                        $parameters['zx_user_id']=$zxUser;
                    }
                    if (!empty($media)){
                        array_push($parms,['media_id','=',$media]);
                        $parameters['media_id']=$media;
                    }
                    if (!empty($officeId)){
                        array_push($parms,['office_id','=',$officeId]);
                        $parameters['office_id']=$officeId;
                    }
                    if (!empty($diseaseId)){
                        array_push($parms,['disease_id','=',$diseaseId]);
                        $parameters['disease_id']=$diseaseId;
                    }
                    if (!empty($customerConditionId)){
                        array_push($parms,['customer_condition_id','=',$customerConditionId]);
                        $parameters['customer_condition_id']=$customerConditionId;
                    }
                    if (!empty($zx_start)){
                        array_push($parms,['zixun_at','>=',$zx_start],['zixun_at','<=',$zx_end]);
                        $parameters['zixun_at_start']=$zx_start;
                        $parameters['zixun_at_end']=$zx_end;
                    }
                    if (!empty($yy_start)){
                        array_push($parms,['yuyue_at','>=',$yy_start],['yuyue_at','<=',$yy_end]);
                        $parameters['yuyue_at_start']=$yy_start;
                        $parameters['yuyue_at_end']=$yy_end;
                    }
                    if (!empty($arrive_start)){
                        array_push($parms,['arrive_at','>=',$arrive_start],['arrive_at','<=',$arrive_end]);
                        $parameters['arrive_start']=$arrive_start;
                        $parameters['arrive_end']=$arrive_end;
                    }
                    if (!empty($customerIds)){
                        $customers =ZxCustomer::whereIn('id',$customerIds)->whereIn('office_id',ZxCustomer::offices())->where($parms)->with('huifangs')->get();
                    }else{
                        $customers =ZxCustomer::where($parms)->whereIn('office_id',ZxCustomer::offices())->with('huifangs')->get();
                    }
                }
            }
        }


//        dd($parameters);
        return view('zxcustomer.read',[
            'pageheader'=>'患者',
            'pagedescription'=>'列表',
            'customers'=>$customers,
            'users'=>Aiden::getAllUserArray(),
            'zxusers'=>Aiden::getAllZxUserArray(),
            'offices'=>Aiden::getAllModelArray('offices'),
            'diseases'=>Aiden::getAllModelArray('diseases'),
            'webtypes'=>Aiden::getAllModelArray('web_types'),
            'medias'=>Aiden::getAllModelArray('medias'),
            'causes'=>Aiden::getAllModelArray('causes'),
            'customertypes'=>Aiden::getAllModelArray('customer_types'),
            'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
            'enableRead'=>Auth::user()->hasPermission('read-zx_customers'),
            'enableUpdate'=>Auth::user()->hasPermission('update-zx_customers'),
            'enableDelete'=>Auth::user()->hasPermission('delete-zx_customers'),
            'enableHuifang'=>Auth::user()->hasPermission('create-huifangs'),
            'enableViewHuifang'=>Auth::user()->hasPermission('read-huifangs'),
            'enableViewPhone'=>Auth::user()->hasPermission('view-phone'),
            'enableViewWechat'=>Auth::user()->hasPermission('view-wechat'),
            'isAdmin'=>Auth::user()->hasRole('superadministrator|administrator'),
            'userid'=>Auth::user()->id,
            'parameters'=>$parameters,
            'quicksearch'=>$quickSearch,
            'todayArrive'=>$todayArrive,
            'todayHuifang'=>$todayHuifang,
            'todayHuifangFinished'=>$todayHuifangFinished,
            'todayyuyue'=>$todayyuyue,
            'todayarrived'=>$todayarrived,
        ]);
    }
    //咨询列表（所有数据）
    public function summary(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-zx_customers')){
            //今日应到院
            $todayArrive =ZxCustomer::whereIn('office_id',ZxCustomer::offices())->where([
                ['yuyue_at','>=',Carbon::now()->startOfDay()],
                ['yuyue_at','<=',Carbon::now()->endOfDay()],
            ])->count();
            //今日应回访
            $huifangCustomers=Huifang::select('zx_customer_id')->whereNotNull('next_at')->where([
                ['next_at','>=',Carbon::now()->startOfDay()],
                ['next_at','<=',Carbon::now()->endOfDay()],
            ])->get();
            $huifangCustomerIds=[];
            foreach ($huifangCustomers as $huifangCustomer){
                $huifangCustomerIds[]=$huifangCustomer->zx_customer_id;
            }
            $customerIdstemp = array_unique($huifangCustomerIds);//一次过滤
            //今日应回访数量
            $todayHuifang=count($customerIdstemp);
            //今日已回访
            $CustomerIds=[];
            foreach ($customerIdstemp as $id){
                $huifang=Huifang::where('zx_customer_id',$id)->orderBy('id', 'desc')->first();//最新回访
                if ($huifang->now_at>=Carbon::now()->startOfDay()||$huifang->next_at>=Carbon::now()->endOfDay()){
                    $CustomerIds[]=$huifang->zx_customer_id;
                }
            }
            //今日已回访数量
            $todayHuifangFinished=count($CustomerIds);
            //今日应回访但未回访数量
            $todayHuifangR=$todayHuifang-$todayHuifangFinished;
            return view('zxcustomer.read',[
                'pageheader'=>'患者',
                'pagedescription'=>'列表',
                'customers'=>ZxCustomer::getCustomers(),
//                'customers'=>ZxCustomer::getTodayCustomers(),
                'users'=>Aiden::getAllUserArray(),
                'zxusers'=>Aiden::getAllZxUserArray(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'webtypes'=>Aiden::getAllModelArray('web_types'),
                'medias'=>Aiden::getAllModelArray('medias'),
                'customertypes'=>Aiden::getAllModelArray('customer_types'),
                'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
                'causes'=>Aiden::getAllModelArray('causes'),

                'enableRead'=>Auth::user()->hasPermission('read-zx_customers'),
                //'enableUpdate'=>Auth::user()->hasPermission('update-zx_customers'),
                'enableUpdate'=>false,
                //'enableDelete'=>Auth::user()->hasPermission('delete-zx_customers'),
                'enableDelete'=>false,
                'enableHuifang'=>Auth::user()->hasPermission('create-huifangs'),
                'enableViewHuifang'=>Auth::user()->hasPermission('read-huifangs'),

                'todayArrive'=>$todayArrive,
                'todayHuifang'=>$todayHuifang,
                'todayHuifangFinished'=>$todayHuifangFinished,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
    //咨询明细
	public function detailZx(Request $request) {
		$user=Auth::user();
		$data=[];
		$total=[];
		$start=Carbon::now()->startOfDay();
		$end=Carbon::now()->endOfDay();
		$cuser=$request->input('searchUserId');
		if (!empty($request->input('summaryDateStart'))&&!empty($request->input('summaryDateEnd'))){
		    $start=Carbon::createFromFormat('Y-m-d',$request->input('summaryDateStart'))->startOfDay();
		    $end=Carbon::createFromFormat('Y-m-d',$request->input('summaryDateEnd'))->endOfDay();
        }
		if (!empty($user->offices)){
			foreach ($user->offices as $office){
			    //项目统计
			    $total[$office->id]['office']=$office->display_name;
                $total[$office->id]['data']=[
                    'zixun_count'=>0,
                    'contact_count'=>0,
                    'yuyue_count'=>0,
                    'arrive_count'=>0,
                    'should_count'=>0,
                    'jiuzhen_count'=>0,
                ];
				//当前项目的咨询员
                $zxUsers=null;
                if (empty($request->input('searchUserId'))){
                    $zxUsers=$office->users()->where('department_id',2)->where('is_active',1)->get();
                }else{
                    $zxUsers=$office->users()->where('department_id',2)->where('users.id',$request->input('searchUserId'))->get();
                }

				foreach ($zxUsers as $user){
                    //咨询员咨询统计
					$data[$user->id]['username']=$user->realname;
					$data[$user->id]['data'][$office->id]['office']=$office->display_name;
					//咨询量
					$data[$user->id]['data'][$office->id]['zixun_count']=ZxCustomer::where('office_id',$office->id)->where('user_id',$user->id)->where([
						['zixun_at','>=',$start],
						['zixun_at','<=',$end],
					])->count();
                    $total[$office->id]['data']['zixun_count']+=$data[$user->id]['data'][$office->id]['zixun_count'];
					//预约量
					$data[$user->id]['data'][$office->id]['yuyue_count']=ZxCustomer::where('office_id',$office->id)->where('user_id',$user->id)->where([
                        ['zixun_at','>=',$start],
                        ['zixun_at','<=',$end],
						['created_at','>=',$start],
						['created_at','<=',$end],
					])->whereNotNull('yuyue_at')->count();
                    $total[$office->id]['data']['yuyue_count']+=$data[$user->id]['data'][$office->id]['yuyue_count'];
					//留联系量
					$data[$user->id]['data'][$office->id]['contact_count']=ZxCustomer::where('office_id',$office->id)->where('user_id',$user->id)->where([
						['zixun_at','>=',$start],
						['zixun_at','<=',$end],
					])->Where(function ($query){
						$query->where('tel', '<>', '')
						      ->orWhere('qq', '<>', '')
						      ->orWhere('wechat','<>','');
					})->count();
                    $total[$office->id]['data']['contact_count']+=$data[$user->id]['data'][$office->id]['contact_count'];
					//到院量
					$data[$user->id]['data'][$office->id]['arrive_count']=ZxCustomer::where('office_id',$office->id)->where('user_id',$user->id)->where([
						['arrive_at','>=',$start],
						['arrive_at','<=',$end],
					])->count();
                    $total[$office->id]['data']['arrive_count']+=$data[$user->id]['data'][$office->id]['arrive_count'];
					//应到院量
					$data[$user->id]['data'][$office->id]['should_count']=ZxCustomer::where('office_id',$office->id)->where('user_id',$user->id)->where([
						['yuyue_at','>=',$start],
						['yuyue_at','<=',$end],
					])->count();
                    $total[$office->id]['data']['should_count']+=$data[$user->id]['data'][$office->id]['should_count'];
					//就诊量
					// customer_condition_id
					//1 就诊 2，预约 3，到院 4，
					$data[$user->id]['data'][$office->id]['jiuzhen_count']=ZxCustomer::where('office_id',$office->id)->where('user_id',$user->id)->where([
						['arrive_at','>=',$start],
						['arrive_at','<=',$end],
					])->where('customer_condition_id',1)->count();
                    $total[$office->id]['data']['jiuzhen_count']+=$data[$user->id]['data'][$office->id]['jiuzhen_count'];
					//预约率
					$data[$user->id]['data'][$office->id]['yuyue_rate']=$data[$user->id]['data'][$office->id]['zixun_count']>0?sprintf("%.2f",$data[$user->id]['data'][$office->id]['yuyue_count']*100.00/$data[$user->id]['data'][$office->id]['zixun_count'])."%":'0.00%';
					//留联率
					$data[$user->id]['data'][$office->id]['contact_rate']=$data[$user->id]['data'][$office->id]['zixun_count']>0?sprintf("%.2f",$data[$user->id]['data'][$office->id]['contact_count']*100.00/$data[$user->id]['data'][$office->id]['zixun_count'])."%":'0.00%';
					//到院率
					$data[$user->id]['data'][$office->id]['arrive_rate']=$data[$user->id]['data'][$office->id]['should_count']>0?sprintf("%.2f",$data[$user->id]['data'][$office->id]['arrive_count']*100.00/$data[$user->id]['data'][$office->id]['should_count'])."%":'0.00%';
					//就诊率
					$data[$user->id]['data'][$office->id]['jiuzhen_rate']=$data[$user->id]['data'][$office->id]['arrive_count']>0?sprintf("%.2f",$data[$user->id]['data'][$office->id]['jiuzhen_count']*100.00/$data[$user->id]['data'][$office->id]['arrive_count'])."%":'0.00%';
				    //咨询转化率
                    $data[$user->id]['data'][$office->id]['zx_trans_rate']=$data[$user->id]['data'][$office->id]['zixun_count']>0?sprintf("%.2f",$data[$user->id]['data'][$office->id]['arrive_count']*100.00/$data[$user->id]['data'][$office->id]['zixun_count'])."%":'0.00%';
                }
                $total[$office->id]['data']['yuyue_rate']=$total[$office->id]['data']['zixun_count']>0?sprintf('%.2f',$total[$office->id]['data']['yuyue_count']*100.00/$total[$office->id]['data']['zixun_count']).'%':'0.00%';
                $total[$office->id]['data']['contact_rate']=$total[$office->id]['data']['zixun_count']>0?sprintf('%.2f',$total[$office->id]['data']['contact_count']*100.00/$total[$office->id]['data']['zixun_count']).'%':'0.00%';
                $total[$office->id]['data']['arrive_rate']=$total[$office->id]['data']['should_count']>0?sprintf('%.2f',$total[$office->id]['data']['arrive_count']*100.00/$total[$office->id]['data']['should_count']).'%':'0.00%';
                $total[$office->id]['data']['jiuzhen_rate']=$total[$office->id]['data']['arrive_count']>0?sprintf('%.2f',$total[$office->id]['data']['jiuzhen_count']*100.00/$total[$office->id]['data']['arrive_count']).'%':'0.00%';
                $total[$office->id]['data']['zx_trans_rate']=$total[$office->id]['data']['zixun_count']>0?sprintf('%.2f',$total[$office->id]['data']['arrive_count']*100.00/$total[$office->id]['data']['zixun_count']).'%':'0.00%';
			}
		}
		//项目合计
		$datatotal=[];
		$datatotal['items']=$total;
        $datatotal['zixun_count']=0;
        $datatotal['yuyue_count']=0;
        $datatotal['contact_count']=0;
        $datatotal['arrive_count']=0;
        $datatotal['should_count']=0;
        $datatotal['jiuzhen_count']=0;
		foreach ($total as $d){
            $datatotal['zixun_count']+=$d['data']['zixun_count'];
            $datatotal['yuyue_count']+=$d['data']['yuyue_count'];
            $datatotal['contact_count']+=$d['data']['contact_count'];
            $datatotal['arrive_count']+=$d['data']['arrive_count'];
            $datatotal['should_count']+=$d['data']['should_count'];
            $datatotal['jiuzhen_count']+=$d['data']['jiuzhen_count'];
        }
        $datatotal['yuyue_rate']=$datatotal['zixun_count']>0?sprintf('%.2f',$datatotal['yuyue_count']*100.00/$datatotal['zixun_count']).'%':'0.00%';
        $datatotal['contact_rate']=$datatotal['zixun_count']>0?sprintf('%.2f',$datatotal['contact_count']*100.00/$datatotal['zixun_count']).'%':'0.00%';
        $datatotal['arrive_rate']=$datatotal['should_count']>0?sprintf('%.2f',$datatotal['arrive_count']*100.00/$datatotal['should_count']).'%':'0.00%';
        $datatotal['jiuzhen_rate']=$datatotal['arrive_count']>0?sprintf('%.2f',$datatotal['jiuzhen_count']*100.00/$datatotal['arrive_count']).'%':'0.00%';
        $datatotal['zx_trans_rate']=$datatotal['zixun_count']>0?sprintf('%.2f',$datatotal['arrive_count']*100.00/$datatotal['zixun_count']).'%':'0.00%';
//        dd($datatotal);
		//同咨询员项目合并
		foreach ($data as $k=>$d){
			$data[$k]['summary']['zixun_count']=0;
			$data[$k]['summary']['yuyue_count']=0;
			$data[$k]['summary']['contact_count']=0;
			$data[$k]['summary']['arrive_count']=0;
			$data[$k]['summary']['should_count']=0;
			$data[$k]['summary']['jiuzhen_count']=0;
			foreach ($d['data'] as $p){
				$data[$k]['summary']['zixun_count']+=$p['zixun_count'];
				$data[$k]['summary']['yuyue_count']+=$p['yuyue_count'];
				$data[$k]['summary']['contact_count']+=$p['contact_count'];
				$data[$k]['summary']['arrive_count']+=$p['arrive_count'];
				$data[$k]['summary']['should_count']+=$p['should_count'];
				$data[$k]['summary']['jiuzhen_count']+=$p['jiuzhen_count'];
			}
			$data[$k]['summary']['yuyue_rate']=$data[$k]['summary']['zixun_count']>0?sprintf('%.2f',$data[$k]['summary']['yuyue_count']*100.00/$data[$k]['summary']['zixun_count']).'%':'0.00%';
			$data[$k]['summary']['contact_rate']=$data[$k]['summary']['zixun_count']>0?sprintf('%.2f',$data[$k]['summary']['contact_count']*100.00/$data[$k]['summary']['zixun_count']).'%':'0.00%';
			$data[$k]['summary']['arrive_rate']=$data[$k]['summary']['should_count']>0?sprintf('%.2f',$data[$k]['summary']['arrive_count']*100.00/$data[$k]['summary']['should_count']).'%':'0.00%';
			$data[$k]['summary']['jiuzhen_rate']=$data[$k]['summary']['arrive_count']>0?sprintf('%.2f',$data[$k]['summary']['jiuzhen_count']*100.00/$data[$k]['summary']['arrive_count']).'%':'0.00%';
			$data[$k]['summary']['zx_trans_rate']=$data[$k]['summary']['zixun_count']>0?sprintf('%.2f',$data[$k]['summary']['arrive_count']*100.00/$data[$k]['summary']['zixun_count']).'%':'0.00%';
		}
		return view('zxcustomer.summary',[
			'pageheader'=>'预约明细',
			'pagedescription'=>'列表',
			'zxUsers'=>$this->getAllZxUser(),
			'data'=>$data,
            'start'=>$start,
            'end'=>$end,
            'cuser'=>$cuser,
            'datatotal'=>$datatotal,
		]);
    }

    //所有咨询员
	public function getAllZxUser(){
        $users=[];
        foreach (Auth::user()->offices as $office){
            $users=array_merge($users, $office->users->where('department_id',2)->where('is_active',1)->toArray());
        }
    	return $users;
	}
}
