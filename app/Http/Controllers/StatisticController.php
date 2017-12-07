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
        $tempDate=Statistic::select('domain','flag','date_tag','count')->where('date_tag',Carbon::now()->toDateString())->get();
        $todayClick=[];
        foreach ($tempDate as $t){
            $todayClick[$t->domain]['flag']=$t->flag;
            $todayClick[$t->domain]['count']=$t->count;
        }
        return view('button.read',[
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
            'top_swt'=>'顶部固定商务通',
            'top_tel'=>'顶部固定电话',
            'top_wechat'=>'顶部固定微信',
            'left_swt'=>'左侧固定商务通',
            'left_tel'=>'左侧固定电话',
            'left_wechat'=>'左侧固定微信',
            'right_swt'=>'右侧固定商务通',
            'right_tel'=>'右侧固定电话',
            'right_wechat'=>'右侧固定微信',
            'bottom_tel'=>'底部固定电话',
            'bottom_swt'=>'底部固定商务通',
            'bottom_wechat'=>'底部固定微信',
            'center_tel'=>'中间弹出电话',
            'center_swt'=>'中间弹出商务通',
            'center_wechat'=>'中间弹出微信',
            'bottom_window_tel'=>'底部弹出电话',
            'bottom_window_swt'=>'底部弹出商务通',
            'bottom_window_wechat'=>'底部弹出微信',
            'bottom_window_content'=>'底部弹出内容',
        ];
    }
}
