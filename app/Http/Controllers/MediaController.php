<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-medias')){
            return view('media.read',[
                'pageheader'=>'媒体',
                'pagedescription'=>'列表',
                'medias'=>Media::all(),
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
        if (Auth::user()->ability('superadministrator', 'create-medias')){
            return view('media.create',[
                'pageheader'=>'媒体',
                'pagedescription'=>'添加',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediaRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-medias')){
            $media=new Media();
            $media->name=$request->input('name');
            $media->display_name=$request->input('display_name');
            $media->description=$request->input('description');
            $bool=$media->save();
            if ($bool){
                return redirect()->route('medias.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'update-medias')){
            return view('media.update',[
                'pageheader'=>'媒体',
                'pagedescription'=>'更新',
                'media'=>Media::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreMediaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMediaRequest $request, $id)
    {
        if (Auth::user()->ability('superadministrator', 'update-medias')){
            $media=Media::findOrFail($id);
            $media->display_name=$request->input('display_name');
            $media->description=$request->input('description');
            $bool=$media->save();
            if ($bool){
                return redirect()->route('medias.index')->with('success','Well Done!');
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
        if (Auth::user()->ability('superadministrator', 'delete-medias')){
            $media=Media::findOrFail($id);
            $bool=$media->delete();
            if ($bool){
                return redirect()->route('medias.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!!!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
