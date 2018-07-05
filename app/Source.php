<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'sources';

    public static function createSource($request)
    {
        $source=new Source();
        $source->name=$request->input('name');
        $source->display_name=$request->input('display_name');
        $bool=$source->save();
        return $bool;
    }

    public static function updateSource($request, $id)
    {
        $source=Source::findOrFail($id);
        $source->display_name=$request->input('display_name');
        $bool=$source->save();
        return $bool;
    }
}
