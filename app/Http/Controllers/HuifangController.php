<?php

namespace App\Http\Controllers;

use App\Huifang;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HuifangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($request->ajax()){
            $huifang=new Huifang();
            $huifang->zx_customer_id=$request->input('zx_customer_id');
            $huifang->now_user_id=Auth::user()->id;
            $huifang->next_user_id=$request->input('next_user_id');
            $huifang->next_at=$request->input('next_at');
            $huifang->description=$request->input('description');
            $huifang->now_at=Carbon::now();
            $bool=$huifang->save();
            if ($bool){
                $data=[
                    'status'=>1,
                    'customer_id'=>$request->input('zx_customer_id'),
                    'created_at'=>Carbon::now()->toDateString(),
                    'now_user'=>Auth::user()->realname,
                    'next_at'=>$request->input('next_at')?Carbon::createFromFormat('Y-m-d H:i:s',$request->input('next_at'))->toDateString():'',
                    'next_user'=>$request->input('next_user_id')?User::findOrFail($request->input('next_user_id'))->realname:'',
                    'msg'=>'success',
                ];
            }else{
                $data=[
                    'status'=>0,
                    'customer_id'=>$request->input('zx_customer_id'),
                    'msg'=>'error',
                ];
            }
            return response()->json($data);
        }
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
