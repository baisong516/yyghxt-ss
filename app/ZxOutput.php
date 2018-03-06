<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ZxOutput extends Model
{
    protected $table = 'zxoutputs';

    public static function createZxOutput($request)
    {
        $user_id=$request->input('user_id');
        $office_id=$request->input('office_id');
        $swt_zixun_count=$request->input('swt_zixun_count');
        $swt_yuyue_count=$request->input('swt_yuyue_count');
        $swt_contact_count=$request->input('swt_contact_count');
        $swt_arrive_count=$request->input('swt_arrive_count');
        $tel_zixun_count=$request->input('tel_zixun_count');
        $tel_yuyue_count=$request->input('tel_yuyue_count');
        $tel_arrive_count=$request->input('tel_arrive_count');
        $hf_zixun_count=$request->input('hf_zixun_count');
        $hf_yuyue_count=$request->input('hf_yuyue_count');
        $hf_arrive_count=$request->input('hf_arrive_count');

        $total_zixun_count=$swt_zixun_count+$tel_zixun_count;
        $total_yuyue_count=$swt_yuyue_count+$tel_yuyue_count;
        $total_arrive_count=$swt_arrive_count+$tel_arrive_count+$hf_arrive_count;
        $total_jiuzhen_count=$request->input('total_jiuzhen_count');

        $yuyue_rate=$total_zixun_count>0?sprintf('%.2f',$total_yuyue_count*100.00/$total_zixun_count).'%':'0.00%';
        $arrive_rate=$total_yuyue_count>0?sprintf('%.2f',$total_arrive_count*100.00/$total_yuyue_count).'%':'0.00%';
        $jiuzhen_rate=$total_arrive_count>0?sprintf('%.2f',$total_jiuzhen_count*100.00/$total_arrive_count).'%':'0.00%';
        $trans_rate=$total_zixun_count>0?sprintf('%.2f',$total_arrive_count*100.00/$total_zixun_count).'%':'0.00%';
        $dateTag=$request->input('date_tag');//2017-12-18
        $date_tag=$dateTag?Carbon::createFromFormat('Y-m-d',$dateTag):Carbon::now();
        //insert into mysql
        $zxoutput=new ZxOutput();
        $zxoutput->user_id=$user_id;
        $zxoutput->office_id=$office_id;
        $zxoutput->swt_zixun_count=$swt_zixun_count;
        $zxoutput->swt_yuyue_count=$swt_yuyue_count;
        $zxoutput->swt_contact_count=$swt_contact_count;
        $zxoutput->swt_arrive_count=$swt_arrive_count;
        $zxoutput->tel_zixun_count=$tel_zixun_count;
        $zxoutput->tel_yuyue_count=$tel_yuyue_count;
        $zxoutput->tel_arrive_count=$tel_arrive_count;
        $zxoutput->hf_zixun_count=$hf_zixun_count;
        $zxoutput->hf_yuyue_count=$hf_yuyue_count;
        $zxoutput->hf_arrive_count=$hf_arrive_count;
        $zxoutput->total_zixun_count=$total_zixun_count;
        $zxoutput->total_yuyue_count=$total_yuyue_count;
        $zxoutput->total_arrive_count=$total_arrive_count;
        $zxoutput->total_jiuzhen_count=$total_jiuzhen_count;
        $zxoutput->yuyue_rate=$yuyue_rate;
        $zxoutput->arrive_rate=$arrive_rate;
        $zxoutput->jiuzhen_rate=$jiuzhen_rate;
        $zxoutput->trans_rate=$trans_rate;
        $zxoutput->date_tag=$date_tag;
        $bool=$zxoutput->save();
        return $bool;
    }

    public static function getZxOutputs($start,$end)
    {
        $offices=Aiden::getAuthdOffices();
        $outputs=[];
        $totalu=[];
        foreach ($offices as $k=>$v){
            $outputs[$k]['office']=$v;
            $outs=ZxOutput::where('office_id',$k)->where([
                ['date_tag','>=',$start],
                ['date_tag','<=',$end],
            ])->get();
            $outdata=[];
//            dd($outs);
            foreach ($outs as $out){
                $outdata[$out->user_id]['swt_zixun_count']=isset($outdata[$out->user_id]['swt_zixun_count'])?$outdata[$out->user_id]['swt_zixun_count']+$out->swt_zixun_count:$out->swt_zixun_count;
                $outdata[$out->user_id]['swt_yuyue_count']=isset($outdata[$out->user_id]['swt_yuyue_count'])?$outdata[$out->user_id]['swt_yuyue_count']+$out->swt_yuyue_count:$out->swt_yuyue_count;
                $outdata[$out->user_id]['swt_contact_count']=isset($outdata[$out->user_id]['swt_contact_count'])?$outdata[$out->user_id]['swt_contact_count']+$out->swt_contact_count:$out->swt_contact_count;
                $outdata[$out->user_id]['swt_arrive_count']=isset($outdata[$out->user_id]['swt_arrive_count'])?$outdata[$out->user_id]['swt_arrive_count']+$out->swt_arrive_count:$out->swt_arrive_count;
                $outdata[$out->user_id]['tel_zixun_count']=isset($outdata[$out->user_id]['tel_zixun_count'])?$outdata[$out->user_id]['tel_zixun_count']+$out->tel_zixun_count:$out->tel_zixun_count;
                $outdata[$out->user_id]['tel_yuyue_count']=isset($outdata[$out->user_id]['tel_yuyue_count'])?$outdata[$out->user_id]['tel_yuyue_count']+$out->tel_yuyue_count:$out->tel_yuyue_count;
                $outdata[$out->user_id]['tel_arrive_count']=isset($outdata[$out->user_id]['tel_arrive_count'])?$outdata[$out->user_id]['tel_arrive_count']+$out->tel_arrive_count:$out->tel_arrive_count;
                $outdata[$out->user_id]['hf_zixun_count']=isset($outdata[$out->user_id]['hf_zixun_count'])?$outdata[$out->user_id]['hf_zixun_count']+$out->hf_zixun_count:$out->hf_zixun_count;
                $outdata[$out->user_id]['hf_yuyue_count']=isset($outdata[$out->user_id]['hf_yuyue_count'])?$outdata[$out->user_id]['hf_yuyue_count']+$out->hf_yuyue_count:$out->hf_yuyue_count;
                $outdata[$out->user_id]['hf_arrive_count']=isset($outdata[$out->user_id]['hf_arrive_count'])?$outdata[$out->user_id]['hf_arrive_count']+$out->hf_arrive_count:$out->hf_arrive_count;
                $outdata[$out->user_id]['total_zixun_count']=isset($outdata[$out->user_id]['total_zixun_count'])?$outdata[$out->user_id]['total_zixun_count']+$out->total_zixun_count:$out->total_zixun_count;
                $outdata[$out->user_id]['total_yuyue_count']=isset($outdata[$out->user_id]['total_yuyue_count'])?$outdata[$out->user_id]['total_yuyue_count']+$out->total_yuyue_count:$out->total_yuyue_count;
                $outdata[$out->user_id]['total_arrive_count']=isset($outdata[$out->user_id]['total_arrive_count'])?$outdata[$out->user_id]['total_arrive_count']+$out->total_arrive_count:$out->total_arrive_count;
                $outdata[$out->user_id]['total_jiuzhen_count']=isset($outdata[$out->user_id]['total_jiuzhen_count'])?$outdata[$out->user_id]['total_jiuzhen_count']+$out->total_jiuzhen_count:$out->total_jiuzhen_count;

                $outdata[$out->user_id]['contact_rate']=isset($outdata[$out->user_id]['swt_zixun_count'])&&$outdata[$out->user_id]['swt_zixun_count']>0?sprintf('%.2f',$outdata[$out->user_id]['swt_contact_count']*100.00/$outdata[$out->user_id]['swt_zixun_count']).'%':'0.00%';
                $outdata[$out->user_id]['yuyue_rate']=isset($outdata[$out->user_id]['total_zixun_count'])&&$outdata[$out->user_id]['total_zixun_count']>0?sprintf('%.2f',$outdata[$out->user_id]['total_yuyue_count']*100.00/$outdata[$out->user_id]['total_zixun_count']).'%':'0.00%';
                $outdata[$out->user_id]['arrive_rate']=isset($outdata[$out->user_id]['total_yuyue_count'])&&$outdata[$out->user_id]['total_yuyue_count']>0?sprintf('%.2f',$outdata[$out->user_id]['total_arrive_count']*100.00/$outdata[$out->user_id]['total_yuyue_count']).'%':'0.00%';
                $outdata[$out->user_id]['jiuzhen_rate']=isset($outdata[$out->user_id]['total_arrive_count'])&&$outdata[$out->user_id]['total_arrive_count']>0?sprintf('%.2f',$outdata[$out->user_id]['total_jiuzhen_count']*100.00/$outdata[$out->user_id]['total_arrive_count']).'%':'0.00%';
                $outdata[$out->user_id]['trans_rate']=isset($outdata[$out->user_id]['total_zixun_count'])&&$outdata[$out->user_id]['total_zixun_count']>0?sprintf('%.2f',$outdata[$out->user_id]['total_arrive_count']*100.00/$outdata[$out->user_id]['total_zixun_count']).'%':'0.00%';
            }
            $outputs[$k]['data']=$outdata;
//            dd($outdata);
            foreach ($outdata as $udata){
                $totalu['swt_zixun_count']=isset($totalu['swt_zixun_count'])?$totalu['swt_zixun_count']+$udata['swt_zixun_count']:$udata['swt_zixun_count'];
                $totalu['swt_yuyue_count']=isset($totalu['swt_yuyue_count'])?$totalu['swt_yuyue_count']+$udata['swt_yuyue_count']:$udata['swt_yuyue_count'];
                $totalu['swt_contact_count']=isset($totalu['swt_contact_count'])?$totalu['swt_contact_count']+$udata['swt_contact_count']:$udata['swt_contact_count'];
                $totalu['swt_arrive_count']=isset($totalu['swt_arrive_count'])?$totalu['swt_arrive_count']+$udata['swt_arrive_count']:$udata['swt_arrive_count'];
                $totalu['tel_zixun_count']=isset($totalu['tel_zixun_count'])?$totalu['tel_zixun_count']+$udata['tel_zixun_count']:$udata['tel_zixun_count'];
                $totalu['tel_yuyue_count']=isset($totalu['tel_yuyue_count'])?$totalu['tel_yuyue_count']+$udata['tel_yuyue_count']:$udata['tel_yuyue_count'];
                $totalu['tel_arrive_count']=isset($totalu['tel_arrive_count'])?$totalu['tel_arrive_count']+$udata['tel_arrive_count']:$udata['tel_arrive_count'];
                $totalu['hf_zixun_count']=isset($totalu['hf_zixun_count'])?$totalu['hf_zixun_count']+$udata['hf_zixun_count']:$udata['hf_zixun_count'];
                $totalu['hf_yuyue_count']=isset($totalu['hf_yuyue_count'])?$totalu['hf_yuyue_count']+$udata['hf_yuyue_count']:$udata['hf_yuyue_count'];
                $totalu['hf_arrive_count']=isset($totalu['hf_arrive_count'])?$totalu['hf_arrive_count']+$udata['hf_arrive_count']:$udata['hf_arrive_count'];
                $totalu['total_zixun_count']=isset($totalu['total_zixun_count'])?$totalu['total_zixun_count']+$udata['total_zixun_count']:$udata['total_zixun_count'];
                $totalu['total_yuyue_count']=isset($totalu['total_yuyue_count'])?$totalu['total_yuyue_count']+$udata['total_yuyue_count']:$udata['total_yuyue_count'];
                $totalu['total_arrive_count']=isset($totalu['total_arrive_count'])?$totalu['total_arrive_count']+$udata['total_arrive_count']:$udata['total_arrive_count'];
                $totalu['total_jiuzhen_count']=isset($totalu['total_jiuzhen_count'])?$totalu['total_jiuzhen_count']+$udata['total_jiuzhen_count']:$udata['total_jiuzhen_count'];

                $totalu['contact_rate']=isset($totalu['swt_zixun_count'])&&$totalu['swt_zixun_count']>0?sprintf('%.2f',$totalu['swt_contact_count']*100.00/$totalu['swt_zixun_count']).'%':'0.00%';
                $totalu['yuyue_rate']=isset($totalu['total_zixun_count'])&&$totalu['total_zixun_count']>0?sprintf('%.2f',$totalu['total_yuyue_count']*100.00/$totalu['total_zixun_count']).'%':'0.00%';
                $totalu['arrive_rate']=isset($totalu['total_yuyue_count'])&&$totalu['total_yuyue_count']>0?sprintf('%.2f',$totalu['total_arrive_count']*100.00/$totalu['total_yuyue_count']).'%':'0.00%';
                $totalu['jiuzhen_rate']=isset($totalu['total_arrive_count'])&&$totalu['total_arrive_count']>0?sprintf('%.2f',$totalu['total_jiuzhen_count']*100.00/$totalu['total_arrive_count']).'%':'0.00%';
                $totalu['trans_rate']=isset($totalu['total_zixun_count'])&&$totalu['total_zixun_count']>0?sprintf('%.2f',$totalu['total_arrive_count']*100.00/$totalu['total_zixun_count']).'%':'0.00%';
            }
        }
        $data=[
            'total'=>$totalu,
            'outputs'=>$outputs,
        ];
        return $data;
    }
}
