<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    public static function createArea($request)
    {
        $area=new Area();
        $area->name=$request->input('name');
        $area->display_name=$request->input('display_name');
        $area->description=$request->input('description');
        $bool=$area->save();
        return $bool;
    }
    public static function updateArea($request, $id)
    {
        $area=Area::findOrFail($id);
        $area->display_name=$request->input('display_name');
        $area->description=$request->input('description');
        $bool=$area->save();
        return $bool;
    }
}
