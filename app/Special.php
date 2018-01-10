<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\type;

class Special extends Model
{
    protected $table = 'specials';

    public function specialtrans()
    {
        return $this->hasMany('App\Specialtran');
    }

    public static function createSpecial($request)
    {
        $special=new Special();
        $special->office_id=$request->input('office_id');
        $special->name=$request->input('name')?$request->input('name'):'未知';
        $special->url=$request->input('url')?$request->input('url'):'null';
        $special->change_date=$request->input('change_date')?Carbon::createFromFormat('Y-m-d',$request->input('change_date')):Carbon::now();
        $special->type=json_encode($request->input('types'));
        return $special->save();
    }

    public static function getSpecialsList()
    {
        $offices=Aiden::getAuthdOffices();
        $data=[];
        foreach ($offices as $office=>$v){
            $specials=Special::where('office_id',$office)->get();
            foreach ($specials as $v){
                $d=[
                    'id'=>$v->id,
                    'office_id'=>$v->office_id,
                    'name'=>$v->name,
                    'url'=>$v->url,
                    'change_date'=>$v->change_date,
                    'type'=>json_decode($v->type,true),
                ];
                $data[$office][]=$d;
            }
        }
        return $data;
    }

    public static function updateSpecial($request, $id)
    {
        $special=Special::findOrFail($id);
        $special->name=$request->input('name');
        $special->url=$request->input('url');
        $special->office_id=$request->input('office_id');
        $special->change_date=$request->input('change_date')?Carbon::createFromFormat('Y-m-d',$request->input('change_date')):Carbon::now();
        $special->type=json_encode($request->input('types'));
        return $special->save();
    }
}
