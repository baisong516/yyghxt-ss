<?php

namespace App\Http\Controllers;
use App\Aiden;
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
use Maatwebsite\Excel\Facades\Excel;
use mysqli;

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
}
