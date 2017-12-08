<?php

namespace App\Http\Controllers;

use App\Disease;
use App\GhCustomer;
use App\GhHuifang;
use App\Hospital;
use App\Huifang;
use App\Office;
use App\Statistic;
use App\User;
use App\ZxCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getOfficesFromHospital(Request $request){
        $hospital_id=$request->input('hospital_id');
        $offices = Office::where('hospital_id',$hospital_id)->get();
        $data=[];
        $status=0;
        foreach ($offices as $office){
            $data[]=[
                'id'=>$office->id,
                'display_name'=>$office->display_name,
            ];
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$data,
        ]);
    }
    public function getOfficesFromHospitals(Request $request){
        $hospitals=$request->input('hospitals');
        $data=array();
        $status=0;
        if (!empty($hospitals)){
            $offices = Office::select('id','hospital_id','display_name')->whereIn('hospital_id',$hospitals)->get();
            foreach ($offices as $office){
                $data['hos_'.$office->hospital_id]['hospital']=Hospital::find($office->hospital_id)->display_name;
                $data['hos_'.$office->hospital_id]['offices'][]=[
                    'id'=>$office->id,
                    'display_name'=>$office->display_name,
                ];
            }
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$data,
        ]);
    }

    public function getHuifangsFromCustomer(Request $request)
    {
        $customerId=$request->input('zx_customer_id');
        $huifangs = Huifang::where('zx_customer_id',$customerId)->get();
        $data=[];
        $status=0;
        foreach ($huifangs as $huifang){
            $data[]=[
                'user_id'=>$huifang->now_user_id,
                'user'=>User::findOrFail($huifang->now_user_id)->realname,
                'now_at'=>$huifang->now_at,
                'content'=>$huifang->description,
            ];
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'customer'=>ZxCustomer::findOrFail($customerId)->name,
            'customer_id'=>$customerId,
            'data'=>$data,
        ]);
    }

    public function getHuifangsFromGhCustomer(Request $request)
    {
        $customerId=$request->input('gh_customer_id');
        $huifangs = GhHuifang::where('gh_customer_id',$customerId)->get();
        $data=[];
        $status=0;
        foreach ($huifangs as $huifang){
            $data[]=[
                'user_id'=>$huifang->now_user_id,
                'user'=>User::findOrFail($huifang->now_user_id)->realname,
                'now_at'=>$huifang->now_at,
                'content'=>$huifang->description,
            ];
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'customer'=>GhCustomer::findOrFail($customerId)->gh_name,
            'customer_id'=>$customerId,
            'data'=>$data,
        ]);
    }

    public function getDiseasesFromOffice(Request $request)
    {
        $officeId=$request->input('office_id');
        $diseases = Disease::where('office_id',$officeId)->get();
        $data=[];
        $status=0;
        foreach ($diseases as $disease){
            $data['name']=Office::findOrFail($officeId)->display_name;
            $data['diseases'][]=[
                'id'=>$disease->id,
                'display_name'=>$disease->display_name,
            ];
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$data,
        ]);
    }

    //挂号患者录入接口
    public function guaHao(Request $request)
    {
        $data=[];
        $ghName=$request->input('gh_name');
        $ghTel=$request->input('gh_tel');
        if (empty($ghName)){
            $data=[
                'type'=>'error',
                'content'=>'姓名不能为空！',
            ];
        } elseif (empty($ghTel)){
            $data=[
                'type'=>'error',
                'content'=>'电话不能为空！',
            ];
        }else{
            //检测电话合法性
            if(!preg_match("/^1[34578]{1}\d{9}$/",$ghTel)){
                return response()->jsonp($request->input('callback'),[
                    'type'=>'error',
                    'content'=>'请输入正确的手机号！',
                ]);
            }
            //gh_hosptial gh_refurl gh_offices gh_name gh_sex gh_age gh_tel gh_disease gh_des gh_date
            $customer=new GhCustomer();
            $customer->gh_name=$request->input('gh_name');
            $customer->gh_age=$request->input('gh_age');
            $customer->gh_sex=$request->input('gh_sex');
            $customer->gh_tel=$request->input('gh_tel');
            $customer->gh_office=$request->input('gh_offices');
            $customer->gh_disease=$request->input('gh_disease')=='normal'?null:$request->input('gh_disease');
            $ghDate=$request->input('gh_date');
            $ghDate=$ghDate?Carbon::createFromFormat('Y-m-d',str_replace('/','-',$ghDate)):Carbon::now();
            $customer->gh_date=$ghDate;
            $customer->gh_description=$request->input('gh_description');
            $customer->gh_ref=$request->input('gh_refurl');
            $bool=$customer->save();
            $bool?$data=[
                'type'=>'success',
                'content'=>'success',
            ]:$data=[
                'type'=>'error',
                'content'=>'服务器错误！',
            ];
        }
        return response()->jsonp($request->input('callback'),$data);
    }
    //输出挂号js文件
    public function guaHaoJs(Request $request)
    {
        $flag=$request->input('flag');
        $type=$request->input('type');
        if (empty($flag)){return $this->errorResponse();}
        $hospital=Hospital::where('name',$flag)->first();
        if (empty($hospital)){return $this->errorResponse();}
        $ghjs=file_get_contents('template/gh.js');
        $dataToReplace=['hospitalTel','hospitalId','officeId','diseaseOptions','layPath'];
        $hospitalTel=$hospital->tel;
        $hospitalId=$hospital->id;
        $officeId=$hospital->offices()->first()->id;
        $layPath=$type=='p'?'/layer/':'/layer_mobile/';
        $diseaseOptions='';
        foreach ($hospital->diseases as $disease){
            $diseaseOptions.='<option value="'.$disease->id.'">'.$disease->display_name.'</option>';
        }
        foreach ($dataToReplace as $v){
            $ghjs=str_replace('{$_'.$v.'}',$$v,$ghjs);
        }
        return response($ghjs, 200)
            ->header('Content-Type', 'application/javascript')
            ->header('charset', 'utf-8');
    }
    //科室数据接口
    public function getDiseaseArray(){
        //测试数据
        $diseases=Disease::select('id','display_name')->where('office_id',2)->get();

        $diseasesArr=[];
        $status=0;
        foreach ($diseases as $disease){
            $diseasesArr[$disease->id]=$disease->display_name;
        }
        if (!empty($diseasesArr)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$diseasesArr,
        ]);
    }
    //错误信息
    public function errorResponse(){
        return response()->json([
            'status'=>0,
            'data'=>'errorMsg',
        ]);
    }

    //按钮点击统计
    public function buttonStatistic(Request $request)
    {
        //domain flag date_tag count
        dd($request->all());
        $domain=$request->input('domain');
        $flag=$request->input('flag');
        if (empty($domain)){return $this->errorResponse();}
        if (empty($flag)){return $this->errorResponse();}
        $description=$request->input('des')?$request->input('des'):'';
        $date_tag=Carbon::now()->toDateString();

        $data=Statistic::where('domain',$domain)->where('flag',$flag)->where('date_tag',$date_tag)->first();
        if (empty($data)){
            $data=new Statistic();
            $data->domain=$domain;
            $data->flag=$flag;
            $data->date_tag=$date_tag;
            $data->count=1;
            $data->description=$description;
            $data->save();
        }else{
            $data->count=$data->count+1;
            $data->save();
            dd($data);
        }
        return response()->json([
            'status'=>1,
            'data'=>'ok',
        ]);

    }
}
