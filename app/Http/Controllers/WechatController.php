<?php

namespace App\Http\Controllers;

use App\Wechat;
use GuzzleHttp\Client;
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
        $accessToken=$this->getAccessToken();

    }

    private function checkSignature($request)
    {
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $token =Wechat::getToken();
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

    private function getAccessToken()
    {
        //https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
        $client = new Client();
        $appid=Wechat::getAppid();
        $secret=Wechat::getSecret();
        $response = $client->request('GET', 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret);
        dd($response);
    }

}
