<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Disease;
use App\Hospital;
use App\Http\Requests\StoreDiseaseRequest;
use App\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-diseases')){
            $diseasesCol=Disease::with('hospital','office')->get();
            $diseases=[];
            foreach ($diseasesCol as $c){
                $diseases[$c->office_id][]=$c;
            }
            return view('disease.read',[
                'pageheader'=>'病种',
                'pagedescription'=>'列表',
                'diseasesGroup'=>$diseases,
                'offices'=>Aiden::getAllModelArray('offices'),
                'enableUpdate'=>Auth::user()->hasPermission('update-diseases'),
                'enableDelete'=>Auth::user()->hasPermission('delete-diseases'),
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
        if (Auth::user()->ability('superadministrator', 'create-diseases')){
            return view('disease.create',[
                'pageheader'=>'病种',
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
     * @param  StoreDiseaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiseaseRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-diseases')){
            $disease = new Disease();
            $disease->name=$request->input('name');
            $disease->display_name=$request->input('display_name');
            $disease->hospital_id=$request->input('hospital_id');
            $disease->office_id=$request->input('office_id');
            $disease->description=$request->input('description');
            $bool=$disease->save();
            if ($bool){
                return redirect()->route('diseases.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'update-diseases')){
            return view('disease.update',[
                'pageheader'=>'病种',
                'pagedescription'=>'更新',
                'hospitals'=>Hospital::all(),
                'offices'=>Office::all(),
                'disease'=>Disease::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreDiseaseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDiseaseRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-diseases')){
            $disease = Disease::findOrFail($id);
            $disease->display_name=$request->input('display_name');
            $disease->hospital_id=$request->input('hospital_id');
            $disease->office_id=$request->input('office_id');
            $disease->description=$request->input('description');
            $bool=$disease->save();
            if ($bool){
                return redirect()->route('diseases.index')->with('success','well done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-diseases')){
           $disease=Disease::findOrFail($id);
           $bool=$disease->delete();
            if ($bool){
                return redirect()->route('diseases.index')->with('success','well done!');
            }else{
                return redirect()->back()->with('error','Something wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
