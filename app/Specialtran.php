<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Specialtran extends Model
{
    protected $table = 'specialtrans';

    public function special()
    {
        return $this->belongsTo('App\Special');
    }

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
        $specialtran->click_trans_rate=$click>0?sprintf('%.2f',$swt_lg_one*100.00/$click).'%':'-';
        return $specialtran->save();
    }

    public static function getSpecialtransList($start,$end)
    {
        $specialtrans=Specialtran::where([
            ['date_tag','>=',$start],
            ['date_tag','<=',$end],
        ])->with('special')->get();
//        dd($specialtrans);
        $specials=[];
        foreach ($specialtrans as $s){
            $special=$s->special;
            $t['office_id']=$special->office_id;
            $t['name']=$special->name;
            $t['url']=$special->url;
            $t['change_date']=$special->change_date;
            $t['type']=json_decode($special->type,true);
            $t['cost']=isset($specials[$special['office_id']][$s->special_id]['cost'])?$specials[$special['office_id']][$s->special_id]['cost']+$s->cost:$s->cost;
            $t['click']=isset($specials[$special['office_id']][$s->special_id]['click'])?$specials[$special['office_id']][$s->special_id]['click']+$s->click:$s->click;
            $t['show']=isset($specials[$special['office_id']][$s->special_id]['show'])?$specials[$special['office_id']][$s->special_id]['show']+$s->show:$s->show;
            $t['view']=isset($specials[$special['office_id']][$s->special_id]['view'])?$specials[$special['office_id']][$s->special_id]['view']+$s->view:$s->view;
            $t['swt_lg_one']=isset($specials[$special['office_id']][$s->special_id]['swt_lg_one'])?$specials[$special['office_id']][$s->special_id]['swt_lg_one']+$s->swt_lg_one:$s->swt_lg_one;
            $t['swt_lg_three']=isset($specials[$special['office_id']][$s->special_id]['swt_lg_three'])?$specials[$special['office_id']][$s->special_id]['swt_lg_three']+$s->swt_lg_three:$s->swt_lg_three;
            $t['yuyue']=isset($specials[$special['office_id']][$s->special_id]['yuyue'])?$specials[$special['office_id']][$s->special_id]['yuyue']+$s->yuyue:$s->yuyue;
            $t['arrive']=isset($specials[$special['office_id']][$s->special_id]['arrive'])?$specials[$special['office_id']][$s->special_id]['arrive']+$s->arrive:$s->arrive;
            $t['skip_rate']=$t['click']>0?sprintf('%.2f',($t['click']-$t['view'])*100.00/$t['click']).'%':'-';
            $t['click_trans_rate']=$t['click']>0?sprintf('%.2f',$t['swt_lg_one']*100.00/$t['click']).'%':'-';
            $specials[$special['office_id']][$s->special_id]=$t;
        }
//        dd($specials);
        return $specials;
    }
}
