<?php

namespace App\Http\Controllers;

use App\ResDesign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use OSS\Core\OssException;
use OSS\OssClient;

class ResDesginController extends Controller
{
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-resources')){
            $lists = ResDesign::getList();
            return view('resource.read',[
                'pageheader'=>'企划',
                'pagedescription'=>'素材库',
                'lists'=>$lists,
                'upleveldir'=>'',
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }

    public function download(Request $request)
    {

    }

    public function search(Request $request)
    {
        if (Auth::user()->ability('superadministrator', 'read-resources')){
            $searchDir=$request->input('searchdir');
            $upleveldir='';
            $lists = ResDesign::getList($searchDir);
            if (!empty($searchDir)){
                $dirStr=trim($searchDir,'/');
                $dirArr=explode('/',$dirStr);
                array_filter($dirArr);array_pop($dirArr);
                $upleveldir=implode('/',$dirArr);
                if (!empty($upleveldir)){$upleveldir.='/';}
            }
            return view('resource.read',[
                'pageheader'=>'企划',
                'pagedescription'=>'素材库',
                'lists'=>$lists,
                'upleveldir'=>$upleveldir,
            ]);
        }
        return abort(403,config('yyxt.permission_deny'));
    }
}
