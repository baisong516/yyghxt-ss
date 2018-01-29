<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Office;
use App\ZxOutput;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ZxOutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-zxoutputs')){
            $start=Carbon::now()->startOfDay();
            $end=Carbon::now()->endOfDay();
            $outputs=ZxOutput::getZxOutputs($start,$end);
            $lastMonthOutputs = ZxOutput::getZxOutputs(Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth());
            //$monthOutputs = JjOutput::getJjOutputs(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth());
            //$lastYearOutputs=JjOutput::getJjOutputs(Carbon::now()->subYear()->startOfYear(),Carbon::now()->subYear()->endOfYear());
            $yearOutputs=ZxOutput::getZxOutputs(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
//            dd($outputs);
            return view('zxoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出',
                'users'=>Aiden::getAllUserArray(),
                'outputs'=>$outputs,
                'start'=>$start,
                'end'=>$end,
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
    public function create(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-zxoutputs')){
            return view('zxoutput.create',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出录入',
                'zxusers'=>Aiden::getAllZxUserArray(),
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
        if (Auth::user()->ability('superadministrator', 'create-zxoutputs')){
            if (ZxOutput::createZxOutput($request)){
                return redirect()->route('zxoutputs.index')->with('success','Well Done!');
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
        dd($id);
    }

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-zxoutputs')){
            $start=empty($request->input('searchDateStart'))?Carbon::now()->startOfDay():Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay();
            $end=empty($request->input('searchDateEnd'))?Carbon::now()->endOfDay():Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay();
            $outputs=ZxOutput::getZxOutputs($start,$end);
            $lastMonthOutputs = ZxOutput::getZxOutputs(Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth());
            //$monthOutputs = JjOutput::getJjOutputs(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth());
            //$lastYearOutputs=JjOutput::getJjOutputs(Carbon::now()->subYear()->startOfYear(),Carbon::now()->subYear()->endOfYear());
            $yearOutputs=ZxOutput::getZxOutputs(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
            return view('zxoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出搜索',
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
        if (Auth::user()->ability('superadministrator', 'create-zxoutputs')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
                $res=[];
                $dateTag=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag')):Carbon::now();
                $start=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->startOfDay():Carbon::now()->startOfDay();
                $end=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->endOfDay():Carbon::now()->endOfDay();
                $isExist=ZxOutput::where([
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
                $res=array_slice($res,2);
                $offices=Aiden::getAllModelArray('offices');
                $users=Aiden::getAllUserArray();
                foreach ($res as $d){
                    $office_id=array_search($d[0],$offices);//项目
                    $user_id=array_search($d[1],$users);//咨询员
                    $swt_zixun_count=$d[2]?$d[2]:0;//商务通咨询量
                    $swt_yuyue_count=$d[3]?$d[3]:0;//商务通预约量
                    $swt_contact_count=$d[4]?$d[4]:0;//商务通留联系
                    $swt_arrive_count=$d[5]?$d[5]:0;//商务通到院量
                    $tel_zixun_count=$d[6]?$d[6]:0;//电话咨询量
                    $tel_yuyue_count=$d[7]?$d[7]:0;//电话预约量
                    $tel_arrive_count=$d[8]?$d[8]:0;//电话到院量
                    $hf_zixun_count=$d[9]?$d[9]:0;//回访咨询量
                    $hf_yuyue_count=$d[10]?$d[10]:0;//回访预约量
                    $hf_arrive_count=$d[11]?$d[11]:0;//回访到院量

                    $total_zixun_count=$swt_zixun_count+$tel_zixun_count;
                    $total_yuyue_count=$swt_yuyue_count+$tel_yuyue_count;
                    $total_arrive_count=$swt_arrive_count+$tel_arrive_count+$hf_arrive_count;

                    $total_jiuzhen_count=$d[12]?$d[12]:0;//就诊量

                    $yuyue_rate=$total_zixun_count>0?sprintf('%.2f',$total_yuyue_count*100.00/$total_zixun_count).'%':'0.00%';
                    $arrive_rate=$total_yuyue_count>0?sprintf('%.2f',$total_arrive_count*100.00/$total_yuyue_count).'%':'0.00%';
                    $jiuzhen_rate=$total_arrive_count>0?sprintf('%.2f',$total_jiuzhen_count*100.00/$total_arrive_count).'%':'0.00%';
                    $trans_rate=$total_zixun_count>0?sprintf('%.2f',$total_arrive_count*100.00/$total_zixun_count).'%':'0.00%';

                    $date_tag=$dateTag;//日期


                    $zxoutput=new ZxOutput();
                    $zxoutput->user_id=$user_id;
                    $zxoutput->office_id=$office_id;
                    $zxoutput->swt_zixun_count=$swt_zixun_count;
                    $zxoutput->swt_yuyue_count=$swt_yuyue_count;
                    $zxoutput->swt_contact_count=$swt_contact_count;
                    $zxoutput->swt_arrive_count=$swt_arrive_count;
                    $zxoutput->tel_zixun_count=$tel_zixun_count;
                    $zxoutput->tel_yuyue_count=$tel_yuyue_count;
                    $zxoutput->tel_arrive_count=$tel_arrive_count;
                    $zxoutput->hf_zixun_count=$hf_zixun_count;
                    $zxoutput->hf_yuyue_count=$hf_yuyue_count;
                    $zxoutput->hf_arrive_count=$hf_arrive_count;
                    $zxoutput->total_zixun_count=$total_zixun_count;
                    $zxoutput->total_yuyue_count=$total_yuyue_count;
                    $zxoutput->total_arrive_count=$total_arrive_count;
                    $zxoutput->total_jiuzhen_count=$total_jiuzhen_count;
                    $zxoutput->yuyue_rate=$yuyue_rate;
                    $zxoutput->arrive_rate=$arrive_rate;
                    $zxoutput->jiuzhen_rate=$jiuzhen_rate;
                    $zxoutput->trans_rate=$trans_rate;
                    $zxoutput->date_tag=$date_tag;
                    $bool=$zxoutput->save();
                }
                return redirect()->route('zxoutputs.index')->with('success','导入完成!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
