<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Special;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SpecialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-specials')){
            return view('special.read',[
                'pageheader'=>'专题',
                'pagedescription'=>'列表',
                'specials'=>Special::getSpecialsList(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-specials'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-specials'),
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
        if (Auth::user()->ability('superadministrator', 'create-specials')){
            return view('special.create',[
                'pageheader'=>'专题',
                'pagedescription'=>'添加',
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
        if (Auth::user()->ability('superadministrator', 'create-specials')){
            if (Special::createSpecial($request)){
                return redirect()->route('specials.index')->with('success','Well Done');
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
        if (Auth::user()->ability('superadministrator', 'update-specials')){
            $special=Special::findOrFail($id);
            return view('special.update',[
                'pageheader'=>'专题',
                'pagedescription'=>'更新',
                'offices'=>Aiden::getAuthdOffices(),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'special'=>$special,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
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
        if (Auth::user()->ability('superadministrator', 'update-specials')){
            if (Special::updateSpecial($request,$id)){
                return redirect()->route('specials.index')->with('success','Well Done');
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
        if (Auth::user()->ability('superadministrator', 'delete-specials')){
            $special=Special::findOrFail($id);
            if ($special->delete()){
                return redirect()->route('specials.index')->with('success','Well Done');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
