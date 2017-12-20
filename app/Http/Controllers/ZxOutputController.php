<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\ZxOutput;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            return view('zxoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出',
                'users'=>Aiden::getAllUserArray(),
                'outputs'=>$outputs,
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
            return view('zxoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'咨询产出搜索',
                'users'=>Aiden::getAllUserArray(),
                'start'=>$start,
                'end'=>$end,
                'outputs'=>$outputs,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
