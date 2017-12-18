<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Requests\StoreAreaRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-areas')){
            return view('area.read',[
                'pageheader'=>'地域',
                'pagedescription'=>'列表',
                'areas'=>Area::all(),
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-areas'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-areas'),
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
        if (Auth::user()->ability('superadministrator', 'create-areas')){
            return view('area.create',[
                'pageheader'=>'地域',
                'pagedescription'=>'新增',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAreaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAreaRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-areas')){
            if (Area::createArea($request)){
                return redirect()->route('areas.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-areas')){
            return view('area.update',[
                'pageheader'=>'地域',
                'pagedescription'=>'更新',
                'area'=>Area::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreAreaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAreaRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-areas')){
            if (Area::updateArea($request,$id)){
                return redirect()->route('areas.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-areas')){
            $area=Area::findOrFail($id);
            if ($area->delete()){
                return redirect()->route('areas.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
