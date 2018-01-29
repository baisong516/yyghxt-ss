<?php

namespace App\Http\Controllers;

use App\Arrangement;
use App\Department;
use App\Office;
use App\User;
use App\ZxCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadImage(Request $request)
    {
        $imgName=Carbon::now()->toDateString();
        $base64 = preg_replace("/\s/",'+',$request->input('imgData'));
        $img = base64_decode($base64);
        return Storage::disk('local')->put($imgName.'.png',$img);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todayArrangements=null;
        $theDay=false;
        //今日排班
        $start=Carbon::now()->startOfDay();
        $end=Carbon::now()->endOfDay();
        if ($start>$end){
            return redirect()->back()->with('error','时间起始不合法！');
        }
        if ($request->method()=='POST'){
            $start=Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay();
            $end=Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay();
        }
        if ($start->toDateString()==$end->toDateString()){
            $theDay=true;
            $todayArrangements=Arrangement::where([
                ['rank_date','>=',$start],
                ['rank_date','<=',$end],
            ])->get()->toArray();
        }else{
            $todayArrangements=Arrangement::where([
                ['rank_date','>=',Carbon::now()->startOfDay()],
                ['rank_date','<=',Carbon::now()->endOfDay()],
            ])->get()->toArray();
        }

//	    dd($todayArrangements);
	    //分组
	    $departments=Department::all();
	    $arrangements=[];
	    $arrangeUsers=[];
	    foreach (User::all() as $u){
		    $arrangeUsers[$u->id]=$u;
	    }
	    foreach (Office::all() as $office){
		    $arrangements[$office->id]['office']=$office->display_name;
		    $arrangements[$office->id]['ranks']=[];
		    foreach ($todayArrangements as $v){
//		    	$user=User::findOrFail($v['user_id']);
			    $user=$arrangeUsers[$v['user_id']];
			    if ($user->hasOffice($office->id)){
				    $arrangements[$office->id]['ranks'][0]['rank']='早班';
				    $arrangements[$office->id]['ranks'][1]['rank']='晚班';
				    foreach ($departments as $department){
					    if ($v['rank']=='0'){
						    $arrangements[$office->id]['ranks'][0]['departments'][$department->id]['department']=$department->name;
						    if ($user->department_id==$department->id){
							    $arrangements[$office->id]['ranks'][0]['departments'][$department->id]['users'][]=$user->realname;
						    }
					    }elseif($v['rank']=='1'){
						    $arrangements[$office->id]['ranks'][1]['departments'][$department->id]['department']=$department->name;
						    if ($user->department_id==$department->id) {
							    $arrangements[ $office->id ]['ranks'][1]['departments'][ $department->id ]['users'][]= $user->realname;
						    }
					    }
				    }
			    }
		    }
	    }
	    ////////////////////////////////////////////////////////////////////////
	    //项目情况
        $data = $this->getData($start, $end);
	    //上月数据
        $monthData=$this->getData(Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth());
        //年汇总数据
        $yearData=$this->getData(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
	    return view('home',[
		    'pageheader'=>'首页',
		    'pagedescription'=>'home',
		    'arrangements'=>$arrangements,
		    'data'=>$data,
		    'monthData'=>$monthData,
		    'yearData'=>$yearData,
            'start'=>$start,
            'end'=>$end,
	    ]);
    }

    /**
     * @param $start
     * @param $end
     * @return array
     */
    public function getData($start, $end): array
    {
        $user = Auth::user();
        $data = [];
        if (!empty($user->offices)) {
            foreach ($user->offices as $office) {
                $data[$office->id]['name'] = $office->display_name;
                //总咨询量
                $data[$office->id]['total_count'] = ZxCustomer::where('office_id', $office->id)->where([
                    ['zixun_at', '>=', $start],
                    ['zixun_at', '<=', $end],
                ])->count();
                //电话量
                $data[$office->id]['tel_count'] = ZxCustomer::where('office_id', $office->id)->where([
                    ['zixun_at', '>=', $start],
                    ['zixun_at', '<=', $end],
                ])->where('media_id', 2)->count();
                //网络咨询量
                $data[$office->id]['zixun_count'] = $data[$office->id]['total_count'] - $data[$office->id]['tel_count'];
                //预约量
                $data[$office->id]['yuyue_count'] = ZxCustomer::where('office_id', $office->id)->where([
                    ['zixun_at', '>=', $start],
                    ['zixun_at', '<=', $end],
                    ['created_at', '>=', $start],
                    ['created_at', '<=', $end],
                ])->whereNotNull('yuyue_at')->count();
                //留联系量
                $data[$office->id]['contact_count'] = ZxCustomer::where('office_id', $office->id)->where([
                    ['zixun_at', '>=', $start],
                    ['zixun_at', '<=', $end],
                ])->Where(function ($query) {
                    $query->where('tel', '<>', '')
                        ->orWhere('qq', '<>', '')
                        ->orWhere('wechat', '<>', '');
                })->count();
                //到院量
                $data[$office->id]['arrive_count'] = ZxCustomer::where('office_id', $office->id)->where([
                    ['arrive_at', '>=', $start],
                    ['arrive_at', '<=', $end],
                ])->count();
                //应到院量
                $data[$office->id]['should_count'] = ZxCustomer::where('office_id', $office->id)->where([
                    ['yuyue_at', '>=', $start],
                    ['yuyue_at', '<=', $end],
                ])->count();
                //就诊量
                // customer_condition_id
                //1 就诊 2，预约 3，到院 4，
                $data[$office->id]['jiuzhen_count'] = ZxCustomer::where('office_id', $office->id)->where([
                    ['arrive_at', '>=', $start],
                    ['arrive_at', '<=', $end],
                ])->where('customer_condition_id', 1)->count();
                //预约率
                $data[$office->id]['yuyue_rate'] = $data[$office->id]['zixun_count'] > 0 ? sprintf("%.2f", $data[$office->id]['yuyue_count'] * 100.00 / $data[$office->id]['total_count']) . "%" : '0.00%';
                //留联率
                $data[$office->id]['contact_rate'] = $data[$office->id]['zixun_count'] > 0 ? sprintf("%.2f", $data[$office->id]['contact_count'] * 100.00 / $data[$office->id]['total_count']) . "%" : '0.00%';
                //到院率
                $data[$office->id]['arrive_rate'] = $data[$office->id]['should_count'] > 0 ? sprintf("%.2f", $data[$office->id]['arrive_count'] * 100.00 / $data[$office->id]['should_count']) . "%" : '0.00%';
                //就诊率
                $data[$office->id]['jiuzhen_rate'] = $data[$office->id]['arrive_count'] > 0 ? sprintf("%.2f", $data[$office->id]['jiuzhen_count'] * 100.00 / $data[$office->id]['arrive_count']) . "%" : '0.00%';
                //咨询转化率
                $data[$office->id]['zhuanhua_rate'] = $data[$office->id]['zixun_count'] > 0 ? sprintf("%.2f", $data[$office->id]['arrive_count'] * 100.00 / $data[$office->id]['total_count']) . "%" : '0.00%';
            }
        }
        return $data;
    }

}
