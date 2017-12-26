<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JjOutput extends Model
{
    protected $table = 'jjoutputs';

    public static function createJjOutput($request)
    {
        $office_id=$request->input('office_id');
        $user_id=$request->input('user_id');
        $rank=$request->input('rank');
        $budget=$request->input('budget')?$request->input('budget'):0;
        $cost=$request->input('cost')?$request->input('cost'):0;
        $click=$request->input('click')?$request->input('click'):0;
        $zixun=$request->input('zixun')?$request->input('zixun'):0;
        $yuyue=$request->input('yuyue')?$request->input('yuyue'):0;
        $arrive=$request->input('arrive')?$request->input('arrive'):0;

        $zixun_cost=$zixun>0?sprintf('%.2f',$cost/$zixun):$cost;
        $yuyue_cost=$yuyue>0?sprintf('%.2f',$cost/$yuyue):$cost;
        $arrive_cost=$arrive>0?sprintf('%.2f',$cost/$arrive):$cost;


        $date_tag=empty($request->input('date_tag'))?Carbon::now():Carbon::createFromFormat('Y-m-d',$request->input('date_tag'));

        $output=new JjOutput();
        $output->office_id=$office_id;
        $output->user_id=$user_id;
        $output->rank=$rank;
        $output->budget=$budget;
        $output->cost=$cost;
        $output->click=$click;
        $output->zixun=$zixun;
        $output->yuyue=$yuyue;
        $output->arrive=$arrive;
        $output->zixun_cost=$zixun_cost;
        $output->yuyue_cost=$yuyue_cost;
        $output->arrive_cost=$arrive_cost;
        $output->date_tag=$date_tag;
        $bool=$output->save();
        return $bool;
    }

    public static function getJjOutputs($start, $end)
    {
        $offices=Aiden::getAuthdOffices();
        $outputs=[];
        foreach ($offices as $k=>$v){
            $outputs[$k]['office']=$v;
            $outs=JjOutput::where('office_id',$k)->where([
                ['date_tag','>=',$start],
                ['date_tag','<=',$end],
            ])->get();
            $outputs[$k]['data']=$outs;
        }
        return $outputs;
    }
}
