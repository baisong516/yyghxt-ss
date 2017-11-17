<?php

namespace App\Http\Controllers;

use App\Disease;
use App\Doctor;
use App\Http\Requests\StoreZxCustomerRequest;
use App\Huifang;
use App\Media;
use App\Office;
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
            return view('zxcustomer.read',[
                'pageheader'=>'患者',
                'pagedescription'=>'列表',
                'customers'=>ZxCustomer::getCustomers(),
                'users'=>$this->getAllUserArray(),
                'offices'=>$this->getAllModelArray('offices'),
                'diseases'=>$this->getAllModelArray('diseases'),
                'webtypes'=>$this->getAllModelArray('web_types'),
                'medias'=>$this->getAllModelArray('medias'),
                'customertypes'=>$this->getAllModelArray('customer_types'),
                'customerconditions'=>$this->getAllModelArray('customer_conditions'),
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
            return view('zxcustomer.create', array(
                'pageheader'=>'患者',
                'pagedescription'=>'添加',
                'users'=>$this->getAllUserArray(),
                'offices'=>$this->getAuthdOffices(),
                'diseases'=>$this->getAuthdDiseases(),
                'doctors'=>$this->getAuthdDoctors(),
                'webtypes'=>$this->getAllModelArray('web_types'),
                'medias'=>$this->getAllModelArray('medias'),
                'customertypes'=>$this->getAllModelArray('customer_types'),
                'customerconditions'=>$this->getAllModelArray('customer_conditions'),
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
        if (Auth::user()->ability('superadministrator', 'update-zx_customers')){
            return view('zxcustomer.update', array(
                'pageheader'=>'患者',
                'pagedescription'=>'更新',
                'users'=>$this->getAllUserArray(),
                'offices'=>$this->getAuthdOffices(),
                'diseases'=>$this->getAuthdDiseases(),
                'doctors'=>$this->getAuthdDoctors(),
                'webtypes'=>$this->getAllModelArray('web_types'),
                'medias'=>$this->getAllModelArray('medias'),
                'customertypes'=>$this->getAllModelArray('customer_types'),
                'customerconditions'=>$this->getAllModelArray('customer_conditions'),
                'customer'=>ZxCustomer::findOrFail($id),
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
                return redirect()->route('zxcustomers.index')->with('success','Well Done!');
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

    private function getAllUserArray()
    {
        $obj=User::select('id','realname')->get();
        $users=[];
        foreach ($obj as $user){
            $users[$user->id]=$user->realname;
        }
        return $users;
    }

    private function getAllModelArray($table)
    {
        $obj=DB::table($table)->select('id','display_name')->get();
        $data=[];
        foreach ($obj as $v){
            $data[$v->id]=$v->display_name;
        }
        return $data;
    }
    private function getAuthdOffices()
    {
        $offices=[];
        foreach (Auth::user()->offices as $office){
            $offices[$office->id]=$office->display_name;
        }
        return $offices;
    }
    private function getAuthdDiseases()
    {
        $diseases=[];
        foreach (Auth::user()->offices as $office){
            $diseases[$office->id]['name']=$office->display_name;
            foreach ($office->diseases as $disease){
                $diseases[$office->id]['diseases'][$disease->id]=$disease->display_name;
            }
        }
        return $diseases;
    }

    public function getAuthdDoctors()
    {;
        return Doctor::whereIn('office_id',array_keys($this->getAuthdOffices()));

    }
    //咨询患者搜索
    public function customerSearch(Request $request)
    {
        $customerName=$request->input('searchCustomerName');
        $customerTel=$request->input('searchCustomerTel');
        $customerQQ=$request->input('searchCustomerQQ');
        $customerWechat=$request->input('searchCustomerWechat');
        $customerIdCard=$request->input('searchIdCard');
        $zxUser=$request->input('searchUserId');
        $officeId=$request->input('searchOfficeId');
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
        $customers=null;
        //条件为空
        if (empty($customerName)&&empty($customerTel)&&empty($customerQQ)&&empty($customerWechat)&&empty($customerIdCard)&&empty($zxUser)&&empty($officeId)&&empty($zx_start)&&empty($yy_start)&&empty($arrive_start)&&empty($last_huifang_start)&&empty($next_huifang_start)){
            $customers=ZxCustomer::getCustomers();
        }else{
            //按回访
            $CustomerIds=[];
            if (!empty($last_huifang_start)||!empty($next_huifang_start)){
                $huifangParms=array();
                if (!empty($last_huifang_start)){array_push($huifangParms,['now_at','>=',$last_huifang_start],['now_at','<=',$last_huifang_end]);}
                if (!empty($next_huifang_start)){array_push($huifangParms,['next_at','>=',$next_huifang_start],['next_at','<=',$next_huifang_end]);}
                $huifangCustomers=Huifang::select('zx_customer_id')->where($huifangParms)->get();
                $huifangCustomerIds=[];
                foreach ($huifangCustomers as $huifangCustomer){
                    $huifangCustomerIds[]=$huifangCustomer->zx_customer_id;
                }
                $CustomerIds = array_unique($huifangCustomerIds);
            }
            //按患者搜索
            $parms=array();
            if (!empty($customerName)){array_push($parms,['name','like','%'.$customerName.'%']);}
            if (!empty($customerTel)){array_push($parms,['tel','like','%'.$customerTel.'%']);}
            if (!empty($customerQQ)){array_push($parms,['qq','like','%'.$customerTel.'%']);}
            if (!empty($customerWechat)){array_push($parms,['wechat','like','%'.$customerWechat.'%']);}
            if (!empty($customerIdCard)){array_push($parms,['idcard','like','%'.$customerIdCard.'%']);}
            if (!empty($zxUser)){array_push($parms,['user_id','=',$zxUser]);}
            if (!empty($officeId)){array_push($parms,['office_id','=',$officeId]);}

            if (!empty($zx_start)){array_push($parms,['zixun_at','>=',$zx_start],['zixun_at','<=',$zx_end]);}
            if (!empty($yy_start)){array_push($parms,['yuyue_at','>=',$yy_start],['yuyue_at','<=',$yy_end]);}
            if (!empty($arrive_start)){array_push($parms,['arrive_at','>=',$arrive_start],['arrive_at','<=',$arrive_end]);}

            if (!empty($CustomerIds)){
                $customers =ZxCustomer::whereIn('id',$CustomerIds)->where($parms)->get();
            }else{
                $customers =ZxCustomer::where($parms)->get();
            }
        }
        return view('zxcustomer.read',[
            'pageheader'=>'患者',
            'pagedescription'=>'列表',
            'customers'=>$customers,
            'users'=>$this->getAllUserArray(),
            'offices'=>$this->getAllModelArray('offices'),
            'diseases'=>$this->getAllModelArray('diseases'),
            'webtypes'=>$this->getAllModelArray('web_types'),
            'medias'=>$this->getAllModelArray('medias'),
            'customertypes'=>$this->getAllModelArray('customer_types'),
            'customerconditions'=>$this->getAllModelArray('customer_conditions'),
        ]);
    }
}
