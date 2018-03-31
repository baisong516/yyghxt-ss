<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Http\Requests\StorePersonTargetRequest;
use App\PersonTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     if (Auth::user()->ability('superadministrator', 'create-targets')){
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
        if (Auth::user()->ability('superadministrator', 'update-targets')){
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
        if (Auth::user()->ability('superadministrator', 'update-targets')){
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
        if (Auth::user()->ability('superadministrator', 'delete-targets')){
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
        
    }
}
