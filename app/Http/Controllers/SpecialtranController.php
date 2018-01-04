<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Special;
use App\Specialtran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SpecialtranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-specialtrans')){
            $start=Carbon::now()->startOfDay();
            $end=Carbon::now()->endOfDay();
            return view('specialtran.read',[
                'pageheader'=>'专题统计',
                'pagedescription'=>'列表',
                'specialtrans'=>Specialtran::getSpecialtransList($start,$end),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
//                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-specialtrans'),
//                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-specialtrans'),
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
        if (Auth::user()->ability('superadministrator', 'create-specialtrans')){
            return view('specialtran.create',[
                'pageheader'=>'专题数据统计',
                'pagedescription'=>'添加',
                'specials'=>Special::getSpecialsList(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
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
        if (Auth::user()->ability('superadministrator', 'create-specialtrans')){
            if (Specialtran::createSpecialtran($request)){
                return redirect()->route('specialtrans.index')->with('success','Well Done');
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
        if (Auth::user()->ability('superadministrator', 'read-specialtrans')){
            $start=$request->input('dateStart')?Carbon::createFromFormat('Y-m-d',$request->input('dateStart'))->startOfDay():Carbon::now()->startOfDay();
            $end=$request->input('dateEnd')?Carbon::createFromFormat('Y-m-d',$request->input('dateEnd'))->endOfDay():Carbon::now()->endOfDay();
            return view('specialtran.read',[
                'pageheader'=>'专题统计',
                'pagedescription'=>'查询',
                'specialtrans'=>Specialtran::getSpecialtransList($start,$end),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'start'=>$start,
                'end'=>$end,
//                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-specialtrans'),
//                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-specialtrans'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function import(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-specialtrans')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
                $res=[];
                $dateTag=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag')):Carbon::now();
                $start=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->startOfDay():Carbon::now()->startOfDay();
                $end=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->endOfDay():Carbon::now()->endOfDay();
                $isExist=Specialtran::where([
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
                $specials=Aiden::getSpecialsArray();
                foreach ($res as $d){
                    $special_id=array_search($d[1],$specials);//专题
                    if ($special_id){
                        $cost=$d[2]?$d[2]:0;//消费
                        $click=$d[3]?$d[3]:0;//点击
                        $show=$d[4]?$d[4]:0;//展现
                        $view=$d[5]?$d[5]:0;//唯一身份浏览量
                        $swt_lg_one=$d[6]?$d[6]:0;//商务通大于等于1
                        $swt_lg_three=$d[7]?$d[7]:0;//商务通大于等于3
                        $yuyue=$d[8]?$d[8]:0;//预约
                        $arrive=$d[9]?$d[9]:0;//到院

                        $date_tag=$dateTag;//日期
                        //calc 跳出率=(点击-唯一身份浏览量)/点击    点击转化率=商务通大于等于1/点击
                        $skip_rate = $click>0?sprintf('%.2f',($click-$view)*100.00/$click).'%':'-';
                        $click_trans_rate = $click>0?sprintf('%.2f',$swt_lg_one*100/$click).'%':'-';

                        $specialtran=new Specialtran();
                        $specialtran->special_id=$special_id;
                        $specialtran->cost=$cost;
                        $specialtran->click=$click;
                        $specialtran->show=$show;
                        $specialtran->view=$view;
                        $specialtran->swt_lg_one=$swt_lg_one;
                        $specialtran->swt_lg_three=$swt_lg_three;
                        $specialtran->yuyue=$yuyue;
                        $specialtran->arrive=$arrive;
                        $specialtran->skip_rate=$skip_rate;
                        $specialtran->click_trans_rate=$click_trans_rate;
                        $specialtran->date_tag=$date_tag;

                        $bool=$specialtran->save();
                    }
                }
                return redirect()->route('specialtrans.index')->with('success','导入完成!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
