<?php

namespace App\Http\Controllers;

use App\Aiden;
use App\JjOutput;
use App\ZxOutput;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OutputController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $start=Carbon::now()->startOfDay();
        $end=Carbon::now()->endOfDay();
        $zxoutputs=ZxOutput::getZxOutputs($start,$end);
        $jjoutputs=JjOutput::getJjOutputs($start,$end);
        return view('output.read',[
            'pageheader'=>'产出',
            'pagedescription'=>'产出表',
            'users'=>Aiden::getAllUserArray(),
            'zxoutputs'=>$zxoutputs,
            'jjoutputs'=>$jjoutputs,
        ]);
    }

    public function search(Request $request)
    {
        $date=$request->input('searchDate');
        $start=$date?Carbon::createFromFormat('Y-m-d',$date)->startOfDay():Carbon::now()->startOfDay();
        $end=$date?Carbon::createFromFormat('Y-m-d',$date)->endOfDay():Carbon::now()->endOfDay();
        $zxoutputs=ZxOutput::getZxOutputs($start,$end);
        $jjoutputs=JjOutput::getJjOutputs($start,$end);
        return view('output.read',[
            'pageheader'=>'产出',
            'pagedescription'=>'产出表',
            'users'=>Aiden::getAllUserArray(),
            'start'=>$start,
            'end'=>$end,
            'zxoutputs'=>$zxoutputs,
            'jjoutputs'=>$jjoutputs,
        ]);
    }
}
