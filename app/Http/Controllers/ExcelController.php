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
        if (Auth::user()->ability('superadministrator', 'create-excel')){
            return view('excel.create',[
                'pageheader'=>'Excel表导出',
                'pagedescription'=>'设置',
                'options'=>$this->getOptions(),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
    public function exportExcel(Request $request)
    {
        $fileName=Carbon::now()->toDateString();
        $zxCustomerSelect=$request->input('zx_customers');
        if (empty($zxCustomerSelect)){
            return redirect()->back()->with('error','Nothing selected!');
        }
        Excel::create($fileName, function($excel) use($zxCustomerSelect) {
            $options=$this->getOptions();
            $excel->sheet($options['zx_customers']['name'], function($sheet) use ($zxCustomerSelect,$options){
                $zxCustomers=ZxCustomer::select($zxCustomerSelect)->whereIn('office_id',ZxCustomer::offices())->get()->toArray();
                $medias=Aiden::getAllModelArray('medias');
                $webtypes=Aiden::getAllModelArray('web_types');
                $offices=Aiden::getAllModelArray('offices');
                $diseases=Aiden::getAllModelArray('diseases');
                $customertypes=Aiden::getAllModelArray('customer_types');
                $customers=[];
                foreach ($zxCustomers as $customer){
                    if ($customer['sex']=='female'){
                        $customer['sex']='女';
                    }elseif ($customer['sex']=='male'){
                        $customer['sex']='男';
                    }else{
                        $customer['sex']='';
                    }
                    $customer['media_id']=$customer['media_id']?$medias[$customer['media_id']]:'';
                    $customer['webtype_id']=$customer['webtype_id']?$webtypes[$customer['webtype_id']]:'';
                    $customer['customer_type_id']=$customer['customer_type_id']?$customertypes[$customer['customer_type_id']]:'';
                    $customer['office_id']=$customer['office_id']?$offices[$customer['office_id']]:'';
                    $customer['disease_id']=$customer['disease_id']?$diseases[$customer['disease_id']]:'';
                    $customers[]=$customer;
                }
                $sheet->fromArray($customers);
                //设置标题行
                $columns=[];
                foreach ($zxCustomerSelect as $v){
                    $columns[]=$options['zx_customers']['data'][$v];
                }
                $sheet->row(1, $columns);
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
            'customer_type_id'=>'患者类型',
            'office_id'=>'科室',
            'disease_id'=>'病种',
        ];
        return $options;
    }
}
