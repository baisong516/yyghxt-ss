<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Progress;
use App\Target;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-progress')){
            $year=Carbon::now()->year;
            $month=Carbon::now()->month;
            //目标
            $target=Target::getTargetData($year);
//            dd($target);
            //完成情况
            $complete=Progress::getCompleted($year);
//            dd($complete);
            return view('progress.read',[
                'pageheader'=>'完成进度',
                'pagedescription'=>'报表',
                'offices'=>Aiden::getAllModelArray('offices'),
                'complete'=>$complete,
                'year'=>$year,
                'month'=>$month,
                'target'=>$target,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-progress')){
            $monthSub=$request->input('monthSub');
            if ($monthSub==null){
                $searchDate=$request->input('searchDate');
                $date=Carbon::createFromFormat('Y-m',$searchDate);
            }else{
                $date=Carbon::createFromFormat('Y-m',$monthSub);
            }
            $year=$date->year;
            $month=$date->month;
            //目标
            $target=Target::getTargetData($year);
//            $data=Auction::getAuctionData($start,$end);
//            dd(Report::getReportData($start->toDateString(),$end->toDateString()));
            return view('progress.read',[
                'pageheader'=>'完成进度',
                'pagedescription'=>'报表',
                'complete'=>Progress::getCompleted($year),
                'offices'=>Aiden::getAllModelArray('offices'),
                'year'=>$year,
                'month'=>$month,
                'target'=>$target,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
