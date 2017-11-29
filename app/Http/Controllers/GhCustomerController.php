<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\GhCustomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GhCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-gh_customers')){
            return view('ghcustomer.read',[
                'pageheader'=>'挂号',
                'pagedescription'=>'列表',
                'customers'=>GhCustomer::getCustomers(),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
                'users'=>Aiden::getAllUserArray(),
                'zxusers'=>Aiden::getAllZxUserArray(),
                'enableHuifang'=>Auth::user()->hasPermission('create-huifangs'),
                'enableUpdate'=>Auth::user()->hasPermission('update-gh_customers'),
                'enableDelete'=>Auth::user()->hasPermission('delete-gh_customers'),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        if (Auth::user()->ability('superadministrator', 'update-zx_customers')){
            return view('ghcustomer.update', array(
                'pageheader'=>'在线挂号患者',
                'pagedescription'=>'更新',
                'offices'=>Aiden::getAuthdOffices(),
                'diseases'=>Aiden::getAuthdDiseases(),
                'customerconditions'=>Aiden::getAllModelArray('customer_conditions'),
                'customer'=>GhCustomer::findOrFail($id),
            ));
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
        if (Auth::user()->ability('superadministrator', 'update-gh_customers')){
            $customer=GhCustomer::findOrFail($id);
            $customer->customer_condition_id=$request->input('customer_condition_id');
            $customer->addons=$request->input('addons');
            $bool=$customer->save();
            if ($bool){
                return redirect()->route('ghcustomers.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-gh_customers')){
            $customer=GhCustomer::findOrFail($id);
            //delete huifangs before delete customer
            foreach ($customer->huifangs as $huifang){
                $huifang->delete();
            }
            $bool=$customer->delete();
            if ($bool){
                return redirect()->route('ghcustomers.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
