<?php

namespace App\Http\Controllers;

use App\CustomerCondition;
use App\Http\Requests\StoreCustomerConditionRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-customer_conditions')){
            return view('customercondition.read',[
                'pageheader'=>'患者状态',
                'pagedescription'=>'列表',
                'customerconditions'=>CustomerCondition::select('id','name','display_name')->get(),
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
        if (Auth::user()->ability('superadministrator', 'create-customer_conditions')){
            return view('customercondition.create',[
                'pageheader'=>'患者类型',
                'pagedescription'=>'添加',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCustomerConditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerConditionRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-customer_conditions')){
            $customercondition=new CustomerCondition();
            $customercondition->name=$request->input('name');
            $customercondition->display_name=$request->input('display_name');
            $customercondition->description=$request->input('description');
            $bool=$customercondition->save();
            if ($bool){
                return redirect()->route('customerconditions.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-customer_conditions')){
            return view('customercondition.update',[
                'pageheader'=>'患者状态',
                'pagedescription'=>'更新',
                'customercondition'=>CustomerCondition::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreCustomerConditionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomerConditionRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-customer_conditions')){
            $customercondition=CustomerCondition::findOrFail($id);
            $customercondition->display_name=$request->input('display_name');
            $customercondition->description=$request->input('description');
            $bool=$customercondition->save();
            if ($bool){
                return redirect()->route('customerconditions.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-customer_conditions')){
            $customercondition=CustomerCondition::findOrFail($id);
            $bool=$customercondition->delete();
            if ($bool){
                return redirect()->route('customerconditions.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
