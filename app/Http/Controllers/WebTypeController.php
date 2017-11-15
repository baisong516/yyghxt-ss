<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebTypeRequest;
use App\WebType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WebTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-web_types')){
            return view('webtype.read',[
                'pageheader'=>'网站类型',
                'pagedescription'=>'列表',
                'webtypes'=>WebType::select('id','name','display_name')->get(),
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
        if (Auth::user()->ability('superadministrator', 'create-web_types')){
            return view('webtype.create',[
                'pageheader'=>'网站类型',
                'pagedescription'=>'添加',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreWebTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWebTypeRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-web_types')){
            $webtype=new WebType();
            $webtype->name=$request->input('name');
            $webtype->display_name=$request->input('display_name');
            $webtype->description=$request->input('description');
            $bool=$webtype->save();
            if ($bool){
                return redirect()->route('webtypes.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!!!');
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
        if (Auth::user()->ability('superadministrator', 'update-web_types')){
            return view('webtype.update',[
                'pageheader'=>'网站类型',
                'pagedescription'=>'更新',
                'webtype'=>WebType::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreWebTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreWebTypeRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-web_types')){
            $webtype=WebType::findOrFail($id);
            $webtype->display_name=$request->input('display_name');
            $webtype->description=$request->input('description');
            $bool=$webtype->save();
            if ($bool){
                return redirect()->route('webtypes.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!!!');
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
        if (Auth::user()->ability('superadministrator', 'delete-web_types')){
            $webtype=WebType::findOrFail($id);
            $bool=$webtype->delete();
            if ($bool){
                return redirect()->route('webtypes.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
