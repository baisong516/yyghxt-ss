<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Http\Requests\StorePersonTargetRequest;
use App\PersonTarget;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PersonTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-persontargets')){
            $year=Carbon::now()->year;
//            dd(PersonTarget::getTargetData($year));
            return view('persontarget.read',[
                'pageheader'=>'个人计划',
                'pagedescription'=>'报表',
                'targetdata'=>PersonTarget::getTargetData($year),
                'offices'=>Aiden::getAllModelArray('offices'),
                'users'=>Aiden::getAllUserArray(),
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
//        dd(Aiden::getAllZxUserArray());
        if (Auth::user()->ability('superadministrator', 'create-persontargets')){
            return view('persontarget.create',[
                'pageheader'=>'个人计划',
                'pagedescription'=>'录入',
                'users'=>Aiden::getAllZxUserArray(),
                'offices'=>Aiden::getAllModelArray('offices'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePersonTargetRequest  $request
     * @return \Illuminate\http\Response
     */
    public function store(StorePersonTargetRequest $request)
    {
     if (Auth::user()->ability('superadministrator', 'create-persontargets')){
            $count=PersonTarget::where([
                ['office_id',$request->input('office_id')],
                ['year',$request->input('year')],
                ['month',$request->input('month')],
                ['user_id',$request->input('user_id')],
            ])->count();
            if ($count>0){
                return redirect()->back()->with('error','Something Wrong!数据重复');
            }
            if (PersonTarget::createTarget($request)){
                return redirect()->route('persontargets.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!检查是否数据错误或重复录入');
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
        if (Auth::user()->ability('superadministrator', 'update-persontargets')){
            return view('persontarget.update',[
                'pageheader'=>'经营计划',
                'pagedescription'=>'更新',
                'offices'=>Aiden::getAllModelArray('offices'),
                'target'=>PersonTarget::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StorePersonTargetRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePersonTargetRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-persontargets')){
            if (PersonTarget::updatetarget($request,$id)){
                return redirect()->route('persontargets.list')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-persontargets')){
            $target=PersonTarget::findOrFail($id);
            $bool=$target->delete();
            if ($bool){
                return redirect()->route('persontargets.list')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function list()
    {
        if (Auth::user()->ability('superadministrator', 'read-persontargets')){
            return view('persontarget.list',[
                'pageheader'=>'个人计划',
                'pagedescription'=>'列表',
                'targets'=>PersonTarget::orderBy('year','desc')->take(100)->get(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'users'=>Aiden::getAllUserArray(),
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-persontargets'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-persontargets'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    //全年导入
    public function imports(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-persontargets')){
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
                $users=Aiden::getAllUserArray();
                $datacount=0;
                $tips='';
                foreach ($ress as $res){
                    $title=$res['title'];
                    $year=intval($res['data'][0][0]);
                    $res=array_slice($res['data'],2);
                    DB::beginTransaction();
                    try{
                        $user='';
                        foreach ($res as $d){
                            if (is_null($d[1])||is_null($d[2])||is_null($d[3])||is_null($d[4])|is_null($d[5])){
                                continue;
                            }
                            $user=empty($d[0])?$user:$d[0];
                            $office_id=array_search($title,$offices);
                            $user_id=array_search($user,$users);
                            if ($office_id<1){continue;}
                            if ($user_id<1){continue;}
                            $month=intval($d[1]);
                            $chat=intval($d[2]);
                            $contact=intval($d[3]);
                            $yuyue=intval($d[4]);
                            $arrive=intval($d[5]);
                            $et=PersonTarget::where('office_id',$office_id)->where('month',$month)->where('user_id',$user_id)->count();
                            if ($et>0){
                                $tips.=' '.$title.$year.'年'.$month.'月'.$user.'数据已存在';
                                continue;
                            }
                            $target=new PersonTarget();
                            $target->office_id=$office_id;
                            $target->user_id=$user_id;
                            $target->year=$year;
                            $target->month=$month;
                            $target->arrive=$arrive;
                            $target->chat=$chat;
                            $target->contact=$contact;
                            $target->yuyue=$yuyue;
                            $target->save();
                            $datacount++;
                        }
                        DB::commit();
                    }catch (QueryException $e){
                        DB::rollback();
                        return redirect()->route('persontargets.index')->with('error',$e->getMessage().' 请检查表格数据是否正确再次导入！');
                    }
                }

                return redirect()->route('persontargets.index')->with('success','导入完成!共导入数据 '.$datacount.'条！'.$tips);
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
    //按月导入
    public function import(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-persontargets')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
                $res=[];
                Excel::load($file, function($reader) use( &$res ) {
                    $reader = $reader->getSheet(0);
                    $res = $reader->toArray();
                });
                $year=intval($res[0][0]);
                $res=array_slice($res,2);
//                dd($res);
                $offices=Aiden::getAllModelArray('offices');
                $users=Aiden::getAllUserArray();
                $datacount=0;
                $tips='';
                DB::beginTransaction();
                try{
                    $user='';
                    $office='';
                    foreach ($res as $d){
                        if (is_null($d[1])||is_null($d[2])||is_null($d[3])||is_null($d[4])||is_null($d[5])||is_null($d[6])){
                            continue;
                        }
                        $office=empty($d[0])?$office:$d[0];
                        $office_id=array_search($office,$offices);
                        $user=empty($d[1])?$user:$d[1];
                        $user_id=array_search($user,$users);
                        if ($office_id<1){continue;}
                        if ($user_id<1){continue;}
                        $month=intval($d[2]);
                        $chat=intval($d[3]);
                        $contact=intval($d[4]);
                        $yuyue=intval($d[5]);
                        $arrive=intval($d[6]);
                        $et=PersonTarget::where('office_id',$office_id)->where('month',$month)->where('user_id',$user_id)->count();
                        if ($et>0){
                            $tips.=' '.$office.$year.'年'.$month.'月'.$user.'数据已存在';
                            continue;
                        }
                        $target=new PersonTarget();
                        $target->office_id=$office_id;
                        $target->user_id=$user_id;
                        $target->year=$year;
                        $target->month=$month;
                        $target->arrive=$arrive;
                        $target->chat=$chat;
                        $target->contact=$contact;
                        $target->yuyue=$yuyue;
                        $target->save();
                        $datacount++;
                    }
                    DB::commit();
                }catch (QueryException $e){
                    DB::rollback();
                    return redirect()->route('persontargets.index')->with('error',$e->getMessage().' 请检查表格数据是否正确再次导入！');
                }

                return redirect()->route('persontargets.index')->with('success','导入完成!共导入数据 '.$datacount.'条！'.$tips);
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
