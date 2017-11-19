<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-roles')){
            return view('role.read',[
                'pageheader'=>'角色',
                'pagedescription'=>'列表',
                'roles'=>Role::all(),
                'enableUpdate'=>Auth::user()->hasPermission('update-roles'),
                'enableDelete'=>Auth::user()->hasPermission('delete-roles'),
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
        if (Auth::user()->ability('superadministrator', 'create-roles')){
            return view('role.create',[
                'pageheader'=>'角色',
                'pagedescription'=>'添加',
                'permissions'=>Permission::all(),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-roles')){
           $role=new Role();
           $role->name=$request->input('name');
           $role->display_name=$request->input('display_name');
           $role->description=$request->input('description');
           $bool=$role->save();
           if ($request->input('permissions')){
               $role->attachPermissions($request->input('permissions'));
           }
           if ($bool){
               return redirect()->route('roles.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'update-roles')){
            return view('role.update',[
                'pageheader'=>'角色',
                'pagedescription'=>'更新',
                'permissions'=>Permission::all(),
                'role'=>Role::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreRoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRoleRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-roles')){
            //update the role
            $role=Role::findOrFail($id);
            $role->display_name=$request->input('display_name');
            $role->description=$request->input('description');
            $bool=$role->save();
            //sync Permissions
            if ($request->input('permissions')){
                $role->syncPermissions($request->input('permissions'));
            }else{
                //empty all permissions
                $role->detachPermissions($role->permissions);
            }
            //redirection
            if ($bool){
                return redirect()->route('roles.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-roles')){
            $role=Role::findOrFail($id);
            //delete logic (1，detach relation 2，delete role)
            //1，detach relation between role & permission
            $role->detachPermissions($role->permissions);
            //2，delete the role
            $bool=$role->delete();
            //redirection
            if ($bool){
                return redirect()->route('roles.index')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
