<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table = 'auctions';

    public static function createAuction($request)
    {
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
        $auction->platform_id=$request->input('platform_id');
        $auction->area_id=$request->input('area_id');
        $auction->disease_id=$request->input('disease_id');
        $auction->date_tag=$date_tag?Carbon::createFromFormat('Y-m-d',$date_tag):Carbon::now();
        //咨询成本:cost/zixun
        $auction->zixun_cost=$zixun>0?sprintf("%.2f",$cost/$zixun):'0.00';
        //到院成本:cost/arrive
        $auction->arrive_cost=$arrive>0?sprintf("%.2f",$cost/$arrive):'0.00';
        $bool=$auction->save();
        return $bool;
    }

    public static function getAuctionData($start,$end)
    {
        $diseases=Aiden::getAuthdDiseasesId();
        $auctions=Auction::select('platform_id','area_id','disease_id','budget','cost','click','zixun','yuyue','arrive','zixun_cost','arrive_cost')
            ->whereIn('disease_id',$diseases)
            ->where([
                ['date_tag','>=',$start],
                ['date_tag','<=',$end],
            ])->get();
        $total=[];
        $total['budget']=0.00;
        $total['cost']=0.00;
        $total['click']=0;
        $total['zixun']=0;
        $total['yuyue']=0;
        $total['arrive']=0;
        $total['zixun_cost']=0.00;
        $total['arrive_cost']=0.00;
        $auctionsData=[];
        foreach ($auctions as $auction){
            $total['budget']+=$auction->budget;
            $total['cost']+=$auction->cost;
            $total['click']+=$auction->click;
            $total['zixun']+=$auction->zixun;
            $total['yuyue']+=$auction->yuyue;
            $total['arrive']+=$auction->arrive;
            $total['zixun_cost']+=$auction->zixun_cost;
            $total['arrive_cost']+=$auction->arrive_cost;

            isset($auctionsData['platform'][$auction->platform_id]['budget'])?$auctionsData['platform'][$auction->platform_id]['budget']+=$auction->budget:$auctionsData['platform'][$auction->platform_id]['budget']=$auction->budget;
            isset($auctionsData['platform'][$auction->platform_id]['cost'])?$auctionsData['platform'][$auction->platform_id]['cost']+=$auction->cost:$auctionsData['platform'][$auction->platform_id]['cost']=$auction->cost;
            isset($auctionsData['platform'][$auction->platform_id]['click'])?$auctionsData['platform'][$auction->platform_id]['click']+=$auction->click:$auctionsData['platform'][$auction->platform_id]['click']=$auction->click;
            isset($auctionsData['platform'][$auction->platform_id]['zixun'])?$auctionsData['platform'][$auction->platform_id]['zixun']+=$auction->zixun:$auctionsData['platform'][$auction->platform_id]['zixun']=$auction->zixun;
            isset($auctionsData['platform'][$auction->platform_id]['yuyue'])?$auctionsData['platform'][$auction->platform_id]['yuyue']+=$auction->zixun:$auctionsData['platform'][$auction->platform_id]['yuyue']=$auction->yuyue;
            isset($auctionsData['platform'][$auction->platform_id]['arrive'])?$auctionsData['platform'][$auction->platform_id]['arrive']+=$auction->arrive:$auctionsData['platform'][$auction->platform_id]['arrive']=$auction->arrive;
            isset($auctionsData['platform'][$auction->platform_id]['zixun_cost'])?$auctionsData['platform'][$auction->platform_id]['zixun_cost']+=$auction->zixun_cost:$auctionsData['platform'][$auction->platform_id]['zixun_cost']=$auction->zixun_cost;
            isset($auctionsData['platform'][$auction->platform_id]['arrive_cost'])?$auctionsData['platform'][$auction->platform_id]['arrive_cost']+=$auction->arrive_cost:$auctionsData['platform'][$auction->platform_id]['arrive_cost']=$auction->arrive_cost;

            isset($auctionsData['area'][$auction->area_id]['budget'])?$auctionsData['area'][$auction->area_id]['budget']+=$auction->budget:$auctionsData['area'][$auction->area_id]['budget']=$auction->budget;
            isset($auctionsData['area'][$auction->area_id]['cost'])?$auctionsData['area'][$auction->area_id]['cost']+=$auction->cost:$auctionsData['area'][$auction->area_id]['cost']=$auction->cost;
            isset($auctionsData['area'][$auction->area_id]['click'])?$auctionsData['area'][$auction->area_id]['click']+=$auction->click:$auctionsData['area'][$auction->area_id]['click']=$auction->click;
            isset($auctionsData['area'][$auction->area_id]['zixun'])?$auctionsData['area'][$auction->area_id]['zixun']+=$auction->zixun:$auctionsData['area'][$auction->area_id]['zixun']=$auction->zixun;
            isset($auctionsData['area'][$auction->area_id]['yuyue'])?$auctionsData['area'][$auction->area_id]['yuyue']+=$auction->zixun:$auctionsData['area'][$auction->area_id]['yuyue']=$auction->yuyue;
            isset($auctionsData['area'][$auction->area_id]['arrive'])?$auctionsData['area'][$auction->area_id]['arrive']+=$auction->arrive:$auctionsData['area'][$auction->area_id]['arrive']=$auction->arrive;
            isset($auctionsData['area'][$auction->area_id]['zixun_cost'])?$auctionsData['area'][$auction->area_id]['zixun_cost']+=$auction->zixun_cost:$auctionsData['area'][$auction->area_id]['zixun_cost']=$auction->zixun_cost;
            isset($auctionsData['area'][$auction->area_id]['arrive_cost'])?$auctionsData['area'][$auction->area_id]['arrive_cost']+=$auction->arrive_cost:$auctionsData['area'][$auction->area_id]['arrive_cost']=$auction->arrive_cost;

            isset($auctionsData['disease'][$auction->disease_id]['budget'])?$auctionsData['disease'][$auction->disease_id]['budget']+=$auction->budget:$auctionsData['disease'][$auction->disease_id]['budget']=$auction->budget;
            isset($auctionsData['disease'][$auction->disease_id]['cost'])?$auctionsData['disease'][$auction->disease_id]['cost']+=$auction->cost:$auctionsData['disease'][$auction->disease_id]['cost']=$auction->cost;
            isset($auctionsData['disease'][$auction->disease_id]['click'])?$auctionsData['disease'][$auction->disease_id]['click']+=$auction->click:$auctionsData['disease'][$auction->disease_id]['click']=$auction->click;
            isset($auctionsData['disease'][$auction->disease_id]['zixun'])?$auctionsData['disease'][$auction->disease_id]['zixun']+=$auction->zixun:$auctionsData['disease'][$auction->disease_id]['zixun']=$auction->zixun;
            isset($auctionsData['disease'][$auction->disease_id]['yuyue'])?$auctionsData['disease'][$auction->disease_id]['yuyue']+=$auction->zixun:$auctionsData['disease'][$auction->disease_id]['yuyue']=$auction->yuyue;
            isset($auctionsData['disease'][$auction->disease_id]['arrive'])?$auctionsData['disease'][$auction->disease_id]['arrive']+=$auction->arrive:$auctionsData['disease'][$auction->disease_id]['arrive']=$auction->arrive;
            isset($auctionsData['disease'][$auction->disease_id]['zixun_cost'])?$auctionsData['disease'][$auction->disease_id]['zixun_cost']+=$auction->zixun_cost:$auctionsData['disease'][$auction->disease_id]['zixun_cost']=$auction->zixun_cost;
            isset($auctionsData['disease'][$auction->disease_id]['arrive_cost'])?$auctionsData['disease'][$auction->disease_id]['arrive_cost']+=$auction->arrive_cost:$auctionsData['disease'][$auction->disease_id]['arrive_cost']=$auction->arrive_cost;
        }
//        dd($auctionsData);
        $data=[
            'auctions'=>$auctionsData,
            'total'=>$total,
        ];
        return $data;
    }
}
