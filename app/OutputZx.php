<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutputZx extends Model
{

    public static function getZxOutputs($start, $end)
    {
        $offices=Aiden::getAuthdOfficesId();
        $outs_zixun=ZxCustomer::whereIn('office_id',$offices)->where([
            ['zixun_at','>=',$start],
            ['zixun_at','<=',$end],
        ])->get();
        $outs_yuyue=ZxCustomer::whereIn('office_id',$offices)->where([
            ['yuyue_at','>=',$start],
            ['yuyue_at','<=',$end],
        ])->get();
        $outs_arrive=ZxCustomer::whereIn('office_id',$offices)->where([
            ['arrive_at','>=',$start],
            ['arrive_at','<=',$end],
        ])->get();
        $outputs=[];
        $totalputs=[];
        foreach ($outs_zixun as $out){
            if (empty($out->media_id)){$out->media_id=1;}
            if (empty($out->customer_condition_id)){$out->customer_condition_id=4;}
            //汇总
            isset($totalputs[$out->office_id]['total']['zixun'])?$totalputs[$out->office_id]['total']['zixun']++:$totalputs[$out->office_id]['total']['zixun']=1;
            //咨询员分组
            if ($out->media_id==9){//手机抓取
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
                }
                if ($out->customer_condition_id==4){//咨询
                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
                }
                isset($outputs[$out->office_id][$out->user_id]['total']['contact'])?$outputs[$out->office_id][$out->user_id]['total']['contact']++:$outputs[$out->office_id][$out->user_id]['total']['contact']=1;
                isset($totalputs[$out->office_id]['total']['contact'])?$totalputs[$out->office_id]['total']['contact']++:$totalputs[$out->office_id]['total']['contact']=1;

            }else if ($out->media_id==2){//电话
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['tel']['zixun'])?$outputs[$out->office_id][$out->user_id]['tel']['zixun']++:$outputs[$out->office_id][$out->user_id]['tel']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['tel']['zixun'])?$outputs[$out->office_id][$out->user_id]['tel']['zixun']++:$outputs[$out->office_id][$out->user_id]['tel']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
                }
                if ($out->customer_condition_id==4){//咨询
                    isset($outputs[$out->office_id][$out->user_id]['tel']['zixun'])?$outputs[$out->office_id][$out->user_id]['tel']['zixun']++:$outputs[$out->office_id][$out->user_id]['tel']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
                }
                isset($outputs[$out->office_id][$out->user_id]['total']['contact'])?$outputs[$out->office_id][$out->user_id]['total']['contact']++:$outputs[$out->office_id][$out->user_id]['total']['contact']=1;
                isset($totalputs[$out->office_id]['total']['contact'])?$totalputs[$out->office_id]['total']['contact']++:$totalputs[$out->office_id]['total']['contact']=1;
            }else if ($out->media_id==12){//自媒体
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
                }
                if ($out->customer_condition_id==4){//咨询
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
                }
                isset($outputs[$out->office_id][$out->user_id]['total']['contact'])?$outputs[$out->office_id][$out->user_id]['total']['contact']++:$outputs[$out->office_id][$out->user_id]['total']['contact']=1;
                isset($totalputs[$out->office_id]['total']['contact'])?$totalputs[$out->office_id]['total']['contact']++:$totalputs[$out->office_id]['total']['contact']=1;
            }else{//商务通
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
                    if (!empty($out->tel)||!empty($out->wechat)||!empty($out->qq)){
                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
                    }
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
                    if (!empty($out->tel)||!empty($out->wechat)||!empty($out->qq)){
                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
                    }
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
                    if (!empty($out->tel)||!empty($out->wechat)||!empty($out->qq)){
                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
                    }
                }
                if ($out->customer_condition_id==4){//咨询
                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
                    if (!empty($out->tel)||!empty($out->wechat)||!empty($out->qq)){
                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
                    }
                }
                if(!empty($out->tel)||!empty($out->wechat)||!empty($out->qq)){
                    isset($outputs[$out->office_id][$out->user_id]['total']['contact'])?$outputs[$out->office_id][$out->user_id]['total']['contact']++:$outputs[$out->office_id][$out->user_id]['total']['contact']=1;
                    isset($totalputs[$out->office_id]['total']['contact'])?$totalputs[$out->office_id]['total']['contact']++:$totalputs[$out->office_id]['total']['contact']=1;
                }
            }
        }
        foreach ($outs_yuyue as $out){
            if (empty($out->media_id)){$out->media_id=1;}
            if (empty($out->customer_condition_id)){$out->customer_condition_id=4;}
            //汇总
            if ($out->customer_condition_id==1){//就诊
                isset($totalputs[$out->office_id]['total']['yuyue'])?$totalputs[$out->office_id]['total']['yuyue']++:$totalputs[$out->office_id]['total']['yuyue']=1;
            }elseif ($out->customer_condition_id==2){//到院
                isset($totalputs[$out->office_id]['total']['yuyue'])?$totalputs[$out->office_id]['total']['yuyue']++:$totalputs[$out->office_id]['total']['yuyue']=1;
            }elseif ($out->customer_condition_id==3){//预约
                isset($totalputs[$out->office_id]['total']['yuyue'])?$totalputs[$out->office_id]['total']['yuyue']++:$totalputs[$out->office_id]['total']['yuyue']=1;
            }
            //咨询员分组
            if ($out->media_id==9){//手机抓取
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['catch']['yuyue'])?$outputs[$out->office_id][$out->user_id]['catch']['yuyue']++:$outputs[$out->office_id][$out->user_id]['catch']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['catch']['yuyue'])?$totalputs[$out->office_id]['catch']['yuyue']++:$totalputs[$out->office_id]['catch']['yuyue']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['catch']['yuyue'])?$outputs[$out->office_id][$out->user_id]['catch']['yuyue']++:$outputs[$out->office_id][$out->user_id]['catch']['yuyue']=1;;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['catch']['yuyue'])?$totalputs[$out->office_id]['catch']['yuyue']++:$totalputs[$out->office_id]['catch']['yuyue']=1;
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['catch']['yuyue'])?$outputs[$out->office_id][$out->user_id]['catch']['yuyue']++:$outputs[$out->office_id][$out->user_id]['catch']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['catch']['yuyue'])?$totalputs[$out->office_id]['catch']['yuyue']++:$totalputs[$out->office_id]['catch']['yuyue']=1;
                }
            }else if ($out->media_id==2){//电话
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['tel']['yuyue'])?$outputs[$out->office_id][$out->user_id]['tel']['yuyue']++:$outputs[$out->office_id][$out->user_id]['tel']['yuyue']=1;1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['tel']['yuyue'])?$totalputs[$out->office_id]['tel']['yuyue']++:$totalputs[$out->office_id]['tel']['yuyue']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['tel']['yuyue'])?$outputs[$out->office_id][$out->user_id]['tel']['yuyue']++:$outputs[$out->office_id][$out->user_id]['tel']['yuyue']=1;1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['tel']['yuyue'])?$totalputs[$out->office_id]['tel']['yuyue']++:$totalputs[$out->office_id]['tel']['yuyue']=1;
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['tel']['yuyue'])?$outputs[$out->office_id][$out->user_id]['tel']['yuyue']++:$outputs[$out->office_id][$out->user_id]['tel']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['tel']['yuyue'])?$totalputs[$out->office_id]['tel']['yuyue']++:$totalputs[$out->office_id]['tel']['yuyue']=1;
                }
            }else if ($out->media_id==12){//自媒体
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['zmt']['yuyue'])?$totalputs[$out->office_id]['zmt']['yuyue']++:$totalputs[$out->office_id]['zmt']['yuyue']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']=1;;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['zmt']['yuyue'])?$totalputs[$out->office_id]['zmt']['yuyue']++:$totalputs[$out->office_id]['zmt']['yuyue']=1;
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['zmt']['yuyue'])?$totalputs[$out->office_id]['zmt']['yuyue']++:$totalputs[$out->office_id]['zmt']['yuyue']=1;
                }
            }else{//商务通
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['swt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['swt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['swt']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['swt']['yuyue'])?$totalputs[$out->office_id]['swt']['yuyue']++:$totalputs[$out->office_id]['swt']['yuyue']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['swt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['swt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['swt']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
                    isset($totalputs[$out->office_id]['swt']['yuyue'])?$totalputs[$out->office_id]['swt']['yuyue']++:$totalputs[$out->office_id]['swt']['yuyue']=1;
                }
                if ($out->customer_condition_id==3){//预约
                    isset($outputs[$out->office_id][$out->user_id]['swt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['swt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['swt']['yuyue']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;

                    isset($totalputs[$out->office_id]['swt']['yuyue'])?$totalputs[$out->office_id]['swt']['yuyue']++:$totalputs[$out->office_id]['swt']['yuyue']=1;
                }
            }
        }
        foreach ($outs_arrive as $out){
            if (empty($out->media_id)){$out->media_id=1;}
            if (empty($out->customer_condition_id)){$out->customer_condition_id=4;}
            //汇总
            if ($out->customer_condition_id==1){//就诊
                isset($totalputs[$out->office_id]['total']['jiuzhen'])?$totalputs[$out->office_id]['total']['jiuzhen']++:$totalputs[$out->office_id]['total']['jiuzhen']=1;
                isset($totalputs[$out->office_id]['total']['arrive'])?$totalputs[$out->office_id]['total']['arrive']++:$totalputs[$out->office_id]['total']['arrive']=1;
            }elseif ($out->customer_condition_id==2){//到院
                isset($totalputs[$out->office_id]['total']['arrive'])?$totalputs[$out->office_id]['total']['arrive']++:$totalputs[$out->office_id]['total']['arrive']=1;
            }
            //咨询员分组
            if ($out->media_id==9){//手机抓取
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['catch']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['catch']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['catch']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['catch']['arrive'])?$outputs[$out->office_id][$out->user_id]['catch']['arrive']++:$outputs[$out->office_id][$out->user_id]['catch']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['catch']['jiuzhen'])?$totalputs[$out->office_id]['catch']['jiuzhen']++:$totalputs[$out->office_id]['catch']['jiuzhen']=1;
                    isset($totalputs[$out->office_id]['catch']['arrive'])?$totalputs[$out->office_id]['catch']['arrive']++:$totalputs[$out->office_id]['catch']['arrive']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['catch']['arrive'])?$outputs[$out->office_id][$out->user_id]['catch']['arrive']++:$outputs[$out->office_id][$out->user_id]['catch']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['catch']['arrive'])?$totalputs[$out->office_id]['catch']['arrive']++:$totalputs[$out->office_id]['catch']['arrive']=1;
                }
            }else if ($out->media_id==2){//电话
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['tel']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['tel']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['tel']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['tel']['arrive'])?$outputs[$out->office_id][$out->user_id]['tel']['arrive']++:$outputs[$out->office_id][$out->user_id]['tel']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['tel']['jiuzhen'])?$totalputs[$out->office_id]['tel']['jiuzhen']++:$totalputs[$out->office_id]['tel']['jiuzhen']=1;
                    isset($totalputs[$out->office_id]['tel']['arrive'])?$totalputs[$out->office_id]['tel']['arrive']++:$totalputs[$out->office_id]['tel']['arrive']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['tel']['arrive'])?$outputs[$out->office_id][$out->user_id]['tel']['arrive']++:$outputs[$out->office_id][$out->user_id]['tel']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['tel']['arrive'])?$totalputs[$out->office_id]['tel']['arrive']++:$totalputs[$out->office_id]['tel']['arrive']=1;
                }
            }else if ($out->media_id==12){//自媒体
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['zmt']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['zmt']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['arrive'])?$outputs[$out->office_id][$out->user_id]['zmt']['arrive']++:$outputs[$out->office_id][$out->user_id]['zmt']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['zmt']['jiuzhen'])?$totalputs[$out->office_id]['zmt']['jiuzhen']++:$totalputs[$out->office_id]['zmt']['jiuzhen']=1;
                    isset($totalputs[$out->office_id]['zmt']['arrive'])?$totalputs[$out->office_id]['zmt']['arrive']++:$totalputs[$out->office_id]['zmt']['arrive']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['zmt']['arrive'])?$outputs[$out->office_id][$out->user_id]['zmt']['arrive']++:$outputs[$out->office_id][$out->user_id]['zmt']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['zmt']['arrive'])?$totalputs[$out->office_id]['zmt']['arrive']++:$totalputs[$out->office_id]['zmt']['arrive']=1;
                }
            }else{//商务通
                if ($out->customer_condition_id==1){//就诊
                    isset($outputs[$out->office_id][$out->user_id]['swt']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['swt']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['swt']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['swt']['arrive'])?$outputs[$out->office_id][$out->user_id]['swt']['arrive']++:$outputs[$out->office_id][$out->user_id]['swt']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['swt']['jiuzhen'])?$totalputs[$out->office_id]['swt']['jiuzhen']++:$totalputs[$out->office_id]['swt']['jiuzhen']=1;
                    isset($totalputs[$out->office_id]['swt']['arrive'])?$totalputs[$out->office_id]['swt']['arrive']++:$totalputs[$out->office_id]['swt']['arrive']=1;
                }
                if ($out->customer_condition_id==2){//到院
                    isset($outputs[$out->office_id][$out->user_id]['swt']['arrive'])?$outputs[$out->office_id][$out->user_id]['swt']['arrive']++:$outputs[$out->office_id][$out->user_id]['swt']['arrive']=1;
                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
                    isset($totalputs[$out->office_id]['swt']['arrive'])?$totalputs[$out->office_id]['swt']['arrive']++:$totalputs[$out->office_id]['swt']['arrive']=1;
                }
            }
        }
//        foreach ($outs_arrive as $out){
//            if (empty($out->media_id)){$out->media_id=1;}
//            if (empty($out->customer_condition_id)){$out->customer_condition_id=4;}
//            //汇总
//            if ($out->customer_condition_id==1){//就诊
//                isset($totalputs[$out->office_id]['total']['jiuzhen'])?$totalputs[$out->office_id]['total']['jiuzhen']++:$totalputs[$out->office_id]['total']['jiuzhen']=1;
//                isset($totalputs[$out->office_id]['total']['arrive'])?$totalputs[$out->office_id]['total']['arrive']++:$totalputs[$out->office_id]['total']['arrive']=1;
//                isset($totalputs[$out->office_id]['total']['yuyue'])?$totalputs[$out->office_id]['total']['yuyue']++:$totalputs[$out->office_id]['total']['yuyue']=1;
//                isset($totalputs[$out->office_id]['total']['zixun'])?$totalputs[$out->office_id]['total']['zixun']++:$totalputs[$out->office_id]['total']['zixun']=1;
//            }elseif ($out->customer_condition_id==2){//到院
//                isset($totalputs[$out->office_id]['total']['arrive'])?$totalputs[$out->office_id]['total']['arrive']++:$totalputs[$out->office_id]['total']['arrive']=1;
//                isset($totalputs[$out->office_id]['total']['yuyue'])?$totalputs[$out->office_id]['total']['yuyue']++:$totalputs[$out->office_id]['total']['yuyue']=1;
//                isset($totalputs[$out->office_id]['total']['zixun'])?$totalputs[$out->office_id]['total']['zixun']++:$totalputs[$out->office_id]['total']['zixun']=1;
//            }elseif ($out->customer_condition_id==3){//预约
//                isset($totalputs[$out->office_id]['total']['yuyue'])?$totalputs[$out->office_id]['total']['yuyue']++:$totalputs[$out->office_id]['total']['yuyue']=1;
//                isset($totalputs[$out->office_id]['total']['zixun'])?$totalputs[$out->office_id]['total']['zixun']++:$totalputs[$out->office_id]['total']['zixun']=1;
//            }elseif ($out->customer_condition_id==4){//咨询
//                isset($totalputs[$out->office_id]['total']['zixun'])?$totalputs[$out->office_id]['total']['zixun']++:$totalputs[$out->office_id]['total']['zixun']=1;
//            }
//            //咨询员分组
//            if ($out->media_id==9){//手机抓取
//                if ($out->customer_condition_id==1){//就诊
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['catch']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['catch']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['arrive'])?$outputs[$out->office_id][$out->user_id]['catch']['arrive']++:$outputs[$out->office_id][$out->user_id]['catch']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['yuyue'])?$outputs[$out->office_id][$out->user_id]['catch']['yuyue']++:$outputs[$out->office_id][$out->user_id]['catch']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['catch']['jiuzhen'])?$totalputs[$out->office_id]['catch']['jiuzhen']++:$totalputs[$out->office_id]['catch']['jiuzhen']=1;
//                    isset($totalputs[$out->office_id]['catch']['arrive'])?$totalputs[$out->office_id]['catch']['arrive']++:$totalputs[$out->office_id]['catch']['arrive']=1;
//                    isset($totalputs[$out->office_id]['catch']['yuyue'])?$totalputs[$out->office_id]['catch']['yuyue']++:$totalputs[$out->office_id]['catch']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
//                }
//                if ($out->customer_condition_id==2){//到院
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['arrive'])?$outputs[$out->office_id][$out->user_id]['catch']['arrive']++:$outputs[$out->office_id][$out->user_id]['catch']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['yuyue'])?$outputs[$out->office_id][$out->user_id]['catch']['yuyue']++:$outputs[$out->office_id][$out->user_id]['catch']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['catch']['arrive'])?$totalputs[$out->office_id]['catch']['arrive']++:$totalputs[$out->office_id]['catch']['arrive']=1;
//                    isset($totalputs[$out->office_id]['catch']['yuyue'])?$totalputs[$out->office_id]['catch']['yuyue']++:$totalputs[$out->office_id]['catch']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
//                }
//                if ($out->customer_condition_id==3){//预约
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['yuyue'])?$outputs[$out->office_id][$out->user_id]['catch']['yuyue']++:$outputs[$out->office_id][$out->user_id]['catch']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['catch']['yuyue'])?$totalputs[$out->office_id]['catch']['yuyue']++:$totalputs[$out->office_id]['catch']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
//                }
//                if ($out->customer_condition_id==4){//咨询
//                    isset($outputs[$out->office_id][$out->user_id]['catch']['zixun'])?$outputs[$out->office_id][$out->user_id]['catch']['zixun']++:$outputs[$out->office_id][$out->user_id]['catch']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['catch']['zixun'])?$totalputs[$out->office_id]['catch']['zixun']++:$totalputs[$out->office_id]['catch']['zixun']=1;
//                }
//            }else if ($out->media_id==2){//电话
//                if ($out->customer_condition_id==1){//就诊
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['tel']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['tel']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['arrive'])?$outputs[$out->office_id][$out->user_id]['tel']['arrive']++:$outputs[$out->office_id][$out->user_id]['tel']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['yuyue'])?$outputs[$out->office_id][$out->user_id]['tel']['yuyue']++:$outputs[$out->office_id][$out->user_id]['tel']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['zixun'])?$outputs[$out->office_id][$out->user_id]['tel']['zixun']++:$outputs[$out->office_id][$out->user_id]['tel']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['tel']['jiuzhen'])?$totalputs[$out->office_id]['tel']['jiuzhen']++:$totalputs[$out->office_id]['tel']['jiuzhen']=1;
//                    isset($totalputs[$out->office_id]['tel']['arrive'])?$totalputs[$out->office_id]['tel']['arrive']++:$totalputs[$out->office_id]['tel']['arrive']=1;
//                    isset($totalputs[$out->office_id]['tel']['yuyue'])?$totalputs[$out->office_id]['tel']['yuyue']++:$totalputs[$out->office_id]['tel']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
//                }
//                if ($out->customer_condition_id==2){//到院
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['arrive'])?$outputs[$out->office_id][$out->user_id]['tel']['arrive']++:$outputs[$out->office_id][$out->user_id]['tel']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['yuyue'])?$outputs[$out->office_id][$out->user_id]['tel']['yuyue']++:$outputs[$out->office_id][$out->user_id]['tel']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['zixun'])?$outputs[$out->office_id][$out->user_id]['tel']['zixun']++:$outputs[$out->office_id][$out->user_id]['tel']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['tel']['arrive'])?$totalputs[$out->office_id]['tel']['arrive']++:$totalputs[$out->office_id]['tel']['arrive']=1;
//                    isset($totalputs[$out->office_id]['tel']['yuyue'])?$totalputs[$out->office_id]['tel']['yuyue']++:$totalputs[$out->office_id]['tel']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
//                }
//                if ($out->customer_condition_id==3){//预约
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['yuyue'])?$outputs[$out->office_id][$out->user_id]['tel']['yuyue']++:$outputs[$out->office_id][$out->user_id]['tel']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['zixun'])?$outputs[$out->office_id][$out->user_id]['tel']['zixun']++:$outputs[$out->office_id][$out->user_id]['tel']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['tel']['yuyue'])?$totalputs[$out->office_id]['tel']['yuyue']++:$totalputs[$out->office_id]['tel']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
//                }
//                if ($out->customer_condition_id==4){//咨询
//                    isset($outputs[$out->office_id][$out->user_id]['tel']['zixun'])?$outputs[$out->office_id][$out->user_id]['tel']['zixun']++:$outputs[$out->office_id][$out->user_id]['tel']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['tel']['zixun'])?$totalputs[$out->office_id]['tel']['zixun']++:$totalputs[$out->office_id]['tel']['zixun']=1;
//                }
//            }else if ($out->media_id==12){//自媒体
//                if ($out->customer_condition_id==1){//就诊
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['zmt']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['zmt']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['arrive'])?$outputs[$out->office_id][$out->user_id]['zmt']['arrive']++:$outputs[$out->office_id][$out->user_id]['zmt']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['zmt']['jiuzhen'])?$totalputs[$out->office_id]['zmt']['jiuzhen']++:$totalputs[$out->office_id]['zmt']['jiuzhen']=1;
//                    isset($totalputs[$out->office_id]['zmt']['arrive'])?$totalputs[$out->office_id]['zmt']['arrive']++:$totalputs[$out->office_id]['zmt']['arrive']=1;
//                    isset($totalputs[$out->office_id]['zmt']['yuyue'])?$totalputs[$out->office_id]['zmt']['yuyue']++:$totalputs[$out->office_id]['zmt']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
//                }
//                if ($out->customer_condition_id==2){//到院
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['arrive'])?$outputs[$out->office_id][$out->user_id]['zmt']['arrive']++:$outputs[$out->office_id][$out->user_id]['zmt']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['zmt']['arrive'])?$totalputs[$out->office_id]['zmt']['arrive']++:$totalputs[$out->office_id]['zmt']['arrive']=1;
//                    isset($totalputs[$out->office_id]['zmt']['yuyue'])?$totalputs[$out->office_id]['zmt']['yuyue']++:$totalputs[$out->office_id]['zmt']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
//                }
//                if ($out->customer_condition_id==3){//预约
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['zmt']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['zmt']['yuyue'])?$totalputs[$out->office_id]['zmt']['yuyue']++:$totalputs[$out->office_id]['zmt']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
//                }
//                if ($out->customer_condition_id==4){//咨询
//                    isset($outputs[$out->office_id][$out->user_id]['zmt']['zixun'])?$outputs[$out->office_id][$out->user_id]['zmt']['zixun']++:$outputs[$out->office_id][$out->user_id]['zmt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['zmt']['zixun'])?$totalputs[$out->office_id]['zmt']['zixun']++:$totalputs[$out->office_id]['zmt']['zixun']=1;
//                }
//            }else{//商务通
//                if ($out->customer_condition_id==1){//就诊
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['swt']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['swt']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['arrive'])?$outputs[$out->office_id][$out->user_id]['swt']['arrive']++:$outputs[$out->office_id][$out->user_id]['swt']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['swt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['swt']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['jiuzhen'])?$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']++:$outputs[$out->office_id][$out->user_id]['total']['jiuzhen']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['swt']['jiuzhen'])?$totalputs[$out->office_id]['swt']['jiuzhen']++:$totalputs[$out->office_id]['swt']['jiuzhen']=1;
//                    isset($totalputs[$out->office_id]['swt']['arrive'])?$totalputs[$out->office_id]['swt']['arrive']++:$totalputs[$out->office_id]['swt']['arrive']=1;
//                    isset($totalputs[$out->office_id]['swt']['yuyue'])?$totalputs[$out->office_id]['swt']['yuyue']++:$totalputs[$out->office_id]['swt']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
//                    if (!empty($out->tel)||!empty($out->wechat)){
//                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
//                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
//                    }
//                }
//                if ($out->customer_condition_id==2){//到院
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['arrive'])?$outputs[$out->office_id][$out->user_id]['swt']['arrive']++:$outputs[$out->office_id][$out->user_id]['swt']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['swt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['swt']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['arrive'])?$outputs[$out->office_id][$out->user_id]['total']['arrive']++:$outputs[$out->office_id][$out->user_id]['total']['arrive']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['swt']['arrive'])?$totalputs[$out->office_id]['swt']['arrive']++:$totalputs[$out->office_id]['swt']['arrive']=1;
//                    isset($totalputs[$out->office_id]['swt']['yuyue'])?$totalputs[$out->office_id]['swt']['yuyue']++:$totalputs[$out->office_id]['swt']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
//                    if (!empty($out->tel)||!empty($out->wechat)){
//                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
//                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
//                    }
//                }
//                if ($out->customer_condition_id==3){//预约
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['yuyue'])?$outputs[$out->office_id][$out->user_id]['swt']['yuyue']++:$outputs[$out->office_id][$out->user_id]['swt']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['yuyue'])?$outputs[$out->office_id][$out->user_id]['total']['yuyue']++:$outputs[$out->office_id][$out->user_id]['total']['yuyue']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//
//                    isset($totalputs[$out->office_id]['swt']['yuyue'])?$totalputs[$out->office_id]['swt']['yuyue']++:$totalputs[$out->office_id]['swt']['yuyue']=1;
//                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
//                    if (!empty($out->tel)||!empty($out->wechat)){
//                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
//                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
//                    }
//                }
//                if ($out->customer_condition_id==4){//咨询
//                    isset($outputs[$out->office_id][$out->user_id]['swt']['zixun'])?$outputs[$out->office_id][$out->user_id]['swt']['zixun']++:$outputs[$out->office_id][$out->user_id]['swt']['zixun']=1;
//                    isset($outputs[$out->office_id][$out->user_id]['total']['zixun'])?$outputs[$out->office_id][$out->user_id]['total']['zixun']++:$outputs[$out->office_id][$out->user_id]['total']['zixun']=1;
//                    isset($totalputs[$out->office_id]['swt']['zixun'])?$totalputs[$out->office_id]['swt']['zixun']++:$totalputs[$out->office_id]['swt']['zixun']=1;
//                    if (!empty($out->tel)||!empty($out->wechat)){
//                        isset($outputs[$out->office_id][$out->user_id]['swt']['contact'])?$outputs[$out->office_id][$out->user_id]['swt']['contact']++:$outputs[$out->office_id][$out->user_id]['swt']['contact']=1;
//                        isset($totalputs[$out->office_id]['swt']['contact'])?$totalputs[$out->office_id]['swt']['contact']++:$totalputs[$out->office_id]['swt']['contact']=1;
//                    }
//                }
//            }
//        }
        $data=[
            'outputs'=>$outputs,
            'totaloutputs'=>$totalputs,
        ];
//        dd($data);
        return $data;
    }
}
