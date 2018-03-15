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
            //类型细分
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost']=0:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost']=(float)$report->cost;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost']+=(float)$report->cost:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost']=(float)$report->cost;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['show'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['show']+=$report->show:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['show']=$report->show;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['click'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['click']+=$report->click:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['click']=$report->click;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['achat'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['achat']+=$report->achat:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['achat']=$report->achat;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['chat'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['chat']+=$report->chat:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['chat']=$report->chat;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['contact'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['contact']+=$report->contact:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['contact']=$report->contact;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['yuyue'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['yuyue']+=$report->yuyue:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['yuyue']=$report->yuyue;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['arrive'])?$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['arrive']+=$report->arrive:$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['arrive']=$report->arrive;
            $reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['zixun_cost']=$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['chat']>0?sprintf('%.2f',$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost']/$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['achat']):0;
            $reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['arrive_cost']=$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['arrive']>0?sprintf('%.2f',$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['cost']/$reportsData[$report->source_id][$report->office_id][$report->type]['reports'][$report->type_id]['arrive']):0;
            //类型汇总
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['cost'])?$reportsData[$report->source_id][$report->office_id][$report->type]['cost']+=$report->cost:$reportsData[$report->source_id][$report->office_id][$report->type]['cost']=$report->cost;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['show'])?$reportsData[$report->source_id][$report->office_id][$report->type]['show']+=$report->show:$reportsData[$report->source_id][$report->office_id][$report->type]['show']=$report->show;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['click'])?$reportsData[$report->source_id][$report->office_id][$report->type]['click']+=$report->click:$reportsData[$report->source_id][$report->office_id][$report->type]['click']=$report->click;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['achat'])?$reportsData[$report->source_id][$report->office_id][$report->type]['achat']+=$report->achat:$reportsData[$report->source_id][$report->office_id][$report->type]['achat']=$report->achat;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['chat'])?$reportsData[$report->source_id][$report->office_id][$report->type]['chat']+=$report->chat:$reportsData[$report->source_id][$report->office_id][$report->type]['chat']=$report->chat;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['contact'])?$reportsData[$report->source_id][$report->office_id][$report->type]['contact']+=$report->contact:$reportsData[$report->source_id][$report->office_id][$report->type]['contact']=$report->contact;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['yuyue'])?$reportsData[$report->source_id][$report->office_id][$report->type]['yuyue']+=$report->yuyue:$reportsData[$report->source_id][$report->office_id][$report->type]['yuyue']=$report->yuyue;
            isset($reportsData[$report->source_id][$report->office_id][$report->type]['arrive'])?$reportsData[$report->source_id][$report->office_id][$report->type]['arrive']+=$report->arrive:$reportsData[$report->source_id][$report->office_id][$report->type]['arrive']=$report->arrive;
            $reportsData[$report->source_id][$report->office_id][$report->type]['zixun_cost']=$reportsData[$report->source_id][$report->office_id][$report->type]['chat']>0?sprintf('%.2f',$reportsData[$report->source_id][$report->office_id][$report->type]['cost']/$reportsData[$report->source_id][$report->office_id][$report->type]['chat']):0;
            $reportsData[$report->source_id][$report->office_id][$report->type]['arrive_cost']=$reportsData[$report->source_id][$report->office_id][$report->type]['arrive']>0?sprintf('%.2f',$reportsData[$report->source_id][$report->office_id][$report->type]['cost']/$reportsData[$report->source_id][$report->office_id][$report->type]['arrive']):0;
        }
        //点击率 咨询成本 到院成本 点效比 有效对话率 留联率 预约率 到院率 咨询转化率
//        foreach ($reportsData as $k=>$v){
//            $reportsData[$k]['click_rate']=$v['show']>0?sprintf('%.4f',$v['click']/$v['show'])*100 . '%':0;
//            $reportsData[$k]['zixun_cost']=$v['chat']>0?sprintf('%.2f',$v['cost']/$v['chat']):0;
//            $reportsData[$k]['arrive_cost']=$v['arrive']>0?sprintf('%.2f',$v['cost']/$v['arrive']):0;
//            $reportsData[$k]['active_rate']=$v['click']>0?sprintf('%.4f',$v['chat']/$v['click'])*100 . '%':0;
//            $reportsData[$k]['chat_rate']=$v['achat']>0?sprintf('%.4f',$v['chat']/$v['achat'])*100 . '%':0;
//            $reportsData[$k]['contact_rate']=$v['chat']>0?sprintf('%.4f',$v['contact']/$v['chat'])*100 . '%':0;
//            $reportsData[$k]['yuyue_rate']=$v['chat']>0?sprintf('%.4f',$v['yuyue']/$v['chat'])*100 . '%':0;
//            $reportsData[$k]['arrive_rate']=$v['yuyue']>0?sprintf('%.4f',$v['arrive']/$v['yuyue'])*100 . '%':0;
//            $reportsData[$k]['trans_rate']=$v['chat']>0?sprintf('%.4f',$v['arrive']/$v['chat'])*100 . '%':0;
//        }
        return $reportsData;
    }

    public static function createReport($request)
    {
        $report = new Report();
        $report->office_id=$request->input('office_id');
        $report->source_id=$request->input('source_id');
        $report->type=$request->input('type');
        $report->type_id=$request->input('type_id');
        $report->cost=$request->input('cost');
        $report->show=$request->input('show');
        $report->click=$request->input('click');
        $report->achat=$request->input('achat');
        $report->chat=$request->input('chat');
        $report->contact=$request->input('contact');
        $report->yuyue=$request->input('yuyue');
        $report->arrive=$request->input('arrive');
        $report->date_tag=$request->input('date_tag');
        $bool=$report->save();
    }

    public static function updateReport($request, $id)
    {
        $report = Report::findOrFail($id);
        $report->office_id=$request->input('office_id');
        $report->source_id=$request->input('source_id');
        $report->type=$request->input('type');
        $report->type_id=$request->input('type_id');
        $report->cost=$request->input('cost');
        $report->show=$request->input('show');
        $report->click=$request->input('click');
        $report->achat=$request->input('achat');
        $report->chat=$request->input('chat');
        $report->contact=$request->input('contact');
        $report->yuyue=$request->input('yuyue');
        $report->arrive=$request->input('arrive');
        $report->date_tag=$request->input('date_tag');
        $bool=$report->save();
        return $bool;
    }
}
