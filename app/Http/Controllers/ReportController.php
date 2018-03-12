<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Auction;
use App\Report;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-reports')){
            $start=Carbon::now()->startOfDay();
            $end=Carbon::now()->endOfDay();
//            dd(Report::getReportData($start,$end));
//            dd(Auction::getAuctionData(Carbon::createFromFormat('Y-m-d','2018-01-01')->startOfDay(),$end));
            return view('report.read',[
                'pageheader'=>'竞价部',
                'pagedescription'=>'报表',
                'reports'=>Report::getReportData($start,$end),
                'offices'=>Aiden::getAllModelArray('offices'),
                'platforms'=>Aiden::getAllModelArray('platforms'),
                'areas'=>Aiden::getAllModelArray('areas'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'start'=>$start,
                'end'=>$end,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        if (Auth::user()->ability('superadministrator', 'read-reports')){
            return view('report.list',[
                'pageheader'=>'竞价部',
                'pagedescription'=>'报表列表',
                'reports'=>Report::orderBy('date_tag','desc')->take(100)->get(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'platforms'=>Aiden::getAllModelArray('platforms'),
                'areas'=>Aiden::getAllModelArray('areas'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
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
        if (Auth::user()->ability('superadministrator', 'create-reports')){
            return view('report.create',[
                'pageheader'=>'竞价报表',
                'pagedescription'=>'录入',
                'offices'=>Aiden::getAllModelArray('offices'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-reports')){
            if (Report::createReport($request)){
                return redirect()->route('reports.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
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
        if (Auth::user()->ability('superadministrator', 'update-diseases')){
            return view('report.update',[
                'pageheader'=>'报表',
                'pagedescription'=>'更新',
                'offices'=>Aiden::getAllModelArray('offices'),
                'options'=>Aiden::getAllModelArray(Report::findOrFail($id)->type.'s'),
                'report'=>Report::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
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
        if (Auth::user()->ability('superadministrator', 'update-reports')){
            if (Report::updateReport($request,$id)){
                return redirect()->route('reports.list')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->ability('superadministrator', 'delete-diseases')){
            $report=Report::findOrFail($id);
            $bool=$report->delete();
            if ($bool){
                return redirect()->route('reports.list')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
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
                'platforms'=>Aiden::getAllModelArray('platforms'),
                'areas'=>Aiden::getAllModelArray('areas'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
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
                    return redirect()->back()->with('error',$request->input('date_tag').'的数据已录过一次，为避免数据混乱，不能二次录入！');
                }
                Excel::load($file, function($reader) use( &$res,$dateTag ) {
                    $reader = $reader->getSheet(0);
                    $res = $reader->toArray();
                });
                $res=array_slice($res,1);
//                dd($res);
                $offices=Aiden::getAllModelArray('offices');
                $types=[
                    'platform'=>'渠道',
                    'area'=>'地区',
                    'disease'=>'病种',
                ];
                $platforms=Aiden::getAllModelArray('platforms');
                $areas=Aiden::getAllModelArray('areas');
                $diseases=Aiden::getAllModelArray('diseases');
                DB::beginTransaction();
                try{
                    foreach ($res as $d){
                        $office_id=array_search($d[0],$offices);//项目
                        $type=array_search($d[1],$types);//类型
                        $type_id=$d[2];
                        if ($type=='platform'){
                            $type_id=array_search($d[2],$platforms);
                        }
                        if ($type=='area'){
                            $type_id=array_search($d[2],$areas);
                        }
                        if ($type=='disease'){
                            $type_id=array_search($d[2],$diseases);
                        }
                        $show=$d[3]?$d[3]:0;//展现
                        $click=$d[4]?$d[4]:0;//点击
                        $cost=$d[5]?$d[5]:0;//消费
                        $achat=$d[6]?$d[6]:0;//总对话
                        $chat=$d[7]?$d[7]:0;//有效对话
                        $contact=$d[8]?$d[8]:0;//留联系
                        $yuyue=$d[9]?$d[9]:0;//预约
                        $arrive=$d[10]?$d[10]:0;//到院
                        $date_tag=$dateTag;//日期


                        $report=new Report();
                        $report->office_id=$office_id;
                        $report->type=$type;
                        $report->type_id=$type_id;
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
                    DB::commit();
                }catch (QueryException $e){
                    DB::rollback();
                    return redirect()->route('reports.index')->with('error',$e->getMessage().' 请检查表格数据是否正确再次导入或截图联系管理员！');
                }
                return redirect()->route('reports.index')->with('success','导入完成!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
