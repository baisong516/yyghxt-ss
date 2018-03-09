<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-reports')){
            $start=Carbon::now()->startOfDay();
            $end=Carbon::now()->endOfDay();
            return view('report.read',[
                'pageheader'=>'竞价部',
                'pagedescription'=>'报表',
                'reports'=>Report::getReportData($start,$end),
                'offices'=>Aiden::getAllModelArray('offices'),
                'start'=>$start,
                'end'=>$end,
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-reports'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-reports'),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-reports')){
            $monthSub=$request->input('monthSub');
            if ($monthSub==null){
                $start=$request->input('searchDateStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay():Carbon::now()->startOfDay();
                $end=$request->input('searchDateEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay():Carbon::now()->endOfDay();
            }else{
                $start=Carbon::now()->subMonth($monthSub)->startOfMonth();
                $end=Carbon::now()->subMonth($monthSub)->endOfMonth();
            }
//            $data=Auction::getAuctionData($start,$end);
//            dd($data);
            return view('report.read',[
                'pageheader'=>'竞价部',
                'pagedescription'=>'报表',
                'reports'=>Report::getReportData($start,$end),
                'offices'=>Aiden::getAllModelArray('offices'),
                'start'=>$start,
                'end'=>$end,
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-reports'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-reports'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function import(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-reports')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
                $res=[];
                $dateTag=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag')):Carbon::now();
                $start=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->startOfDay():Carbon::now()->startOfDay();
                $end=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->endOfDay():Carbon::now()->endOfDay();
                $isExist=Report::where([
                    ['date_tag','>=',$start],
                    ['date_tag','<=',$end],
                ])->count();
                if ($isExist>0){
                    return redirect()->back()->with('error',$request->input('date_tag').'的数据已录过一次，为避免数据混乱，禁止二次录入！');
                }
                Excel::load($file, function($reader) use( &$res,$dateTag ) {
                    $reader = $reader->getSheet(0);
                    $res = $reader->toArray();
                });
                $res=array_slice($res,1);
//                dd($res);
                $offices=Aiden::getAllModelArray('offices');
                foreach ($res as $d){
                    $office_id=array_search($d[0],$offices);//项目
                    $cost=$d[1]?$d[1]:0;//预算
                    $show=$d[2]?$d[2]:0;//展现
                    $click=$d[3]?$d[3]:0;//点击
                    $achat=$d[4]?$d[4]:0;//总对话
                    $chat=$d[5]?$d[5]:0;//有效对话
                    $contact=$d[6]?$d[6]:0;//留联系
                    $yuyue=$d[7]?$d[7]:0;//预约
                    $arrive=$d[8]?$d[8]:0;//到院

                    $date_tag=$dateTag;//日期


                    $report=new Report();
                    $report->office_id=$office_id;
                    $report->cost=$cost;
                    $report->show=$show;
                    $report->click=$click;
                    $report->achat=$achat;
                    $report->chat=$chat;
                    $report->contact=$contact;
                    $report->yuyue=$yuyue;
                    $report->arrive=$arrive;
                    $report->date_tag=$date_tag;
                    $bool=$report->save();
                }
                return redirect()->route('reports.index')->with('success','导入完成!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
