<?php

namespace App\Http\Controllers;

use App\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //今日点击量
        $tempDate=Statistic::select('domain','flag','date_tag','count','description')->where('date_tag',Carbon::now()->toDateString())->get();
        $todayClick=[];
        foreach ($tempDate as $t){
            $todayClick[$t->domain][]=[
                'flag'=>$t->flag,
                'count'=>$t->count,
                'description'=>$t->description,
            ];
        }
        return view('button.read',[
            'pageheader'=>'数据统计',
            'pagedescription'=>'按钮点击量统计',
            'todayClick'=>$todayClick,
            'clickArray'=>$this->getClickArray(),
        ]);
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

    private function getClickArray()
    {
        return [
            'left'=>'左侧',
            'right'=>'右侧',
            'top'=>'上侧',
            'bottom'=>'下侧',
            'center'=>'中间',
            'swt'=>'商务通',
            'tel'=>'电话',
            'qq'=>'QQ',
            'wechat'=>'微信',
            'window'=>'弹出',
            'content'=>'内容',
        ];
    }
}
