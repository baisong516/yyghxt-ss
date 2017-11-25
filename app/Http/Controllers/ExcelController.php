<?php

namespace App\Http\Controllers;

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

        Excel::create($fileName, function($excel) use($request) {
            $options=$this->getOptions();
            $zxCustomerSelect=$request->input('zx_customers');
            $excel->sheet($options['zx_customers']['name'], function($sheet) use ($zxCustomerSelect,$options){
                $zxCustomers=ZxCustomer::select($zxCustomerSelect)->whereIn('office_id',ZxCustomer::offices())->get()->toArray();
//                dd()
                $customers=[];
                $sheet->fromArray($customers);
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
