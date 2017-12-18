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

    public static function getAllZxOutputs()
    {
        $offices=Aiden::getAuthdOffices();
        $outputs=[];
        foreach ($offices as $k=>$v){
            $outputs[$k]['office']=$v;
            $outputs[$k]['data']=ZxOutput::where('office_id',$k)->get();
        }
        return $outputs;
    }
}
