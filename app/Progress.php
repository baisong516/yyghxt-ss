<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    //
    public static function getCompleted($year)
    {
        $offices=Aiden::getAuthdOfficesId();
        //查询竞价报表数据(平台/渠道)
        $reports=Report::whereIn('office_id',$offices)->where('type','platform')->where([
            ['date_tag','>=',Carbon::createFromFormat('Y',$year)->startOfYear()],
            ['date_tag','<=',Carbon::createFromFormat('Y',$year)->endOfYear()],
        ])->get();
        $complete=[];
        foreach ($reports as $report){
            $time=Carbon::createFromFormat('Y-m-d',$report->date_tag);
            isset($complete[$report->office_id]['month_complete'][$time->month]['cost'])?$complete[$report->office_id]['month_complete'][$time->month]['cost']+=$report->cost:$complete[$report->office_id]['month_complete'][$time->month]['cost']=$report->cost;
            isset($complete[$report->office_id]['month_complete'][$time->month]['show'])?$complete[$report->office_id]['month_complete'][$time->month]['show']+=$report->show:$complete[$report->office_id]['month_complete'][$time->month]['show']=$report->show;
            isset($complete[$report->office_id]['month_complete'][$time->month]['click'])?$complete[$report->office_id]['month_complete'][$time->month]['click']+=$report->click:$complete[$report->office_id]['month_complete'][$time->month]['click']=$report->click;
            isset($complete[$report->office_id]['month_complete'][$time->month]['achat'])?$complete[$report->office_id]['month_complete'][$time->month]['achat']+=$report->achat:$complete[$report->office_id]['month_complete'][$time->month]['achat']=$report->achat;
            isset($complete[$report->office_id]['month_complete'][$time->month]['chat'])?$complete[$report->office_id]['month_complete'][$time->month]['chat']+=$report->chat:$complete[$report->office_id]['month_complete'][$time->month]['chat']=$report->chat;
            isset($complete[$report->office_id]['month_complete'][$time->month]['contact'])?$complete[$report->office_id]['month_complete'][$time->month]['contact']+=$report->contact:$complete[$report->office_id]['month_complete'][$time->month]['contact']=$report->contact;
            isset($complete[$report->office_id]['month_complete'][$time->month]['yuyue'])?$complete[$report->office_id]['month_complete'][$time->month]['yuyue']+=$report->yuyue:$complete[$report->office_id]['month_complete'][$time->month]['yuyue']=$report->yuyue;
            isset($complete[$report->office_id]['month_complete'][$time->month]['arrive'])?$complete[$report->office_id]['month_complete'][$time->month]['arrive']+=$report->arrive:$complete[$report->office_id]['month_complete'][$time->month]['arrive']=$report->arrive;

            isset($complete[$report->office_id]['year_complete']['cost'])?$complete[$report->office_id]['year_complete']['cost']+=$report->cost:$complete[$report->office_id]['year_complete']['cost']=$report->cost;
            isset($complete[$report->office_id]['year_complete']['show'])?$complete[$report->office_id]['year_complete']['show']+=$report->show:$complete[$report->office_id]['year_complete']['show']=$report->show;
            isset($complete[$report->office_id]['year_complete']['click'])?$complete[$report->office_id]['year_complete']['click']+=$report->click:$complete[$report->office_id]['year_complete']['click']=$report->click;
            isset($complete[$report->office_id]['year_complete']['achat'])?$complete[$report->office_id]['year_complete']['achat']+=$report->achat:$complete[$report->office_id]['year_complete']['achat']=$report->achat;
            isset($complete[$report->office_id]['year_complete']['chat'])?$complete[$report->office_id]['year_complete']['chat']+=$report->chat:$complete[$report->office_id]['year_complete']['chat']=$report->chat;
            isset($complete[$report->office_id]['year_complete']['contact'])?$complete[$report->office_id]['year_complete']['contact']+=$report->contact:$complete[$report->office_id]['year_complete']['contact']=$report->contact;
            isset($complete[$report->office_id]['year_complete']['yuyue'])?$complete[$report->office_id]['year_complete']['yuyue']+=$report->yuyue:$complete[$report->office_id]['year_complete']['yuyue']=$report->yuyue;
            isset($complete[$report->office_id]['year_complete']['arrive'])?$complete[$report->office_id]['year_complete']['arrive']+=$report->arrive:$complete[$report->office_id]['year_complete']['arrive']=$report->arrive;
        }
        return $complete;
    }
}
