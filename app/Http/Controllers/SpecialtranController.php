<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Special;
use App\Specialtran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SpecialtranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-specialtrans')){
            return view('specialtran.read',[
                'pageheader'=>'专题统计',
                'pagedescription'=>'列表',
                'specials'=>Special::getSpecialsList(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-specialtrans'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-specialtrans'),
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
        if (Auth::user()->ability('superadministrator', 'create-specialtrans')){
            return view('specialtran.create',[
                'pageheader'=>'专题数据统计',
                'pagedescription'=>'添加',
                'specials'=>Special::getSpecialsList(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
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
        if (Auth::user()->ability('superadministrator', 'create-specialtrans')){
            if (Specialtran::createSpecialtran($request)){
                return redirect()->route('specialtrans.index')->with('success','Well Done');
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
}
