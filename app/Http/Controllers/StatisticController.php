<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-statistics')) {
            $start=Carbon::now()->startOfDay();
            $end=Carbon::now()->endOfDay();
            $todayClick=$this->getClickData($start,$end);
            $lastMonthClick=$this->getClickData(Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth());
            $yearClick=$this->getClickData(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
            return view('button.read', [
                'pageheader' => '数据统计',
                'pagedescription' => '按钮点击量统计',
                'offices'=>Aiden::getAllModelArray('offices'),
                'todayClick' => $todayClick,
                'monthClick'=>$lastMonthClick,
                'yearClick'=>$yearClick,
                'clickArray' => $this->getClickArray(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //搜索
    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-statistics')) {
            //点击量
            $monthSub=$request->input('monthSub');
            if ($monthSub==null){
                $start=empty($request->input('dateStart'))?Carbon::now()->startOfDay():Carbon::createFromFormat('Y-m-d',$request->input('dateStart'))->startOfDay();
                $end=empty($request->input('dateEnd'))?Carbon::now()->endOfDay():Carbon::createFromFormat('Y-m-d',$request->input('dateEnd'))->endOfDay();
            }else{
                $start=Carbon::now()->subMonth($monthSub)->startOfMonth();
                $end=Carbon::now()->subMonth($monthSub)->endOfMonth();
            }
//            $start=$request->input('dateStart')?Carbon::createFromFormat('Y-m-d',$request->input('dateStart'))->startOfDay():Carbon::now()->startOfDay();
//            $end=$request->input('dateEnd')?Carbon::createFromFormat('Y-m-d',$request->input('dateEnd'))->endOfDay():Carbon::now()->endOfDay();
            $todayClick=$this->getClickData($start,$end);
            $lastMonthClick=$this->getClickData(Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth());
            $yearClick=$this->getClickData(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
            return view('button.read', [
                'pageheader' => '数据统计',
                'pagedescription' => '按钮点击量统计',
                'todayClick' => $todayClick,
                'offices'=>Aiden::getAllModelArray('offices'),
                'start'=>$start,
                'end'=>$end,
                'clickArray' => $this->getClickArray(),
                'monthClick'=>$lastMonthClick,
                'yearClick'=>$yearClick,
            ]);
        }
    }

    private function getClickArray()
    {
        return [
            'left'=>'左侧',
            'right'=>'右侧',
            'top'=>'上侧',
            'bottom'=>'下侧',
            'center'=>'中间',
            'window'=>'弹出',
            'swt'=>'商务通',
            'tel'=>'电话',
            'qq'=>'QQ',
            'wechat'=>'微信',
            'content'=>'内容',
        ];
    }

    private function getClickData($start, $end)
    {
        $tempDate = Statistic::select('office_id','domain', 'flag', 'date_tag', 'count', 'description')->where([
            ['created_at','>=',$start],
            ['created_at','<=',$end],
        ])->get();
        $tempClick = [];
        foreach ($tempDate as $t) {
            $tempClick[$t->office_id][$t->domain][$t->flag]['description']=$t->description;
            isset($tempClick[$t->office_id][$t->domain][$t->flag]['count'])?$tempClick[$t->office_id][$t->domain][$t->flag]['count']+=$t->count:$tempClick[$t->office_id][$t->domain][$t->flag]['count']=$t->count;
        }
         return $tempClick;
    }
}
