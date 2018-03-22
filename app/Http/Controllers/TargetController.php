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
//            dd(Report::getReportData($start,$end));
            return view('target.read',[
                'pageheader'=>'年度计划',
                'pagedescription'=>'报表',
                'reportdata'=>Target::getReportData($year),
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
                $res=[];
                Excel::load($file, function($reader) use( &$res ) {
                    $reader = $reader->getSheet(0);
                    $res = $reader->toArray();
                });
                $res=array_slice($res,1);
                dd($res);
                $offices=Aiden::getAllModelArray('offices');
                DB::beginTransaction();
                try{
                    $emptyData=0;
                    foreach ($res as $d){
                        if (is_null($d[0])||is_null($d[1])||is_null($d[2])||is_null($d[3])||is_null($d[4])||is_null($d[5])||is_null($d[6])||is_null($d[7])||is_null($d[8])||is_null($d[9])||is_null($d[10])||is_null($d[11])){
                            $emptyData++;
                            continue;
                        }
                    }
                    DB::commit();
                }catch (QueryException $e){
                    DB::rollback();
                    return redirect()->route('reports.index')->with('error',$e->getMessage().' 请检查表格数据是否正确再次导入或截图联系管理员！');
                }
                return redirect()->route('reports.index')->with('success','导入完成! 空数据行'.$emptyData.'行');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
