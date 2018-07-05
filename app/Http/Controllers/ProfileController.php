<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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
        if (Auth::user()->id!=$id){
            return redirect()->back()->with('error','不能编辑别人');
        }
        $user=User::findOrFail($id);
        return view('profile.update',[
            'pageheader'=>'系统',
            'pagedescription'=>'更新个人资料',
            'user'=>$user,
        ]);
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
        if (Auth::user()->ability('superadministrator', 'update-profiles')){
            if (Auth::user()->id==$id){
                $user=User::findOrFail($id);
                if (!empty($request->input('password'))){//修改个人密码
                    $user->password=bcrypt($request->input('password'));
                }
//                $user->realname=$request->input('realname');
                $bool=$user->save();
                if ($bool){
                    return redirect()->route('profiles.edit',$id)->with('success','Well Done！');
                }else{
                    return redirect()->back()->with('error','Something Wrong!');
                }
            }else{
                return redirect()->back()->with('error','You can not edit other profile!');
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
        //
    }
}
