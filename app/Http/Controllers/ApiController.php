<?php

namespace App\Http\Controllers;
use App\Aiden;
use App\Disease;
use App\GhCustomer;
use App\GhHuifang;
use App\Hospital;
use App\Huifang;
use App\Office;
use App\PersonTarget;
use App\Statistic;
use App\User;
use App\ZxCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use mysqli;

class ApiController extends Controller
{
    public function checkExistCustomer(Request $request)
    {
        $tel=$request->input('tel');
        $wechat=$request->input('wechat');
        if (empty($tel)&&empty($wechat)){return response()->json(['num'=>0,'tip'=>'']);}
        if (!empty($tel)){return response()->json(['num'=>ZxCustomer::where('tel',$tel)->count(),'tip'=>'此电话在系统中已存在，仍坚持录入吗？']);}
        if (!empty($wechat)){return response()->json(['num'=>ZxCustomer::where('wechat',$wechat)->count(),'tip'=>'此微信号在系统中已存在，仍坚持录入吗？']);}
    }
    public function drawTest(Request $request)
    {
        $imgData=$request->input('img');
        $url=Storage::disk('local')->put('img.txt', $imgData);
    }
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

    public function getDetailFromCustomer(Request $request)
    {
        $customerId=$request->input('zx_customer_id');
        $status=0;
        $customer=ZxCustomer::findOrFail($customerId);
        if ($customer){$status=1;}
        $sex=['male'=>'男','female'=>'女'];
        $doctors=Aiden::getAllModelArray('doctors');
        $medias=Aiden::getAllModelArray('medias');
        $webtypes=Aiden::getAllModelArray('web_types');
        $users=Aiden::getAllUserArray();
        $causes=Aiden::getAllModelArray('causes');
        $customerconditions=Aiden::getAllModelArray('customer_conditions');
        $offices=Aiden::getAllModelArray('offices');
        $diseases=Aiden::getAllModelArray('diseases');
        $customertypes=Aiden::getAllModelArray('customer_types');

        $data['name']=$customer->name?$customer->name:'';
        $data['age']=$customer->age?$customer->age:'';
        $data['sex']=$customer->sex?$sex[$customer->sex]:'';
        $data['tel']=$customer->tel?$customer->tel:'';
        $data['qq']=$customer->qq?$customer->qq:'';
        $data['city']=$customer->city?$customer->city:'';
        $data['doctor']=$customer->doctor_id?$doctors[$customer->doctor_id]:'';
        $data['wechat']=$customer->wechat?$customer->wechat:'';
        $data['idcard']=$customer->idcard?$customer->idcard:'';
        $data['keywords']=$customer->keywords?$customer->keywords:'';
        $data['media']=$customer->media_id?$medias[$customer->media_id]:'';
        $data['webtype']=$customer->webtype_id?$webtypes[$customer->webtype_id]:'';
        $data['user']=$customer->user_id?$users[$customer->user_id]:'';
        $data['jingjia_user']=$customer->jingjia_user_id?$users[$customer->jingjia_user_id]:'';
        $data['cause']=$customer->cause_id?$causes[$customer->cause_id]:'';
        $data['customer_condition']=$customer->customer_condition_id?$customerconditions[$customer->customer_condition_id]:'';
        $data['description']=$customer->description?$customer->description:'';
        $data['zixun_at']=$customer->zixun_at?$customer->zixun_at:'';
        $data['yuyue_at']=$customer->yuyue_at?$customer->yuyue_at:'';
        $data['time_slot']=$customer->time_slot?$customer->time_slot:'';
        $data['arrive_at']=$customer->arrive_at?$customer->arrive_at:'';
        $data['office']=$customer->office_id?$offices[$customer->office_id]:'';
        $data['disease']=$customer->disease_id?$diseases[$customer->disease_id]:'';
        $data['customer_type']=$customer->customer_type_id?$customertypes[$customer->customer_type_id]:'';
        $data['addons']=$customer->addons?$customer->addons:'';
        return response()->json([
            'status'=>$status,
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

    public static function getZxUsersFromOffice(Request $request)
    {
        $officeId=$request->input('office_id');
        $users=Office::findOrFail($officeId)->users->where('is_active',1)->where('department_id',2);
        $usersArray=[];
        foreach ($users as $user){
            $usersArray[]=[
                'id'=>$user->id,
                'name'=>$user->realname,
            ];
        }
        $status=0;
        if (!empty($usersArray)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$usersArray,
        ]);
    }

    public static function getJjUsersFromOffice(Request $request)
    {
        $officeId=$request->input('office_id');
        $users=Office::findOrFail($officeId)->users->where('is_active',1)->where('department_id',1);
        $usersArray=[];
        foreach ($users as $user){
            $usersArray[]=[
                'id'=>$user->id,
                'name'=>$user->realname,
            ];
        }
        $status=0;
        if (!empty($usersArray)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$usersArray,
        ]);
    }

    public function getValuesFromType(Request $request)
    {
        $type=$request->input('type');
        $data=[];
        if ($type=='area'){
            $data=Aiden::getAllModelArray('areas');
        }elseif ($type=='platform'){
            $data=Aiden::getAllModelArray('platforms');
        }elseif ($type=='disease'){
            $data=$this->getAllDiseases();
        }
        return response()->json([
            'type'=>$type,
            'data'=>$data,
        ]);
    }

    //挂号患者录入接口
    public function guaHao(Request $request)
    {
        $data=[];
        $ghName=$request->input('gh_name');
        $ghTel=$request->input('gh_tel');
        if (empty($request->input('gh_offices'))){
            $data=[
                'type'=>'error',
                'content'=>'科室不能为空！',
            ];
        }elseif (empty($ghName)){
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
            //gh_refurl gh_offices gh_name gh_sex gh_age gh_tel gh_disease gh_des gh_date
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
        $hospitalName=$request->input('flag');
        $officeName=$request->input('office');
        $type=$request->input('type');//pc or mobile
        if (empty($hospitalName)){return $this->errorResponse();}
        $hospital=Hospital::where('name',$hospitalName)->first();
        if (empty($hospital)){return $this->errorResponse();}
        $ghjs=file_get_contents('template/gh.js');
        $dataToReplace=['hospitalTel','hospitalId','officeId','diseaseOptions','layPath'];
        if (empty($officeName)){
            $hospitalTel=$hospital->tel;
            $officeId=$hospital->offices()->first()->id;
        }else{
            $office=Office::where('name',$officeName)->first();
            $hospitalTel=$office->tel;
            $officeId=$office->id;
        }
        $hospitalId=$hospital->id;
        $layPath=$type=='p'?'/layer/':'/layer_mobile/';
        $office=Office::findOrFail($officeId);
        $diseaseOptions='';
        foreach ($office->diseases as $disease){
            $diseaseOptions.='<option value="'.$disease->id.'">'.$disease->display_name.'</option>';
        }
        foreach ($dataToReplace as $v){
            $ghjs=str_replace('{$_'.$v.'}',$$v,$ghjs);
        }
        return response($ghjs, 200)
            ->header('Content-Type', 'application/javascript')
            ->header('charset', 'utf-8');
    }
    //病种数据接口
    public function getDisease(Request $request){
        //测试数据
        $office_id=$request->input('office_id');
        $data=[];
        if (empty($office_id)){
            $offices=Aiden::getAllModelArray('offices');
            foreach ($offices as $oid=>$office){
                $data[$oid]=[
                    'id'=>$oid,
                    'name'=>$office,
                ];
                $data[$oid]['diseases']=[];
                $diseases=Disease::select('id','display_name')->where('office_id',$oid)->get();
                foreach ($diseases as $disease){
                    $data[$oid]['diseases'][]=[
                        'id'=>$disease->id,
                        'name'=>$disease->display_name,
                    ];
                }
            }
        }else{
            $diseases=Disease::select('id','display_name')->where('office_id',$office_id)->get();
            $data=$diseases;
        }
        return response()->json($data);
    }
    //按钮统计
    public function saveClickCount(Request $request)
    {
        $domain=$request->input('domain');
        $flag=$request->input('flag');
        $description=$request->input('des');
        $office_id=$request->input('office')?$request->input('office'):1;
        if (empty($domain)||empty($flag)){return $this->errorResponse();}
        $date_tag=Carbon::now()->toDateString();
        $click=Statistic::where('domain',$domain)->where('flag',$flag)->where('date_tag',$date_tag)->first();
        if (empty($click)) {
            $click = new Statistic();
            $click->domain=$domain;
            $click->flag=$flag;
            $click->description=$description;
            $click->date_tag=$date_tag;
            $click->office_id=$office_id;
            $click->count=1;
            $click->save();
        }else{
            $count=$click->count;
            $click->count=$count + 1;
            $click->save();
        }
        return response()->jsonp($request->input('callback'),['status'=>1, 'data'=>'ok']);
    }
    //错误信息
    public function errorResponse(){
        return response()->json([
            'status'=>0,
            'data'=>'errorMsg',
        ]);
    }

    public function dumpHe359484408()
    {
//        $servername = "119.23.71.145";
//        $username = "aiden";
//        $password = "adming";
//        $dbname = "he359484408";
//
//        // 创建连接
//        $conn = new mysqli($servername, $username, $password, $dbname);
//        // Check connection
//        if ($conn->connect_error) {
//            die("连接失败: " . $conn->connect_error);
//        }
//        $sql = "SELECT * FROM main";
//        $result = $conn->query($sql);
//
//        $data=[];
//        if ($result->num_rows > 0) {
//            // 输出数据
//            while($row = $result->fetch_assoc()) {
//                $data[]=$row;
//            }
//        } else {
//            echo "0 结果";
//        }
//        //导出
//        Excel::create('main', function($excel) use($data) {
//
//            $excel->sheet('Sheetname', function($sheet) use($data) {
//
//                $sheet->fromArray($data);
//
//            });
//
//        })->export('xls');
//        //关闭连接
//        $conn->close();
    }

    public function getAllDiseases()
    {
        $diseases=[];
        foreach (Office::all() as $office){
            $diseases[$office->id]['name']=$office->display_name;
            foreach ($office->diseases as $disease){
                $diseases[$office->id]['diseases'][$disease->id]=$disease->display_name;
            }
        }
        return $diseases;
    }

    public function getZxUserProgress(Request $request)
    {
        $data=[];
        $office_id=$request->input('office_id');
        $year=$request->input('year');
        $month=$request->input('month');
        $user_id=$request->input('user_id');
        if (empty($month)||$month=='fullyear'){//年度数据
            $targets=PersonTarget::getTargetData($year);
        }else{//月数据
            //todo
            $targets=PersonTarget::getTargetData($month);
        }
        return $data;
    }
}
