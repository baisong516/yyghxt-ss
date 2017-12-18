<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZxOutput extends Model
{
    protected $table = 'zxoutputs';

    public static function createZxOutput($request)
    {
        $user_id=$request->input('user_id');
        $office_id=$request->input('$office_id');
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
        $date_tag=$request->input('date_tag');//2017-12-18

        //insert into mysql

    }
}
