<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Target;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-targets')){
            $year=Carbon::now()->year;
//            dd(Target::getTargetData($year));
            return view('target.read',[
                'pageheader'=>'年度计划',
                'pagedescription'=>'报表',
                'targetdata'=>Target::getTargetData($year),
                'offices'=>Aiden::getAllModelArray('offices'),
                'year'=>$year,
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

    }

    public function list()
    {

    }

    public function import(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-targets')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
//                $res=[];
//                Excel::load($file, function($reader) use( &$res ) {
//                    $reader = $reader->getSheet(0);
//                    $res = $reader->toArray();
//                });
//                $res=array_slice($res,2);
                $ress=[];
                Excel::load($file, function($reader) use( &$ress ) {
                    $sheets = $reader->get();
                    foreach ($sheets as $key=>$sheet){
                        $ress[$key]=[
                            'title'=>$sheet->getTitle(),
                            'data'=>$reader->getSheet($key)->toArray(),
                        ];
                    }
                });
                $offices=Aiden::getAllModelArray('offices');
                $datacount=0;
                $tips='';
                foreach ($ress as $res){
                    $title=$res['title'];
                    if (!isset($res['data'][2][0])){continue;}
                    $year=intval($res['data'][2][0]);
                    $res=array_slice($res['data'],3, 12);
                    DB::beginTransaction();
                    try{
                        foreach ($res as $d){
                            if (is_null($d[0])||is_null($d[1])||is_null($d[2])||is_null($d[3])||is_null($d[4])||is_null($d[5])||is_null($d[6])||is_null($d[7])){
                                continue;
                            }
                            $office_id=array_search($title,$offices);
                            if ($office_id<1){continue;}
                            $month=intval($d[0]);
                            $cost=(float)($d[1]);
                            $arrive=intval($d[2]);
                            $show=intval($d[3]);
                            $click=intval($d[4]);
                            $achat=intval($d[5]);
                            $chat=intval($d[6]);
                            $yuyue=intval($d[7]);
                            $et=Target::where('office_id',$office_id)->where('month',$month)->count();
                            if ($et>0){
                                $tips.=' '.$title.$year.'年'.$month.'月'.'数据已存在';
                                continue;
                            }
                            $target=new Target();
                            $target->office_id=$office_id;
                            $target->year=$year;
                            $target->month=$month;
                            $target->cost=$cost;
                            $target->arrive=$arrive;
                            $target->show=$show;
                            $target->click=$click;
                            $target->achat=$achat;
                            $target->chat=$chat;
                            $target->yuyue=$yuyue;
                            $target->save();
                            $datacount++;
                        }
                        DB::commit();
                    }catch (QueryException $e){
                        DB::rollback();
                        return redirect()->route('targets.index')->with('error',$e->getMessage().' 请检查表格数据是否正确再次导入！');
                    }
                }

                return redirect()->route('targets.index')->with('success','导入完成!共导入数据 '.$datacount.'条！'.$tips);
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
