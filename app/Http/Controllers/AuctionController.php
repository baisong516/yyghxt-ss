<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\Area;
use App\Auction;
use App\Http\Requests\StoreAuctionRequest;
use App\PlatForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-auctions')){
            $start=Carbon::now()->startOfDay();
            $end=Carbon::now()->endOfDay();
//            dd(Auction::getAuctionData($start,$end));
            return view('auction.read',[
                'pageheader'=>'竞价部',
                'pagedescription'=>'报表',
                'auctions'=>Auction::getAuctionData($start,$end),
                'platforms'=>Aiden::getAllModelArray('platforms'),
                'areas'=>Aiden::getAllModelArray('areas'),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'start'=>$start,
                'end'=>$end,
//                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-areas'),
//                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-areas'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->ability('superadministrator', 'create-auctions')){
            return view('auction.create',[
                'pageheader'=>'竞价报表',
                'pagedescription'=>'录入',
                'offices'=>Aiden::getAllModelArray('offices'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAuctionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuctionRequest $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-auctions')){
            if (Auction::createAuction($request)){
                return redirect()->route('auctions.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
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
        if (Auth::user()->ability('superadministrator', 'update-auctions')){
            return view('auction.update',[
                'pageheader'=>'竞价报表',
                'pagedescription'=>'更新',
                'offices'=>Aiden::getAllModelArray('offices'),
                'options'=>Aiden::getAllModelArray(Auction::findOrFail($id)->type.'s'),
                'auction'=>Auction::findOrFail($id),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
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
        if (Auth::user()->ability('superadministrator', 'update-auctions')){
            if (Auction::updateAuction($request,$id)){
                return redirect()->route('auctions.index')->with('success','Well Done!');
            }else{
                return redirect()->back()->with('error','Something Wrong!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-auctions')){
            $start=$request->input('searchDateStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay():Carbon::now()->startOfDay();
            $end=$request->input('searchDateEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay():Carbon::now()->endOfDay();
            $data=Auction::getAuctionData($start,$end);
//            dd($data);
            return view('auction.read',[
                'pageheader'=>'竞价部',
                'pagedescription'=>'报表',
                'auctions'=>Auction::getAuctionData($start,$end),
                'platforms'=>Aiden::getAllModelArray('platforms'),
                'areas'=>Aiden::getAllModelArray('areas'),
                'offices'=>Aiden::getAllModelArray('offices'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'start'=>$start,
                'end'=>$end,
                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-auctions'),
                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-auctions'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function import(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'create-auctions')){
            $file = $request->file('file');
            if (empty($file)){
                return redirect()->back()->with('error','没有选择文件');
            }else{
                $res=[];
                $dateTag=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag')):Carbon::now();
                $start=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->startOfDay():Carbon::now()->startOfDay();
                $end=$request->input('date_tag')?Carbon::createFromFormat('Y-m-d',$request->input('date_tag'))->endOfDay():Carbon::now()->endOfDay();
                $isExist=Auction::where([
                    ['date_tag','>=',$start],
                    ['date_tag','<=',$end],
                ])->count();
                if ($isExist>0){
                    return redirect()->back()->with('error',$request->input('date_tag').'的数据已录过一次，为避免数据混乱，禁止二次录入！');
                }
                Excel::load($file, function($reader) use( &$res,$dateTag ) {
                    $reader = $reader->getSheet(0);
                    $res = $reader->toArray();
                });
                $res=array_slice($res,1);
//                dd($res);
                $offices=Aiden::getAllModelArray('offices');
                $types=[
                    'platform'=>'渠道',
                    'area'=>'地区',
                    'disease'=>'病种',
                ];
                $platforms=Aiden::getAllModelArray('platforms');
                $areas=Aiden::getAllModelArray('areas');
                $diseases=Aiden::getAllModelArray('diseases');
                foreach ($res as $d){
                    $office_id=array_search($d[0],$offices);//项目
                    $type=array_search($d[1],$types);//类型
                    $type_id=$d[2];
                    if ($type=='platform'){
                        $type_id=array_search($d[2],$platforms);
                    }
                    if ($type=='area'){
                        $type_id=array_search($d[2],$areas);
                    }
                    if ($type=='disease'){
                        $type_id=array_search($d[2],$diseases);
                    }
                    $budget=$d[3]?$d[3]:0;//预算
                    $cost=$d[4]?$d[4]:0;//消费
                    $click=$d[5]?$d[5]:0;//点击
                    $zixun=$d[6]?$d[6]:0;//咨询量
                    $yuyue=$d[7]?$d[7]:0;//预约量
                    $arrive=$d[8]?$d[8]:0;//总到院

                    $zixun_cost=$zixun>0?sprintf('%.2f',$cost/$zixun):0;//咨询成本
                    $arrive_cost=$arrive>0?sprintf('%.2f',$cost/$arrive):0;//到院成本
                    $date_tag=$dateTag;//日期


                    $auction=new Auction();
                    $auction->office_id=$office_id;
                    $auction->type=$type;
                    $auction->type_id=$type_id;
                    $auction->budget=$budget;
                    $auction->cost=$cost;
                    $auction->click=$click;
                    $auction->zixun=$zixun;
                    $auction->yuyue=$yuyue;
                    $auction->arrive=$arrive;
                    $auction->zixun_cost=$zixun_cost;
                    $auction->arrive_cost=$arrive_cost;
                    $auction->date_tag=$date_tag;
                    $bool=$auction->save();
                }
                return redirect()->route('auctions.index')->with('success','导入完成!');
            }
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
