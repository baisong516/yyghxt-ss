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
            //目标
//            $targets=PersonTarget::getTargetDataArray($year);
//            $monthtargets=PersonTarget::getTargetDataArray(1,$year,$month);
//            dd($monthtargets);
            //本月
            $monthOutputs=OutputZx::getZxOutputs(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth());
            //上月
            $lastMonthOutputs = OutputZx::getZxOutputs(Carbon::now()->subMonth(1)->startOfMonth(),Carbon::now()->subMonth(1)->endOfMonth());
//            dd($lastMonthOutputs);
            //本年度
            $yearOutputs=OutputZx::getZxOutputs(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
            return view('outputzx.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出',
                'users'=>Aiden::getAllUserArray(),
                'year'=>$year,
                'month'=>$month,
//                'targets'=>$targets,
                'monthOutputs'=>$monthOutputs,
                'lastMonthOutputs'=>$lastMonthOutputs,
                'yearOutputs'=>$yearOutputs,
                'offices'=>Aiden::getAllModelArray('offices'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-zxoutputs')){
            if (empty($request->input('searchMonth'))){return redirect()->back()->with('error','没有选择日期！');}
            $date=$request->input('searchMonth');
            $year=Carbon::createFromFormat('Y-m',$date)->year;
            $month=Carbon::createFromFormat('Y-m',$date)->month;
            //目标
//            $targets=PersonTarget::getTargetData($year);
//            dd($targets);
            //本月
//            dd($date->startOfMonth());
            $monthOutputs=OutputZx::getZxOutputs(Carbon::createFromFormat('Y-m',$date)->startOfMonth(),Carbon::createFromFormat('Y-m',$date)->endOfMonth());
            //上月
            $lastMonthOutputs = OutputZx::getZxOutputs(Carbon::createFromFormat('Y-m',$date)->subMonth(1)->startOfMonth(),Carbon::createFromFormat('Y-m',$date)->subMonth(1)->endOfMonth());
//            dd($lastMonthOutputs);
            //本年度
            $yearOutputs=OutputZx::getZxOutputs(Carbon::createFromFormat('Y-m',$date)->startOfYear(),Carbon::createFromFormat('Y-m',$date)->endOfYear());
            return view('outputzx.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出',
                'users'=>Aiden::getAllUserArray(),
                'year'=>$year,
                'month'=>$month,
//                'targets'=>$targets,
                'monthOutputs'=>$monthOutputs,
                'lastMonthOutputs'=>$lastMonthOutputs,
                'yearOutputs'=>$yearOutputs,
                'offices'=>Aiden::getAllModelArray('offices'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
