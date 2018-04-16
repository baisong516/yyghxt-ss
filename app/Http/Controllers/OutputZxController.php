<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\OutputZx;
use App\PersonTarget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OutputZxController extends Controller
{
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-zxoutputs')){
            $year=Carbon::now()->year;
            $month=Carbon::now()->month;
            $toutputs=OutputZx::getZxOutputs(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth());

            return view('outputzx.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出',
                'users'=>Aiden::getAllUserArray(),
                'year'=>$year,
                'month'=>$month,
//                'targets'=>$targets,
                'toutputs'=>$toutputs,
                'offices'=>Aiden::getAllModelArray('offices'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-zxoutputs')){
            $yearSearch=false;
            $quickSearch=$request->input('quickSearch');
            if (!empty($quickSearch)){//快捷搜索
                if($quickSearch=='thisMonth'){
                    $year=Carbon::now()->year;
                    $month=Carbon::now()->month;
                }elseif ($quickSearch=='lastMonth'){
                    $year=Carbon::now()->subMonth(1)->year;
                    $month=Carbon::now()->subMonth(1)->month;
                }elseif ($quickSearch=='thisYear'){
                    $yearSearch=true;
                    $year=Carbon::now()->year;
                    $month='fullyear';
                }
            }else{//按月搜索
                if (empty($request->input('searchMonth'))){return redirect()->back()->with('error','没有选择日期！');}
                $date=$request->input('searchMonth');
                $year=Carbon::createFromFormat('Y-m',$date)->year;
                $month=Carbon::createFromFormat('Y-m',$date)->month;
            }
            if ($yearSearch){
                $outputs=OutputZx::getZxOutputs(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
            }else{
                $outputs=OutputZx::getZxOutputs(Carbon::createFromFormat('Y-m',$year.'-'.$month)->startOfMonth(),Carbon::createFromFormat('Y-m',$year.'-'.$month)->endOfMonth());
            }
            return view('outputzx.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出',
                'users'=>Aiden::getAllUserArray(),
                'year'=>$year,
                'month'=>$month,
//                'targets'=>$targets,
                'toutputs'=>$outputs,
                'offices'=>Aiden::getAllModelArray('offices'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
