<?php

namespace App\Http\Controllers;

use App\Cause;
use App\Http\Requests\StoreCauseRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-causes')){
            return view('cause.read',[
                'pageheader'=>'未预约原因',
                'pagedescription'=>'列表',
                'causes'=>Cause::all(),
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-causes'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-causes'),
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
        if (Auth::user()->ability('superadministrator', 'create-causes')){
            return view('cause.create',[
                'pageheader'=>'未预约原因',
                'pagedescription'=>'新增',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCauseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCauseRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-causes')){
            if (Cause::createCause($request)){
                return redirect()->route('causes.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-causes')){
            return view('cause.update',[
                'pageheader'=>'未预约原因',
                'pagedescription'=>'更新',
                'cause'=>Cause::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreCauseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCauseRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-areas')){
            if (Cause::updateCause($request,$id)){
                return redirect()->route('causes.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
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
        if (Auth::user()->ability('superadministrator', 'delete-causes')){
            $cause=Cause::findOrFail($id);
            if ($cause->delete()){
                return redirect()->route('causes.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
