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
        $start=$request->input('searchDateStart')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateStart'))->startOfDay():Carbon::now()->startOfDay();
        $end=$request->input('searchDateEnd')?Carbon::createFromFormat('Y-m-d',$request->input('searchDateEnd'))->endOfDay():Carbon::now()->endOfDay();
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
