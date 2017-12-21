<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Specialtran extends Model
{
    protected $table = 'specialtrans';

    public static function createSpecialtran($request)
    {
        $specialtran=new Specialtran();
        $specialtran->special_id=$request->input('special_id');
        $specialtran->cost=$request->input('cost')?$request->input('cost'):0;
        $click=$request->input('click')?$request->input('click'):0;
        $specialtran->click=$click;
        $specialtran->show=$request->input('show')?$request->input('show'):0;
        $view=$request->input('view')?$request->input('view'):0;
        $specialtran->view=$view;
        $swt_lg_one=$request->input('swt_lg_one')?$request->input('swt_lg_one'):0;
        $specialtran->swt_lg_one=$swt_lg_one;
        $specialtran->swt_lg_three=$request->input('swt_lg_three')?$request->input('swt_lg_three'):0;
        $specialtran->yuyue=$request->input('yuyue')?$request->input('yuyue'):0;
        $specialtran->arrive=$request->input('arrive')?$request->input('arrive'):0;
        $specialtran->date_tag=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag')):Carbon::now();
        //calc 跳出率=(点击-唯一身份浏览量)/点击    点击转化率=商务通大于等于1/点击
        $specialtran->skip_rate=$click>0?sprintf('%.2f',($click-$view)*100.00/$click).'%':'-';
        $specialtran->click_trans_rate=$click>0?sprintf('$.2f',$swt_lg_one*100.00/$click).'%':'-';
        return $specialtran->save();
    }
}
