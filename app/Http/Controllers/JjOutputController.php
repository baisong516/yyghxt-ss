<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\JjOutput;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class JjOutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-jjoutputs')){
            $start=Carbon::now()->startOfDay();
            $end=Carbon::now()->endOfDay();
            $outputs=JjOutput::getJjOutputs($start,$end);
            $lastMonthOutputs = JjOutput::getJjOutputs(Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth());
            //$monthOutputs = JjOutput::getJjOutputs(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth());
            //$lastYearOutputs=JjOutput::getJjOutputs(Carbon::now()->subYear()->startOfYear(),Carbon::now()->subYear()->endOfYear());
            $yearOutputs=JjOutput::getJjOutputs(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
            return view('jjoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'竞价产出',
                'users'=>Aiden::getAllUserArray(),
                'outputs'=>$outputs,
                'lastMonthOutputs'=>$lastMonthOutputs,
                //'lastYearOutputs'=>$lastYearOutputs,
                'yearOutputs'=>$yearOutputs,
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
        if (Auth::user()->ability('superadministrator', 'create-jjoutputs')){
            return view('jjoutput.create',[
                'pageheader'=>'产出',
                'pagedescription'=>'竞价产出录入',
                'jjusers'=>Aiden::getAllJjUserArray(),
                'offices'=>Aiden::getAuthdOffices(),
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
        if (Auth::user()->ability('superadministrator', 'create-jjoutputs')){
            if (JjOutput::createJjOutput($request)){
                return redirect()->route('jjoutputs.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong');
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
        if (Auth::user()->ability('superadministrator', 'read-jjoutputs')){
            $start=Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay();
            $end=Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay();
            $outputs=JjOutput::getJjOutputs($start,$end);
            $lastMonthOutputs = JjOutput::getJjOutputs(Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth());
            //$monthOutputs = JjOutput::getJjOutputs(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth());
            //$lastYearOutputs=JjOutput::getJjOutputs(Carbon::now()->subYear()->startOfYear(),Carbon::now()->subYear()->endOfYear());
            $yearOutputs=JjOutput::getJjOutputs(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
            return view('jjoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'竞价产出',
                'users'=>Aiden::getAllUserArray(),
                'start'=>$start,
                'end'=>$end,
                'outputs'=>$outputs,
                'lastMonthOutputs'=>$lastMonthOutputs,
                //'lastYearOutputs'=>$lastYearOutputs,
                'yearOutputs'=>$yearOutputs,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function import(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-jjoutputs')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
                $res=[];
                $dateTag=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag')):Carbon::now();
                $start=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->startOfDay():Carbon::now()->startOfDay();
                $end=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->endOfDay():Carbon::now()->endOfDay();
                $isExist=JjOutput::where([
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
                $offices=Aiden::getAllModelArray('offices');
                $users=Aiden::getAllUserArray();
                foreach ($res as $d){
                    $office_id=array_search($d[0],$offices);//项目
                    $user_id=array_search($d[1],$users);//竞价员
                    $rank=$d[2]&&$d[2]=='早班'?0:1;//班次
                    $budget=$d[3]?$d[3]:0;//预算
                    $cost=$d[4]?$d[4]:0;//消费
                    $click=$d[5]?$d[5]:0;//点击
                    $zixun=$d[6]?$d[6]:0;//咨询量
                    $yuyue=$d[7]?$d[7]:0;//预约量
                    $arrive=$d[8]?$d[8]:0;//到院量


                    $date_tag=$dateTag;//日期

                    $zixun_cost=$zixun>0?sprintf('%.2f',$cost/$zixun):$cost;
                    $yuyue_cost=$yuyue>0?sprintf('%.2f',$cost/$yuyue):$cost;
                    $arrive_cost=$arrive>0?sprintf('%.2f',$cost/$arrive):$cost;

                    $jjoutput=new JjOutput();
                    $jjoutput->user_id=$user_id;
                    $jjoutput->office_id=$office_id;
                    $jjoutput->rank=$rank;
                    $jjoutput->budget=$budget;
                    $jjoutput->cost=$cost;
                    $jjoutput->click=$click;
                    $jjoutput->zixun=$zixun;
                    $jjoutput->yuyue=$yuyue;
                    $jjoutput->arrive=$arrive;
                    $jjoutput->zixun_cost=$zixun_cost;
                    $jjoutput->yuyue_cost=$yuyue_cost;
                    $jjoutput->arrive_cost=$arrive_cost;
                    $jjoutput->date_tag=$date_tag;

                    $bool=$jjoutput->save();
                }
                return redirect()->route('jjoutputs.index')->with('success','导入完成!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
