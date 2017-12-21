<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Specialtran extends Model
{
    protected $table = 'specialtrans';

    public static function createSpecialtran($request)
    {
        dd($request->all());
        $specialtran=new Specialtran();
        $specialtran->special_id=$request->input('special_id');
        $specialtran->cost=$request->input('cost')?$request->input('cost'):0;
        $specialtran->click=$request->input('click')?$request->input('click'):0;
        $specialtran->show=$request->input('show')?$request->input('show'):0;
        $specialtran->view=$request->input('view')?$request->input('view'):0;
        $specialtran->swt_lg_one=$request->input('swt_lg_one')?$request->input('swt_lg_one'):0;
        $specialtran->swt_lg_three=$request->input('swt_lg_three')?$request->input('swt_lg_three'):0;
        $specialtran->yuyue=$request->input('yuyue')?$request->input('yuyue'):0;
        $specialtran->arrive=$request->input('arrive')?$request->input('arrive'):0;
        $specialtran->date_tag=$request->input('arrive')?Carbon::createFromFormat('Y-m-d',$request->input('arrive')):Carbon::now();
        //calc 跳出率=点击-

    }
}
