<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'targets';

    public static function getTargetData($year)
    {
        $targets=Target::whereIn('office_id',Aiden::getAuthdOfficesId())->where('year',$year)->get();
        $targetData=[];
        foreach ($targets as $target){
            $targetData[$target->office_id]['targets'][$target->month]=$target;
            $targetData[$target->office_id]['total']['cost']=isset($targetData[$target->office_id]['total']['cost'])?$targetData[$target->office_id]['total']['cost']+=$target->cost:$target->cost;
            $targetData[$target->office_id]['total']['show']=isset($targetData[$target->office_id]['total']['show'])?$targetData[$target->office_id]['total']['show']+=$target->show:$target->show;
            $targetData[$target->office_id]['total']['click']=isset($targetData[$target->office_id]['total']['click'])?$targetData[$target->office_id]['total']['click']+=$target->click:$target->click;
            $targetData[$target->office_id]['total']['achat']=isset($targetData[$target->office_id]['total']['achat'])?$targetData[$target->office_id]['total']['achat']+=$target->achat:$target->achat;
            $targetData[$target->office_id]['total']['chat']=isset($targetData[$target->office_id]['total']['chat'])?$targetData[$target->office_id]['total']['chat']+=$target->chat:$target->chat;
            $targetData[$target->office_id]['total']['contact']=isset($targetData[$target->office_id]['total']['contact'])?$targetData[$target->office_id]['total']['contact']+=$target->contact:$target->contact;
            $targetData[$target->office_id]['total']['yuyue']=isset($targetData[$target->office_id]['total']['yuyue'])?$targetData[$target->office_id]['total']['yuyue']+=$target->yuyue:$target->yuyue;
            $targetData[$target->office_id]['total']['arrive']=isset($targetData[$target->office_id]['total']['arrive'])?$targetData[$target->office_id]['total']['arrive']+=$target->arrive:$target->arrive;
        }
        return $targetData;
    }

    public static function createTarget($request)
    {
        $target = new Target();
        $target->office_id=$request->input('office_id');
        $target->year=intval($request->input('year'));
        $target->month=intval($request->input('month'));
        $target->cost=(float)$request->input('cost');
        $target->show=intval($request->input('show'));
        $target->click=intval($request->input('click'));
        $target->achat=intval($request->input('achat'));
        $target->chat=intval($request->input('chat'));
        $target->contact=intval($request->input('contact'));
        $target->yuyue=intval($request->input('yuyue'));
        $target->arrive=intval($request->input('arrive'));
        $bool=$target->save();
        return $bool;
    }

    public static function updatetarget($request, $id)
    {
        $target=Target::findOrFail($id);
        $target->office_id=$request->input('office_id');
        $target->year=intval($request->input('year'));
        $target->month=intval($request->input('month'));
        $target->cost=(float)$request->input('cost');
        $target->show=intval($request->input('show'));
        $target->click=intval($request->input('click'));
        $target->achat=intval($request->input('achat'));
        $target->chat=intval($request->input('chat'));
        $target->chat=intval($request->input('contact'));
        $target->yuyue=intval($request->input('yuyue'));
        $target->arrive=intval($request->input('arrive'));
        $bool=$target->save();
        return $bool;
    }
}
