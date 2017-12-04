<?php

namespace App\Http\Controllers;

use App\Token;
use App\Wechat;
use Carbon\Carbon;
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
        //dd($accessToken);
        $this->setMenus();

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
        //公众号调用接口都不能超过一定限制 access_token 过期时间 应存入数据库
        $appid = Wechat::getAppid();
        $token=Token::where('app_id',$appid)->first();
        if (!empty($token)&&$token->expires>=Carbon::now()){
            return $token->token;
        }
        $this->flushToken();
    }

    private function flushToken()
    {
        $appid=Wechat::getAppid();
        $appsecret = Wechat::getSecret();
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsoninfo = json_decode($output, true);
        $access_token = $jsoninfo["access_token"];//token值
        $expires_in=$jsoninfo["expires_in"]-30;//过期时间
        $expires=Carbon::now()->addSeconds($expires_in);//token在此之前有效
        $token=new Token();
        $token->app_id=$appid;
        $token->token=$access_token;
        $token->expires=$expires;
        $token->save();
        return $access_token;
    }

    private function setMenus()
    {
       $menu=[
           'button'=>[
               ["type"=>"click","name"=>"今日歌曲","key"=>"V1001_TODAY_MUSIC"],
               ["name"=>"菜单","sub_button"=>[
                   ["type"=>"view","name"=>"搜索","url"=>"http://www.soso.com/"],
                   ["type"=>"miniprogram","name"=>"wxa","url"=>"http://mp.weixin.qq.com","appid"=>"wx286b93c14bbf93aa","pagepath"=>"pages/lunar/index"],
                   ["type"=>"click","name"=>"赞一下我们","key"=>"V1001_GOOD"],
               ]],
           ],
       ];
       $menu=json_encode($menu);
       dd($menu);
    }

}
