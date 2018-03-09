<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    public static function getReportData($start, $end)
    {
        $offices=Aiden::getAuthdOffices();
        $reports=Report::whereIn('office_id',array_keys($offices))
            ->where([
                ['date_tag','>=',$start],
                ['date_tag','<=',$end],
            ])->get();
        $reportsData=[];
        foreach ($reports as $report){
            isset($reportsData[$report->office_id]['cost'])?$reportsData[$report->office_id]['cost']+=$report->cost:$reportsData[$report->office_id]['cost']=$report->cost;
            isset($reportsData[$report->office_id]['show'])?$reportsData[$report->office_id]['show']+=$report->show:$reportsData[$report->office_id]['show']=$report->show;
            isset($reportsData[$report->office_id]['click'])?$reportsData[$report->office_id]['click']+=$report->click:$reportsData[$report->office_id]['click']=$report->click;
            isset($reportsData[$report->office_id]['achat'])?$reportsData[$report->office_id]['achat']+=$report->achat:$reportsData[$report->office_id]['achat']=$report->achat;
            isset($reportsData[$report->office_id]['chat'])?$reportsData[$report->office_id]['chat']+=$report->chat:$reportsData[$report->office_id]['chat']=$report->chat;
            isset($reportsData[$report->office_id]['contact'])?$reportsData[$report->office_id]['contact']+=$report->contact:$reportsData[$report->office_id]['contact']=$report->contact;
            isset($reportsData[$report->office_id]['yuyue'])?$reportsData[$report->office_id]['yuyue']+=$report->yuyue:$reportsData[$report->office_id]['yuyue']=$report->yuyue;
            isset($reportsData[$report->office_id]['arrive'])?$reportsData[$report->office_id]['arrive']+=$report->arrive:$reportsData[$report->office_id]['arrive']=$report->arrive;

        }
        //点击率 咨询成本 到院成本 点效比 有效对话率 留联率 预约率 到院率 咨询转化率
        foreach ($reportsData as $k=>$v){
            $reportsData[$k]['click_rate']=$v['show']>0?sprintf('%.4f',$v['click']/$v['show'])*100 . '%':0;
            $reportsData[$k]['zixun_cost']=$v['chat']>0?sprintf('%.2f',$v['cost']/$v['chat']):0;
            $reportsData[$k]['arrive_cost']=$v['arrive']>0?sprintf('%.2f',$v['cost']/$v['arrive']):0;
            $reportsData[$k]['active_rate']=$v['click']>0?sprintf('%.4f',$v['chat']/$v['click'])*100 . '%':0;
            $reportsData[$k]['chat_rate']=$v['achat']>0?sprintf('%.4f',$v['chat']/$v['achat'])*100 . '%':0;
            $reportsData[$k]['contact_rate']=$v['chat']>0?sprintf('%.4f',$v['contact']/$v['chat'])*100 . '%':0;
            $reportsData[$k]['yuyue_rate']=$v['chat']>0?sprintf('%.4f',$v['yuyue']/$v['chat'])*100 . '%':0;
            $reportsData[$k]['arrive_rate']=$v['yuyue']>0?sprintf('%.4f',$v['arrive']/$v['yuyue'])*100 . '%':0;
            $reportsData[$k]['trans_rate']=$v['chat']>0?sprintf('%.4f',$v['arrive']/$v['chat'])*100 . '%':0;
        }
        return $reportsData;
    }
}
