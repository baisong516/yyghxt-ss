<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table = 'auctions';

    public static function createAuction($request)
    {
        $office_id=$request->input('office_id');
        $type=$request->input('type');
        $type_id=$request->input('type_id');
        $budget=$request->input('budget');
        $cost=$request->input('cost');
        $click=$request->input('click');
        $zixun=$request->input('zixun');
        $yuyue=$request->input('yuyue');
        $arrive=$request->input('arrive');
        $date_tag=$request->input('date_tag');
        $auction = new Auction();
        $auction->budget=$budget;
        $auction->cost=$cost;
        $auction->click=$click;
        $auction->zixun=$zixun;
        $auction->yuyue=$yuyue;
        $auction->arrive=$arrive;
        $auction->date_tag=$date_tag?Carbon::createFromFormat('Y-m-d',$date_tag):Carbon::now();
        //咨询成本:cost/zixun
        $auction->zixun_cost=$zixun>0?sprintf("%.2f",$cost/$zixun):'0.00';
        //到院成本:cost/arrive
        $auction->arrive_cost=$arrive>0?sprintf("%.2f",$cost/$arrive):'0.00';
        $auction->office_id=$office_id;
        $auction->type=$type;
        $auction->type_id=$type_id;
        $bool=$auction->save();
        return $bool;
    }

    public static function getAuctionData($start,$end)
    {
        $offices=Aiden::getAuthdOffices();
        $auctions=Auction::whereIn('office_id',array_keys($offices))
            ->where([
                ['date_tag','>=',$start],
                ['date_tag','<=',$end],
            ])->get();
//        dd($auctions);
        $tempData=[];
        foreach ($auctions as $auction){
            if ($auction->type=='disease'){
                $tempData[$auction->office_id]['disease'][]=$auction;
            }elseif ($auction->type=='platform'){
                $tempData[$auction->office_id]['platform'][]=$auction;
            }elseif ($auction->type=='area'){
                $tempData[$auction->office_id]['area'][]=$auction;
            }
        }
        $auctionsData=[];
        foreach ($tempData as $k=>$o){
            foreach ($o as $type=>$auctions){
                foreach ($auctions as $auction){
                    //$auctionsData[$k][$type]['auctions'][]=$auction;
                    isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['budget'])?$auctionsData[$k][$type]['auctions'][$auction->type_id]['budget']+=$auction->budget:$auctionsData[$k][$type]['auctions'][$auction->type_id]['budget']=$auction->budget;
                    isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['cost'])?$auctionsData[$k][$type]['auctions'][$auction->type_id]['cost']+=$auction->cost:$auctionsData[$k][$type]['auctions'][$auction->type_id]['cost']=$auction->cost;
                    isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['click'])?$auctionsData[$k][$type]['auctions'][$auction->type_id]['click']+=$auction->click:$auctionsData[$k][$type]['auctions'][$auction->type_id]['click']=$auction->click;
                    isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['zixun'])?$auctionsData[$k][$type]['auctions'][$auction->type_id]['zixun']+=$auction->zixun:$auctionsData[$k][$type]['auctions'][$auction->type_id]['zixun']=$auction->zixun;
                    isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['yuyue'])?$auctionsData[$k][$type]['auctions'][$auction->type_id]['yuyue']+=$auction->yuyue:$auctionsData[$k][$type]['auctions'][$auction->type_id]['yuyue']=$auction->yuyue;
                    isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['arrive'])?$auctionsData[$k][$type]['auctions'][$auction->type_id]['arrive']+=$auction->arrive:$auctionsData[$k][$type]['auctions'][$auction->type_id]['arrive']=$auction->arrive;
                    $auctionsData[$k][$type]['auctions'][$auction->type_id]['zixun_cost']=isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['zixun'])&&$auctionsData[$k][$type]['auctions'][$auction->type_id]['zixun']>0?sprintf('%.2f',$auctionsData[$k][$type]['auctions'][$auction->type_id]['cost']/$auctionsData[$k][$type]['auctions'][$auction->type_id]['zixun']):0;
                    $auctionsData[$k][$type]['auctions'][$auction->type_id]['arrive_cost']=isset($auctionsData[$k][$type]['auctions'][$auction->type_id]['arrive'])&&$auctionsData[$k][$type]['auctions'][$auction->type_id]['arrive']>0?sprintf('%.2f',$auctionsData[$k][$type]['auctions'][$auction->type_id]['cost']/$auctionsData[$k][$type]['auctions'][$auction->type_id]['arrive']):0;
                    //合计汇总
                    isset($auctionsData[$k][$type]['budget'])?$auctionsData[$k][$type]['budget']+=$auction->budget:$auctionsData[$k][$type]['budget']=$auction->budget;
                    isset($auctionsData[$k][$type]['cost'])?$auctionsData[$k][$type]['cost']+=$auction->cost:$auctionsData[$k][$type]['cost']=$auction->cost;
                    isset($auctionsData[$k][$type]['click'])?$auctionsData[$k][$type]['click']+=$auction->click:$auctionsData[$k][$type]['click']=$auction->click;
                    isset($auctionsData[$k][$type]['zixun'])?$auctionsData[$k][$type]['zixun']+=$auction->zixun:$auctionsData[$k][$type]['zixun']=$auction->zixun;
                    isset($auctionsData[$k][$type]['yuyue'])?$auctionsData[$k][$type]['yuyue']+=$auction->yuyue:$auctionsData[$k][$type]['yuyue']=$auction->yuyue;
                    isset($auctionsData[$k][$type]['arrive'])?$auctionsData[$k][$type]['arrive']+=$auction->arrive:$auctionsData[$k][$type]['arrive']=$auction->arrive;
                    //isset($auctionsData[$k][$type]['zixun_cost'])?$auctionsData[$k][$type]['zixun_cost']+=$auction->zixun_cost:$auctionsData[$k][$type]['zixun_cost']=$auction->zixun_cost;
                    //isset($auctionsData[$k][$type]['arrive_cost'])?$auctionsData[$k][$type]['arrive_cost']+=$auction->arrive_cost:$auctionsData[$k][$type]['arrive_cost']=$auction->arrive_cost;
                    $auctionsData[$k][$type]['zixun_cost']=isset($auctionsData[$k][$type]['zixun'])&&$auctionsData[$k][$type]['zixun']>0?sprintf('%.2f',$auctionsData[$k][$type]['cost']/$auctionsData[$k][$type]['zixun']):0;
                    $auctionsData[$k][$type]['arrive_cost']=isset($auctionsData[$k][$type]['arrive'])&&$auctionsData[$k][$type]['arrive']>0?sprintf('%.2f',$auctionsData[$k][$type]['cost']/$auctionsData[$k][$type]['arrive']):0;
                }
            }
        }
        //dd($auctionsData);
        return $auctionsData;
    }
}
