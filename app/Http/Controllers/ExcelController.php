<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\ZxCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index()
    {
//        dd(Aiden::getAllModelArray('customer_conditions'));
        if (Auth::user()->ability('superadministrator', 'create-zx_excels')){
            return view('excel.create',[
                'pageheader'=>'Excel表导出',
                'pagedescription'=>'设置',
                'offices'=>Aiden::getAuthdOffices(),
                'status'=>Aiden::getAllModelArray('customer_conditions'),
                'options'=>$this->getOptions(),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
    public function exportExcel(Request $request)
    {
        $fileName=Carbon::now()->toDateString();//excel文件名
        $zxCustomerSelect=$request->input('zx_customers');
        $timeStart=$request->input('zxStart')?Carbon::createFromFormat('Y-m-d',$request->input('zxStart'))->startOfDay():Carbon::now()->startOfDay();
        $timeEnd=$request->input('zxEnd')?Carbon::createFromFormat('Y-m-d',$request->input('zxEnd'))->endOfDay():Carbon::now()->endOfDay();
        $offices=$request->input('offices');
        $customerconditions=$request->input('customerConditions');
        if (empty($zxCustomerSelect)){
            return redirect()->back()->with('error','Nothing selected!');
        }
        Excel::create($fileName, function($excel) use($zxCustomerSelect,$timeStart,$timeEnd,$offices,$customerconditions) {
            $options=$this->getOptions();
            $excel->sheet($options['zx_customers']['name'], function($sheet) use ($zxCustomerSelect,$options,$timeStart,$timeEnd,$offices,$customerconditions){
                $zxCustomers=null;
                if (empty($timeStart)){
                    $zxCustomers=ZxCustomer::select($zxCustomerSelect)->whereIn('office_id',$offices)->whereIn('customer_condition_id',$customerconditions)->orderBy('zixun_at','asc')->get()->toArray();
                }else{
                    $zxCustomers=ZxCustomer::select($zxCustomerSelect)->where([
                        ['zixun_at','>=',$timeStart],
                        ['zixun_at','<=',$timeEnd],
                    ])->whereIn('office_id',$offices)->whereIn('customer_condition_id',$customerconditions)->orderBy('zixun_at','asc')->get()->toArray();
                }
                $medias=Aiden::getAllModelArray('medias');
                $webtypes=Aiden::getAllModelArray('web_types');
                $offices=Aiden::getAllModelArray('offices');
                $diseases=Aiden::getAllModelArray('diseases');
                $customertypes=Aiden::getAllModelArray('customer_types');
                $custconditions=Aiden::getAllModelArray('customer_conditions');
                $users=Aiden::getAllUserArray();
                $customers=[];
                foreach ($zxCustomers as $customer){
                    if (isset($customer['sex'])){
                        if ($customer['sex']=='female'){
                            $customer['sex']='女';
                        }elseif ($customer['sex']=='male'){
                            $customer['sex']='男';
                        }else{
                            $customer['sex']='';
                        }
                    }
                    if (isset($customer['media_id'])){$customer['media_id']=$customer['media_id']?$medias[$customer['media_id']]:'';}
                    if (isset($customer['webtype_id'])){$customer['webtype_id']=$customer['webtype_id']?$webtypes[$customer['webtype_id']]:'';}
                    if (isset($customer['customer_type_id'])){$customer['customer_type_id']=$customer['customer_type_id']?$customertypes[$customer['customer_type_id']]:'';}
                    if (isset($customer['customer_condition_id'])){$customer['customer_condition_id']=$customer['customer_condition_id']?$custconditions[$customer['customer_condition_id']]:'';}
                    if (isset($customer['office_id'])){$customer['office_id']=$customer['office_id']?$offices[$customer['office_id']]:'';}
                    if (isset($customer['disease_id'])){$customer['disease_id']=$customer['disease_id']?$diseases[$customer['disease_id']]:'';}
                    if (isset($customer['user_id'])){$customer['user_id']=$customer['user_id']?$users[$customer['user_id']]:'';}
                    $customers[]=$customer;
                }
                $sheet->fromArray($customers);
//                $sheet->cells('A1:Z1', function($cells) {
//                    $cells->setBackground('#66d7ea');
//                });
                //设置标题行
                $columns=[];
                foreach ($zxCustomerSelect as $v){
                    $columns[]=$options['zx_customers']['data'][$v];
                }
                $sheet->row(1, $columns);
                //冻结第一行
                //$sheet->freezeFirstRow();
                //$sheet->setAutoFilter();
            });
        })->export('xls');
    }

    private function getOptions()
    {
        $options['zx_customers']['name']='咨询患者';
        $options['zx_customers']['data']=[
            'name'=>'姓名',
            'age'=>'年龄',
            'sex'=>'性别',
            'tel'=>'电话',
            'qq'=>'QQ',
            'wechat'=>'微信',
            'idcard'=>'商务通ID',
            'city'=>'城市',
            'keywords'=>'搜索关键字',
            'media_id'=>'媒体类型',
            'webtype_id'=>'网站类型',
            'customer_condition_id'=>'患者状态',
            'customer_type_id'=>'患者类型',
            'office_id'=>'科室',
            'disease_id'=>'病种',
            'user_id'=>'咨询员',
            'zixun_at'=>'咨询时间',
            'yuyue_at'=>'预约时间',
            'arrive_at'=>'到院时间',
            'addons'=>'备注',
        ];
        return $options;
    }
}
