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
            //$outputs[$k]['data']=$outs;
            foreach ($outs as $out){
                if ($out->rank==0){
                    isset($outputs[$k]['data'][$out->user_id]['rank_0'])?$outputs[$k]['data'][$out->user_id]['rank_0']+=1:$outputs[$k]['data'][$out->user_id]['rank_0']=1;
                }
                if ($out->rank==1){
                    isset($outputs[$k]['data'][$out->user_id]['rank_1'])?$outputs[$k]['data'][$out->user_id]['rank_1']+=1:$outputs[$k]['data'][$out->user_id]['rank_1']=1;
                }
                isset($outputs[$k]['data'][$out->user_id]['budget'])?$outputs[$k]['data'][$out->user_id]['budget']+=$outputs[$k]['data'][$out->user_id]['budget']:$outputs[$k]['data'][$out->user_id]['budget']=$out->budget;
                isset($outputs[$k]['data'][$out->user_id]['cost'])?$outputs[$k]['data'][$out->user_id]['cost']+=$outputs[$k]['data'][$out->user_id]['cost']:$outputs[$k]['data'][$out->user_id]['cost']=$out->cost;
                isset($outputs[$k]['data'][$out->user_id]['click'])?$outputs[$k]['data'][$out->user_id]['click']+=$outputs[$k]['data'][$out->user_id]['click']:$outputs[$k]['data'][$out->user_id]['click']=$out->click;
                isset($outputs[$k]['data'][$out->user_id]['zixun'])?$outputs[$k]['data'][$out->user_id]['zixun']+=$outputs[$k]['data'][$out->user_id]['zixun']:$outputs[$k]['data'][$out->user_id]['zixun']=$out->zixun;
                isset($outputs[$k]['data'][$out->user_id]['yuyue'])?$outputs[$k]['data'][$out->user_id]['yuyue']+=$outputs[$k]['data'][$out->user_id]['yuyue']:$outputs[$k]['data'][$out->user_id]['yuyue']=$out->yuyue;
                isset($outputs[$k]['data'][$out->user_id]['arrive'])?$outputs[$k]['data'][$out->user_id]['arrive']+=$outputs[$k]['data'][$out->user_id]['arrive']:$outputs[$k]['data'][$out->user_id]['arrive']=$out->arrive;
                $outputs[$k]['data'][$out->user_id]['zixun_cost'] =isset($outputs[$k]['data'][$out->user_id]['zixun'])&&$outputs[$k]['data'][$out->user_id]['zixun']>0?$outputs[$k]['data'][$out->user_id]['cost']/$outputs[$k]['data'][$out->user_id]['zixun']:0;
                $outputs[$k]['data'][$out->user_id]['yuyue_cost'] = isset($outputs[$k]['data'][$out->user_id]['yuyue'])&&$outputs[$k]['data'][$out->user_id]['yuyue']>0?$outputs[$k]['data'][$out->user_id]['cost']/$outputs[$k]['data'][$out->user_id]['yuyue']:0;
                $outputs[$k]['data'][$out->user_id]['arrive_cost'] = isset($outputs[$k]['data'][$out->user_id]['arrive'])&&$outputs[$k]['data'][$out->user_id]['arrive']>0?$outputs[$k]['data'][$out->user_id]['cost']/$outputs[$k]['data'][$out->user_id]['arrive']:0;
            }
        }
        return $outputs;
    }
}
