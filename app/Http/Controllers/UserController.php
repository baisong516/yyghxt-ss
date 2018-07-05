<?php

namespace App\Http\Controllers;

use App\Department;
use App\Hospital;
use App\Http\Requests\StoreUserRequest;
use App\Office;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-users')){
            return view('user.read',[
                'pageheader'=>'用户',
                'pagedescription'=>'列表',
                'users'=>User::with('department')->get(),
                'enableUpdate'=>Auth::user()->hasPermission('update-users'),
                'enableDelete'=>Auth::user()->hasPermission('delete-users'),
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
        if (Auth::user()->ability('superadministrator', 'create-users')){
            return view('user.create',[
                'pageheader'=>'用户',
                'pagedescription'=>'添加',
                'departments'=>Department::select('id','display_name')->get(),
                'offices'=>Office::select('id','display_name')->get(),
                'hospitals'=>Hospital::select('id','display_name')->get(),
                'roles'=>Role::select('id','display_name')->get(),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-users')){
            $user=new User();
            $user->name=$request->input('name');
            $user->realname=$request->input('realname');
            $user->password=bcrypt($request->input('password'));
            $user->email=Carbon::now()->timestamp.'@admin.com';//邮箱自动生成
            $user->department_id=$request->input('department_id');
            $bool=$user->save();
            //添加负责医院
	        if ($request->input('hospitals')){
		        foreach ($request->input('hospitals') as $hospital_id){
			        $user->hospitals()->save(Hospital::findOrFail($hospital_id));
		        }
	        }
	        //添加负责项目
            if ($request->input('offices')){
	            foreach ($request->input('offices') as $office_id){
		            $user->offices()->save(Office::findOrFail($office_id));
	            }
            }

            //绑定角色
	        if ($request->input('roles')){
		        $user->attachRoles($request->input('roles'));
	        }

            if ($bool){
                return redirect()->route('users.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-users')){
            return view('user.update',[
                'pageheader'=>'用户',
                'pagedescription'=>'更新',
                'departments'=>Department::select('id','display_name')->get(),
                'offices'=>Office::select('id','display_name')->get(),
                'hospitals'=>Hospital::select('id','display_name')->get(),
                'roles'=>Role::select('id','name','display_name')->get(),
                'user'=>User::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-users')){
            $user=User::findOrFail($id);
            $user->realname=$request->input('realname');
            //update password
            if (!empty($request->input('password'))){
                $user->password=bcrypt($request->input('password'));
            }
            $user->department_id=$request->input('department_id');
            $user->is_active=$request->input('is_active');
            $bool=$user->save();
            //同步负责医院
	        if (!empty($request->input('hospitals'))){
		        $user->hospitals()->sync($request->input('hospitals'));
	        }

            //同步负责项目
	        if (!empty($request->input('offices'))){
		        $user->offices()->sync($request->input('offices'));
	        }
            //同步绑定角色
	        if (!empty($request->input('roles'))){
		        $user->syncRoles($request->input('roles'));
	        }
            if ($bool){
                return redirect()->route('users.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-users')){
            $user=User::findOrFail($id);
            //1,detach roles
            $user->detachRoles($user->roles);
            //2,detach offices 从指定用户移除所有科室
            $user->offices()->detach();
            //3,detach hospitals 从指定用户移除所有医院
            $user->hospitals()->detach();
            $bool=$user->delete();
            if ($bool){
                return redirect()->route('users.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
