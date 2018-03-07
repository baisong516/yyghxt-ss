<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    protected $table = 'causes';

    public static function createCause($request)
    {
        $cause=new Cause();
        $cause->name=$request->input('name');
        $cause->display_name=$request->input('display_name');
        $bool=$cause->save();
        return $bool;
    }

    public static function updateCause($request, $id)
    {
        $cause=Cause::findOrFail($id);
        $cause->display_name=$request->input('display_name');
        $bool=$cause->save();
        return $bool;
    }
}
