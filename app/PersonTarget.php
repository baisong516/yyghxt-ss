<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonTarget extends Model
{
    protected $table = 'person_targets';
    public static function getTargetData($year,$month=null)
    {
        if (empty($month)){
            $targets=PersonTarget::whereIn('office_id',Aiden::getAuthdOfficesId())->where('year',$year)->get();
        }else{
            $targets=PersonTarget::whereIn('office_id',Aiden::getAuthdOfficesId())->where('year',$year)->where('month',$month)->get();
        }
        $targetData=[];
        foreach ($targets as $target){
            if (empty($month)){
                $targetData[$target->office_id]['targets'][$target->user_id][$target->month]=$target;
            }else{
                $targetData[$target->office_id]['targets'][$target->user_id]=$target;
            }
            $targetData[$target->office_id]['total']['chat']=isset($targetData[$target->office_id]['total']['chat'])?$targetData[$target->office_id]['total']['chat']+=$target->chat:$target->chat;
            $targetData[$target->office_id]['total']['contact']=isset($targetData[$target->office_id]['total']['contact'])?$targetData[$target->office_id]['total']['contact']+=$target->contact:$target->contact;
            $targetData[$target->office_id]['total']['yuyue']=isset($targetData[$target->office_id]['total']['yuyue'])?$targetData[$target->office_id]['total']['yuyue']+=$target->yuyue:$target->yuyue;
            $targetData[$target->office_id]['total']['arrive']=isset($targetData[$target->office_id]['total']['arrive'])?$targetData[$target->office_id]['total']['arrive']+=$target->arrive:$target->arrive;
        }
//        dd($targetData);
        return $targetData;
    }

    /**
     * @param $year
     * @param null $month
     * @return array
     */
    public static function getTargetDataArray($office,$year,$month=null)
    {
        if (empty($month)){
            $targets=PersonTarget::where('office_id',$office)->where('year',$year)->get();
        }else{
            $targets=PersonTarget::where('office_id',$office)->where('year',$year)->where('month',$month)->get();
        }
        $targetData=[];
        foreach ($targets as $target){
            if (empty($month)){
                isset($targetData['targets'][$target->user_id]['chat'])?$targetData['targets'][$target->user_id]['chat']+=$target->chat:$targetData['targets'][$target->user_id]['chat']=$target->chat;
                isset($targetData['targets'][$target->user_id]['contact'])?$targetData['targets'][$target->user_id]['contact']+=$target->chat:$targetData['targets'][$target->user_id]['contact']=$target->chat;
                isset($targetData['targets'][$target->user_id]['yuyue'])?$targetData['targets'][$target->user_id]['yuyue']+=$target->chat:$targetData['targets'][$target->user_id]['yuyue']=$target->chat;
                isset($targetData['targets'][$target->user_id]['arrive'])?$targetData['targets'][$target->user_id]['arrive']+=$target->chat:$targetData['targets'][$target->user_id]['arrive']=$target->chat;
            }else{
                isset($targetData['monthtargets'][$target->user_id]['chat'])?$targetData['monthtargets'][$target->user_id]['chat']+=$target->chat:$targetData['monthtargets'][$target->user_id]['chat']=$target->chat;
                isset($targetData['monthtargets'][$target->user_id]['contact'])?$targetData['monthtargets'][$target->user_id]['contact']+=$target->chat:$targetData['monthtargets'][$target->user_id]['contact']=$target->chat;
                isset($targetData['monthtargets'][$target->user_id]['yuyue'])?$targetData['monthtargets'][$target->user_id]['yuyue']+=$target->chat:$targetData['monthtargets'][$target->user_id]['yuyue']=$target->chat;
                isset($targetData['monthtargets'][$target->user_id]['arrive'])?$targetData['monthtargets'][$target->user_id]['arrive']+=$target->chat:$targetData['monthtargets'][$target->user_id]['arrive']=$target->chat;
            }
            $targetData['total']['chat']=isset($targetData['total']['chat'])?$targetData['total']['chat']+=$target->chat:$target->chat;
            $targetData['total']['contact']=isset($targetData['total']['contact'])?$targetData['total']['contact']+=$target->contact:$target->contact;
            $targetData['total']['yuyue']=isset($targetData['total']['yuyue'])?$targetData['total']['yuyue']+=$target->yuyue:$target->yuyue;
            $targetData['total']['arrive']=isset($targetData['total']['arrive'])?$targetData['total']['arrive']+=$target->arrive:$target->arrive;
        }
//        dd($targetData);
        return $targetData;
    }

    public static function createTarget($request)
    {
        $target = new PersonTarget();
        $target->office_id=$request->input('office_id');
        $target->user_id=$request->input('user_id');
        $target->year=intval($request->input('year'));
        $target->month=intval($request->input('month'));
        $target->chat=intval($request->input('chat'));
        $target->contact=intval($request->input('contact'));
        $target->yuyue=intval($request->input('yuyue'));
        $target->arrive=intval($request->input('arrive'));
        $bool=$target->save();
        return $bool;
    }

    public static function updatetarget($request, $id)
    {
        $target=PersonTarget::findOrFail($id);
        $target->office_id=$request->input('office_id');
        $target->user_id=$request->input('user_id');
        $target->year=intval($request->input('year'));
        $target->month=intval($request->input('month'));
        $target->chat=intval($request->input('chat'));
        $target->chat=intval($request->input('contact'));
        $target->yuyue=intval($request->input('yuyue'));
        $target->arrive=intval($request->input('arrive'));
        $bool=$target->save();
        return $bool;
    }
}
