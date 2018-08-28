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
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Psy\Exception\Exception;

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
        $file_data = $request->input('imgData');

        //save svg
        $file_name = 'image_table.svg'; //generating unique file name;
        $file_data=substr($file_data,strpos($file_data,'<'));
        if($file_data!=""){ // storing image in storage/app/public Folder
            Storage::disk('public')->put($file_name,urldecode($file_data));
            $link=Storage::url($file_name);
            return $link.'?v='.time();
        }
        //save png
//        $file_name = 'image_table.png'; //generating file name;
//        @list($type, $file_data) = explode(';', $file_data);
//        @list(, $file_data) = explode(',', $file_data);
//        if($file_data!=""){ // storing image in storage/app/public Folder
//            Storage::disk('public')->put($file_name,base64_decode($file_data));
//            return Storage::url($file_name.'?v='.time());
//        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $redis = app('redis.connection');
        $redis->setex('library', 10, 'predis');
        dd($redis->get('library'));
//        $todayArrangements=null;
//        $theDay=false;
        //今日排班
        $start=Carbon::now()->startOfDay();
        $end=Carbon::now()->endOfDay();
//        if ($start>$end){
//            return redirect()->back()->with('error','时间起始不合法！');
//        }
        if ($request->method()=='POST'){
            $start=Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay();
            $end=Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay();
        }
//        if ($start->toDateString()==$end->toDateString()){
//            $theDay=true;
//            $todayArrangements=Arrangement::where([
//                ['rank_date','>=',$start],
//                ['rank_date','<=',$end],
//            ])->get()->toArray();
//        }else{
//            $todayArrangements=Arrangement::where([
//                ['rank_date','>=',Carbon::now()->startOfDay()],
//                ['rank_date','<=',Carbon::now()->endOfDay()],
//            ])->get()->toArray();
//        }

//	    dd($todayArrangements);
	    //分组
//	    $departments=Department::all();
//	    $arrangements=[];
//	    $arrangeUsers=[];
//	    foreach (User::all() as $u){
//		    $arrangeUsers[$u->id]=$u;
//	    }
//	    foreach (Office::all() as $office){
//		    $arrangements[$office->id]['office']=$office->display_name;
//		    $arrangements[$office->id]['ranks']=[];
//		    foreach ($todayArrangements as $v){
//			    $user=$arrangeUsers[$v['user_id']];
//			    if ($user->hasOffice($office->id)){
//				    $arrangements[$office->id]['ranks'][0]['rank']='早班';
//				    $arrangements[$office->id]['ranks'][1]['rank']='晚班';
//				    foreach ($departments as $department){
//					    if ($v['rank']=='0'){
//						    $arrangements[$office->id]['ranks'][0]['departments'][$department->id]['department']=$department->name;
//						    if ($user->department_id==$department->id){
//							    $arrangements[$office->id]['ranks'][0]['departments'][$department->id]['users'][]=$user->realname;
//						    }
//					    }elseif($v['rank']=='1'){
//						    $arrangements[$office->id]['ranks'][1]['departments'][$department->id]['department']=$department->name;
//						    if ($user->department_id==$department->id) {
//							    $arrangements[ $office->id ]['ranks'][1]['departments'][ $department->id ]['users'][]= $user->realname;
//						    }
//					    }
//				    }
//			    }
//		    }
//	    }
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
//		    'arrangements'=>$arrangements,
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
                $data[$office->id]['total_count']=0;
                $data[$office->id]['tel_count']=0;
                $data[$office->id]['contact_count']=0;
                $data[$office->id]['yuyue_count']=0;
                $data[$office->id]['arrive_count']=0;
                $data[$office->id]['jiuzhen_count']=0;
                $data[$office->id]['should_count']=0;
                $resultFetch=ZxCustomer::select('zixun_at','created_at','tel','qq','wechat','yuyue_at','arrive_at','customer_condition_id','media_id')->where('office_id', $office->id);
                /////////////////
                $results=$resultFetch->get();
                foreach ($results as $result){
                    if ($result->zixun_at>=$start&&$result->zixun_at<=$end){
                        //总咨询量
                        $data[$office->id]['total_count']++;
                        if ($result->media_id==2){
                            //电话量
                            $data[$office->id]['tel_count']++;
                        }
                        if (!empty($result->tel)||!empty($result->qq)||!empty($result->wechat)){
                            //留联系量
                            $data[$office->id]['contact_count']++;
                        }
                    }

                    if ($result->zixun_at>=$start&&$result->zixun_at<=$end&&!empty($result->yuyue_at)){
                        //预约量
                        $data[$office->id]['yuyue_count']++;
                    }

                    if ($result->arrive_at>=$start&&$result->arrive_at<=$end){
                        if ($result->customer_condition_id==1){
                            //就诊量
                            $data[$office->id]['jiuzhen_count']++;
                        }
                        if (in_array($result->customer_condition_id,[1,2])){
                            //到院量
                            $data[$office->id]['arrive_count']++;
                        }
                    }

                    if ($result->yuyue_at>=$start&&$result->yuyue_at<=$end){
                        //应到院量
                        $data[$office->id]['should_count']++;
                    }

                }
                /////////////////咨询量
                //总咨询量
//                $data[$office->id]['total_count'] = $resultFetch->where([
//                    ['zixun_at', '>=', $start],
//                    ['zixun_at', '<=', $end],
//                ])->count();
                //电话量
//                $data[$office->id]['tel_count'] = $resultFetch->where([
//                    ['zixun_at', '>=', $start],
//                    ['zixun_at', '<=', $end],
//                ])->where('media_id', 2)->count();
                //网络咨询量
                $data[$office->id]['zixun_count'] = $data[$office->id]['total_count'] - $data[$office->id]['tel_count'];


                //预约量
//                $data[$office->id]['yuyue_count'] = $resultFetch->where([
////                    ['zixun_at', '>=', $start],
////                    ['zixun_at', '<=', $end],
//                    ['created_at', '>=', $start],
//                    ['created_at', '<=', $end],
//                ])->whereNotNull('yuyue_at')->count();
                //留联系量
//                $data[$office->id]['contact_count'] = $resultFetch->where([
//                    ['zixun_at', '>=', $start],
//                    ['zixun_at', '<=', $end],
//                ])->Where(function ($query) {
//                    $query->where('tel', '<>', '')
//                        ->orWhere('qq', '<>', '')
//                        ->orWhere('wechat', '<>', '');
//                })->count();
                //到院量
//                $data[$office->id]['arrive_count'] = $resultFetch->where([
//                    ['arrive_at', '>=', $start],
//                    ['arrive_at', '<=', $end],
//                ])->whereIn('customer_condition_id',[1,2])->count();
                //应到院量
//                $data[$office->id]['should_count'] = $resultFetch->where([
//                    ['yuyue_at', '>=', $start],
//                    ['yuyue_at', '<=', $end],
//                ])->count();
                //就诊量
                // customer_condition_id
                //1 就诊 2，到院 3，预约 4，
//                $data[$office->id]['jiuzhen_count'] = $resultFetch->where([
//                    ['arrive_at', '>=', $start],
//                    ['arrive_at', '<=', $end],
//                ])->where('customer_condition_id', 1)->count();
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
