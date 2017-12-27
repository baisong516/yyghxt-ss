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

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-auctions')){
            $start=$request->input('searchDateStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay():Carbon::now()->startOfDay();
            $end=$request->input('searchDateEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay():Carbon::now()->endOfDay();
            $data=Auction::getAuctionData($start,$end);
            return view('auction.read',[
                'pageheader'=>'竞价部',
                'pagedescription'=>'报表',
                'auctions'=>$data['auctions'],
                'total'=>$data['total'],
                'platforms'=>Aiden::getAllModelArray('platforms'),
                'areas'=>Aiden::getAllModelArray('areas'),
                'diseases'=>Aiden::getAllModelArray('diseases'),
                'start'=>$start,
                'end'=>$end,
//                'enableUpdate'=>Auth::user()->ability('superadministrator', 'update-areas'),
//                'enableDelete'=>Auth::user()->ability('superadministrator', 'delete-areas'),
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
