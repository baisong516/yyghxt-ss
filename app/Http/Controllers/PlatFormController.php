<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlatFormRequest;
use App\PlatForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlatFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-platforms')){

            return view('platform.read',[
                'pageheader'=>'平台渠道',
                'pagedescription'=>'列表',
                'platforms'=>PlatForm::all(),
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-platforms'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-platforms'),
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
        if (Auth::user()->ability('superadministrator', 'create-platforms')){

            return view('platform.create',[
                'pageheader'=>'平台渠道',
                'pagedescription'=>'创建',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePlatFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlatFormRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-platforms')){
            if (PlatForm::createPlatForm($request)){
                return redirect()->route('platforms.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-platforms')){
            return view('platform.update',[
                'pageheader'=>'平台渠道',
                'pagedescription'=>'更新',
                'platform'=>PlatForm::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StorePlatFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePlatFormRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-platforms')){
            if (PlatForm::updatePlatForm($request,$id)){
                return redirect()->route('platforms.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-platforms')){
            $platform=PlatForm::findOrFail($id);
            if ($platform->delete()){
                return redirect()->route('platforms.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
