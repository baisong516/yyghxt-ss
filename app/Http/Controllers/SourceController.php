<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSourceRequest;
use App\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-sources')){
            return view('source.read',[
                'pageheader'=>'未预约原因',
                'pagedescription'=>'列表',
                'sources'=>Source::all(),
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-sources'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-sources'),
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
            return view('source.create',[
                'pageheader'=>'未预约原因',
                'pagedescription'=>'新增',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSourceRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-sources')){
            if (Source::createSource($request)){
                return redirect()->route('sources.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-sources')){
            return view('source.update',[
                'pageheader'=>'未预约原因',
                'pagedescription'=>'更新',
                'source'=>Source::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreSourceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSourceRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-sources')){
            if (Source::updateSource($request,$id)){
                return redirect()->route('sources.index')->with('success','Well Done!');
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
            $source=Source::findOrFail($id);
            if ($source->delete()){
                return redirect()->route('sources.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
