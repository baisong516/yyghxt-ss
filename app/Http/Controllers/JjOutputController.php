<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\JjOutput;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            return view('jjoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'竞价产出',
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
            $date=$request->input('searchDate');
            $start=Carbon::createFromFormat('Y-m-d',$date)->startOfDay();
            $end=Carbon::createFromFormat('Y-m-d',$date)->endOfDay();
            $outputs=JjOutput::getJjOutputs($start,$end);
            return view('jjoutput.read',[
                'pageheader'=>'产出',
                'pagedescription'=>'竞价产出',
                'users'=>Aiden::getAllUserArray(),
                'start'=>$start,
                'end'=>$end,
                'outputs'=>$outputs,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
