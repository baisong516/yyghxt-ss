<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\Http\Requests\StoreOfficeRequest;
use App\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-offices')){
            return view('office.read',[
                'pageheader'=>'科室',
                'pagedescription'=>'列表',
                'offices'=>Office::all(),
                'enableUpdate'=>Auth::user()->hasPermission('update-offices'),
                'enableDelete'=>Auth::user()->hasPermission('delete-offices'),
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
        if (Auth::user()->ability('superadministrator', 'create-offices')){
            return view('office.create',[
                'pageheader'=>'科室',
                'pagedescription'=>'添加',
                'hospitals'=>Hospital::all(),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOfficeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-offices')){
            $office = new Office();
            $office->name=$request->input('name');
            $office->display_name=$request->input('display_name');
            $office->hospital_id=$request->input('hospital_id');
            $office->description=$request->input('description');
            $office->tel=$request->input('tel');
            $bool=$office->save();
            if ($bool){
                return redirect()->route('offices.index')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
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
        if (Auth::user()->ability('superadministrator', 'update-offices')){
            return view('office.update',[
                'pageheader'=>'科室',
                'pagedescription'=>'更新',
                'hospitals'=>Hospital::all(),
                'office'=>Office::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreOfficeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOfficeRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-offices')){
            $office=Office::findOrFail($id);
            $office->display_name=$request->input('display_name');
            $office->hospital_id=$request->input('hospital_id');
            $office->description=$request->input('description');
            $office->tel=$request->input('tel');
            $bool=$office->save();
            if ($bool){
                return redirect()->route('offices.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-offices')){
            $office=Office::findOrFail($id);
            //before you delete office  you should delete all diseases under the office
            // 清空关联user-office
            DB::table('user_office')->where('office_id',$office->id)->delete();
            foreach ($office->diseases as $disease){
                $disease->delete();
            }
            $bool=$office->delete();
            if ($bool){
                return redirect()->route('offices.index')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
