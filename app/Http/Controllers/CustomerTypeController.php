<?php

namespace App\Http\Controllers;

use App\CustomerType;
use App\Http\Requests\StoreCustomerTypeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-customer_types')){
            return view('customertype.read',[
                'pageheader'=>'患者类型',
                'pagedescription'=>'列表',
                'customertypes'=>CustomerType::select('id','name','display_name')->get(),
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
        if (Auth::user()->ability('superadministrator', 'create-customer_types')){
            return view('customertype.create',[
                'pageheader'=>'患者类型',
                'pagedescription'=>'列表',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCustomerTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerTypeRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-customer_types')){
            $customertype=new CustomerType();
            $customertype->name=$request->input('name');
            $customertype->display_name=$request->input('display_name');
            $customertype->description=$request->input('description');
            $bool=$customertype->save();
            if ($bool){
                return redirect()->route('customertypes.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-customer_types')){
            return view('customertype.update',[
                'pageheader'=>'患者类型',
                'pagedescription'=>'更新',
                'customertype'=>CustomerType::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreCustomerTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomerTypeRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-customer_types')){
            $customertype=CustomerType::findOrFail($id);
            $customertype->display_name=$request->input('display_name');
            $customertype->description=$request->input('description');
            $bool=$customertype->save();
            if ($bool){
                return redirect()->route('customertypes.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-customer_types')){
            $customertype=CustomerType::findOrFail($id);
            $bool=$customertype->delete();
            if ($bool){
                return redirect()->route('customertypes.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
