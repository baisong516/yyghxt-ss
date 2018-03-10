<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\ZxCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MzCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-mz_customers')){
            return view('mzcustomer.read',[
                'pageheader'=>'患者',
                'pagedescription'=>'列表',
                'customers'=>ZxCustomer::getCustomers(800),
                'users'=>Aiden::getAllUserArray(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
                'enableRead'=>Auth::user()->hasPermission('read-mz_customers'),
                'enableUpdate'=>Auth::user()->hasPermission('update-mz_customers'),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->ability('superadministrator', 'read-mz_customers')){
            return view('mzcustomer.detail', array(
                'pageheader'=>'患者',
                'pagedescription'=>'详情',
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
    public function edit($id)
    {
        if (Auth::user()->ability('superadministrator', 'update-mz_customers')){
            return view('mzcustomer.update', array(
                'pageheader'=>'患者',
                'pagedescription'=>'更新',
                'offices'=>Aiden::getAuthdOffices(),
                'diseases'=>Aiden::getAuthdDiseases(),
                'doctors'=>Aiden::getAuthdDoctors(),
                'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
                'customer'=>ZxCustomer::findOrFail($id),
            ));
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-mz_customers')){
            $customer=ZxCustomer::findOrFail($id);
            $customer->arrive_at=$request->input('arrive_at');
            $customer->customer_condition_id=$request->input('customer_condition_id');
            $bool=$customer->save();
            if ($bool){
                return redirect()->route('menzhens.index')->with('success','Well Done!');
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
        //
    }

    //搜索
    public function customerSearch(Request $request)
    {
        $customerName=$request->input('searchCustomerName');
        $customerTel=$request->input('searchCustomerTel');
        $customerQQ=$request->input('searchCustomerQQ');
        $customerWechat=$request->input('searchCustomerWechat');
        $officeId=$request->input('searchOfficeId');
        $zx_start=$request->input('searchZxStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchZxStart'))->startOfDay():null;
        $zx_end=$request->input('searchZxEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchZxEnd'))->endOfDay():Carbon::now()->endOfDay();
        $yy_start=$request->input('searchYuyueStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchYuyueStart'))->startOfDay():null;
        $yy_end=$request->input('searchYuyueEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchYuyueEnd'))->endOfDay():Carbon::now()->endOfDay();
        $arrive_start=$request->input('searchArriveStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchArriveStart'))->startOfDay():null;
        $arrive_end=$request->input('searchArriveEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchArriveEnd'))->endOfDay():Carbon::now()->endOfDay();
        $customers=null;
        //条件为空
        if (empty($customerName)&&empty($customerTel)&&empty($customerQQ)&&empty($customerWechat)&&empty($officeId)&&empty($zx_start)&&empty($yy_start)&&empty($arrive_start)){
            $customers=ZxCustomer::getCustomers();
        }else{
            $parms=array();
            if (!empty($customerName)){array_push($parms,['name','like','%'.$customerName.'%']);}
            if (!empty($customerTel)){array_push($parms,['tel','like','%'.$customerTel.'%']);}
            if (!empty($customerQQ)){array_push($parms,['qq','like','%'.$customerTel.'%']);}
            if (!empty($customerWechat)){array_push($parms,['wechat','like','%'.$customerWechat.'%']);}
            if (!empty($zxUser)){array_push($parms,['user_id','=',$zxUser]);}
            if (!empty($officeId)){array_push($parms,['office_id','=',$officeId]);}
            if (!empty($zx_start)){array_push($parms,['zixun_at','>=',$zx_start],['zixun_at','<=',$zx_end]);}
            if (!empty($yy_start)){array_push($parms,['yuyue_at','>=',$yy_start],['yuyue_at','<=',$yy_end]);}
            if (!empty($arrive_start)){array_push($parms,['arrive_at','>=',$arrive_start],['arrive_at','<=',$arrive_end]);}
            $customers =ZxCustomer::where($parms)->whereIn('office_id',ZxCustomer::offices())->with('huifangs')->get();
        }
        return view('mzcustomer.read',[
            'pageheader'=>'患者',
            'pagedescription'=>'列表',
            'customers'=>$customers,
            'users'=>Aiden::getAllUserArray(),
            'offices'=>Aiden::getAllModelArray('offices'),
            'diseases'=>Aiden::getAllModelArray('diseases'),
            'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
            'enableRead'=>Auth::user()->hasPermission('read-mz_customers'),
            'enableUpdate'=>Auth::user()->hasPermission('update-mz_customers'),
        ]);
    }
}
