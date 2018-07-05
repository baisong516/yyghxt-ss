<?php

namespace App\Http\Controllers;

use App\Arrangement;
use App\Department;
use App\Http\Requests\StoreArrangementRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    if (Auth::user()->ability('superadministrator', 'read-arrangements')){
		    return view('arrangement.read',[
			    'pageheader'=>'排班',
			    'pagedescription'=>'列表',
			    'arrangements'=>Arrangement::orderBy('id','desc')->limit(60)->get(),
			    'users'=>$this->getAllUserArray(),
			    'enableUpdate'=>Auth::user()->hasPermission('update-arrangements'),
			    'enableDelete'=>Auth::user()->hasPermission('delete-arrangements'),
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
	    if (Auth::user()->ability('superadministrator', 'create-arrangements')){
		    return view('arrangement.create',[
			    'pageheader'=>'排班',
			    'pagedescription'=>'添加',
			    'arrangeUsers'=>$this->getArrangeUsers(),
		    ]);
	    }
	    return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreArrangementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArrangementRequest $request)
    {
	    if (Auth::user()->ability('superadministrator', 'create-arrangements')){
		    if (empty(User::findOrFail($request->input('user_id'))->department)){//没有分配部门
			    return redirect()->back()->with('error','没有分配部门，不可排班！');
		    }
		    if (empty(User::findOrFail($request->input('user_id'))->offices)){//没有分配项目的用户
			    return redirect()->back()->with('error','没有分配项目，不可排班！');
		    }
		    //检查此人当天是否排班过
		    $todayArrangements=Arrangement::select('user_id')->where([
			    ['rank_date','>=',Carbon::now()->startOfDay()],
			    ['rank_date','<=',Carbon::now()->endOfDay()],
		    ])->get();
		    $todayUserList=[];
		    foreach ($todayArrangements as $todayArrangement){
			    $todayUserList[]=$todayArrangement->user_id;
		    }
		    if (in_array($request->input('user_id'),$todayUserList)&&$request->input('rank_date')>=Carbon::now()->startOfDay()->toDateString()&&$request->input('rank_date')<=Carbon::now()->endOfDay()->toDateString()){
			    return redirect()->back()->with('error',User::findOrFail($request->input('user_id'))->realname.'当天已经排班！');
		    }
		    $arrangemnet=new Arrangement();
		    $arrangemnet->user_id=$request->input('user_id');
		    $arrangemnet->rank=$request->input('rank');
		    $arrangemnet->rank_date=$request->input('rank_date');
		    $bool=$arrangemnet->save();
		    if ($bool){
			    return redirect()->route('arrangements.index')->with('success','Well Done！');
		    }else{
			    return redirect()->back()->with('error','Something Wrong！');
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
	    if (Auth::user()->ability('superadministrator', 'update-arrangements')){
		    return view('arrangement.update', [
			    'pageheader'=>'排班',
			    'pagedescription'=>'更新',
			    'arrangeUsers'=>$this->getArrangeUsers(),
			    'arrangement'=>Arrangement::findOrFail($id),
		    ]);
	    }
	    return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreArrangementRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArrangementRequest $request, $id)
    {
	    if (Auth::user()->ability('superadministrator', 'update-arrangements')){
		    $arrangemnet=Arrangement::findOrFail($id);
		    $arrangemnet->rank=$request->input('rank');
		    $arrangemnet->rank_date=$request->input('rank_date');
		    $bool=$arrangemnet->save();
		    if ($bool){
			    return redirect()->route('arrangements.index')->with('success','Well Done！');
		    }else{
			    return redirect()->back()->with('error','Something Wrong！');
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
	    if (Auth::user()->ability('superadministrator', 'delete-arrangements')){
		    $arrangemnet=Arrangement::findOrFail($id);
		    $bool=$arrangemnet->delete();
		    if ($bool){
			    return redirect()->route('arrangements.index')->with('success','Well Done！');
		    }else{
			    return redirect()->back()->with('error','Something Wrong！');
		    }
	    }
	    return abort(403,config('yyxt.permission_deny'));
    }

    public function import(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-arrangements')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
                $res=[];
                $dateTag=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag')):Carbon::now();

                Excel::load($file, function($reader) use( &$res,$dateTag ) {
                    $reader = $reader->getSheet(0);
                    $res = $reader->toArray();
                });
                $res=array_slice($res,1);
//                dd($res);
                $users = $this->getArrangeUserArray();
                $ranks = [
                    '0'=>'白班',
                    '1'=>'晚班',
                ];
                DB::beginTransaction();
                try{
                    $emptyData=0;
                    foreach ($res as $d){
                        if (is_null($d[0])||is_null($d[1])){
                            $emptyData++;
                            continue;
                        }
                        $user_id=array_search($d[0],$users);//
                        $rank=array_search($d[1],$ranks);//
                        if ($user_id===false||$rank===false){
                            DB::rollback();
                            return redirect()->route('arrangements.index')->with('error','请检查姓名和班次是否存在！');
                        }else{
                            if (empty(User::findOrFail($user_id)->department)){//没有分配部门
                                DB::rollback();
                                return redirect()->route('arrangements.index')->with('error',$d[0].' 没有分配部门，不可排班！');
                            }
                            if (empty(User::findOrFail($user_id)->offices)){//没有分配项目的用户
                                DB::rollback();
                                return redirect()->route('arrangements.index')->with('error',$d[0].' 没有分配项目，不可排班！');
                            }
                            //检查此人当天是否排班过
                            $todayArrangements=Arrangement::select('user_id')->where([
                                ['rank_date','>=',$dateTag->startOfDay()],
                                ['rank_date','<=',$dateTag->endOfDay()],
                            ])->get();
                            $todayUserList=[];
                            foreach ($todayArrangements as $todayArrangement){
                                $todayUserList[]=$todayArrangement->user_id;
                            }
                            if (in_array($user_id,$todayUserList)){
                                DB::rollback();
                                return redirect()->route('arrangements.index')->with('error',$d['0'].' 当天已经排班！');
                            }
                            $arrange=new Arrangement();
                            $arrange->user_id=$user_id;
                            $arrange->rank=$rank;
                            $arrange->rank_date=$dateTag;
                            $arrange->save();
                        }
                    }
                    DB::commit();
                }catch (QueryException $e){
                    DB::rollback();
                    return redirect()->route('arrangements.index')->with('error',$e->getMessage().' 请检查格式！');
                }
                return redirect()->route('arrangements.index')->with('success','导入完成! 空数据行'.$emptyData.'行');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    //获取用于排班的人
	private function getArrangeUsers() {
		$users=null;
		foreach (Department::whereIn('id',[1,2])->get() as $department){
			$users[$department->id]['department']=$department->display_name;
			foreach (User::select('id','realname','department_id')->where('is_active',1)->with('offices')->get() as $user){
				if ($user->department_id&&$user->department_id==$department->id){
					$users[$department->id]['users'][]=$user;
				}
			}
		}
		return $users;
	}
	private function getAllUserArray()
	{
		$obj=User::select('id','realname')->get();
		$users=[];
		foreach ($obj as $user){
			$users[$user->id]=$user->realname;
		}
		return $users;
	}

    private function getArrangeUserArray()
    {
        $obj=User::select('id','realname')->whereIn('department_id',[1,2])->where('is_active',1)->get();
        $users=[];
        foreach ($obj as $user){
            $users[$user->id]=$user->realname;
        }
        return $users;
    }
}
