<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatForm extends Model
{
    protected $table = 'platforms';

    public static function createPlatForm($request)
    {
        $platform=new PlatForm();
        $platform->name=$request->input('name');
        $platform->display_name=$request->input('display_name');
        $platform->description=$request->input('description');
        $bool=$platform->save();
        return $bool;
    }

    public static function updatePlatForm($request, $id)
    {
        $platform=PlatForm::findOrFail($id);
        $platform->display_name=$request->input('display_name');
        $platform->description=$request->input('description');
        $bool=$platform->save();
        return $bool;
    }
}
