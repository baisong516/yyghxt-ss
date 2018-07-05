<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-permissions')){
            return view('permission.read',[
                'pageheader'=>'权限',
                'pagedescription'=>'列表',
                'permissions'=>Permission::all(),
                'enableUpdate'=>Auth::user()->hasPermission('update-permissions'),
                'enableDelete'=>Auth::user()->hasPermission('delete-permissions'),
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
        if (Auth::user()->ability('superadministrator', 'create-permissions')){
            return view('permission.create',[
                'pageheader'=>'权限',
                'pagedescription'=>'添加',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-permissions')){
            //insert into database
            $permission=new Permission();
            $permission->name=$request->input('name');
            $permission->display_name=$request->input('display_name');
            $permission->description=$request->input('description');
            $bool=$permission->save();
            //redirection after insert
            if ($bool){
                return redirect()->route('permissions.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'update-permissions')){
            return view('permission.update',[
                'pageheader'=>'权限',
                'pagedescription'=>'更新',
                'permission'=>Permission::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StorePermissionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePermissionRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-permissions')){
            //update the permission
            $permission=Permission::findOrFail($id);
            $permission->display_name=$request->input('display_name');
            $permission->description=$request->input('description');
            $bool=$permission->save();
            //redirection after update
            if ($bool){
                return redirect()->route('permissions.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'update-permissions')){
            //delete logic (1，detach relation 2，delete permission)
            $permission=Permission::findOrFail($id);
            //1，detach relation between role & permission
            foreach ($permission->roles as $role){
                $role->detachPermission($permission);
            }
            //2，delete the permission
            $bool=$permission->delete();
            //redirection after update
            if ($bool){
                return redirect()->route('permissions.index')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
