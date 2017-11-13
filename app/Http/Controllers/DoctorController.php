<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Hospital;
use App\Http\Requests\StoreDoctorRequest;
use App\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-doctors')){
            return view('doctor.read',[
                'pageheader'=>'医生',
                'pagedescription'=>'列表',
                'doctors'=>Doctor::all(),
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
        if (Auth::user()->ability('superadministrator', 'create-doctors')){
            return view('doctor.create',[
                'pageheader'=>'医生',
                'pagedescription'=>'添加',
                'hospitals'=>Hospital::all(),
                'offices'=>Office::all(),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreDoctorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-offices')){
            $doctor = new Doctor();
            $doctor->name=$request->input('name');
            $doctor->display_name=$request->input('display_name');
            $doctor->hospital_id=$request->input('hospital_id');
            $doctor->office_id=$request->input('office_id');
            $doctor->description=$request->input('description');
            $bool=$doctor->save();
            if ($bool){
                return redirect()->route('doctors.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'update-doctors')){
            return view('doctor.update',[
                'pageheader'=>'医生',
                'pagedescription'=>'更新',
                'hospitals'=>Hospital::all(),
                'doctor'=>Doctor::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreDoctorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDoctorRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-doctors')){
            $doctor=Doctor::findOrFail($id);
            $doctor->display_name=$request->input('display_name');
            $doctor->hospital_id=$request->input('hospital_id');
            $doctor->office_id=$request->input('office_id');
            $doctor->description=$request->input('description');
            $bool=$doctor->save();
            if ($bool){
                return redirect()->route('doctors.index')->with('success','well done!');
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
            $doctor=Doctor::findOrFail($id);
            $bool=$doctor->delete();
            if ($bool){
                return redirect()->route('doctors.index')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
