<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function index(Request $request)
    {
        $echoStr=$request->input('echostr');
        if($echoStr){
            if($this->checkSignature($request)){
                echo $echoStr;
                exit;
            }
        }

        //responseMsg

    }

    private function checkSignature($request)
    {
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $token = 'gzysyy';
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule  字典序排序
        sort($tmpArr, SORT_STRING);
        //|拼接
        $tmpStr = implode( $tmpArr );
        //|sha1加密
        $tmpStr = sha1( $tmpStr );
        //|判断是否相等
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
