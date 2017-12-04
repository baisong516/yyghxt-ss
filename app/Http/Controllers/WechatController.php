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
        $this->setMenus();//自定义菜单
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
        $token=Token::where('app_id',$appid)->first();
        if (!$token){
            $token=new Token();
        }
        $token->app_id=$appid;
        $token->token=$access_token;
        $token->expires=$expires;
        $token->save();
        return $access_token;
    }

    //自定义菜单
    private function setMenus()
    {
        $menu=[
            'button'=>[
                ["name"=>"掌上益寿","sub_button"=>[
                    ["type"=>"view","name"=>"医院简介","url"=>"http://4g.22356666.com/yyjj/"],
                    ["type"=>"view","name"=>"权威专家","url"=>"http://4g.22356666.com/team/"],
                    ["type"=>"view","name"=>"权威疗法","url"=>"http://4g.22356666.com/qwjs/"],
                    ["type"=>"view","name"=>"病友分享","url"=>"http://4g.22356666.com/swt/"],
                    ["type"=>"view","name"=>"来院路线","url"=>"http://4g.22356666.com/lylx/"],
                ]],
                ["name"=>"疾病自测","sub_button"=>[
                    ["type"=>"view","name"=>"失眠症自测","url"=>"http://4g.22356666.com/sm/"],
                    ["type"=>"view","name"=>"抑郁症自测","url"=>"http://4g.22356666.com/yy/"],
                    ["type"=>"view","name"=>"焦虑症自测","url"=>"http://4g.22356666.com/jl/"],
                    ["type"=>"view","name"=>"精神分裂","url"=>"http://4g.22356666.com/jsfl/"],
                    ["type"=>"view","name"=>"心理测试","url"=>"http://4g.22356666.com/swt/"],
                ]],
                ["name"=>"便民服务","sub_button"=>[
                    ["type"=>"view","name"=>"在线预约","url"=>"http://4g.22356666.com/swt/"],
                    ["type"=>"view","name"=>"自助挂号","url"=>"http://4g.22356666.com/swt/"],
                    ["type"=>"view","name"=>"电话问诊","url"=>"http://4g.22356666.com/jl/"],
                    ["type"=>"view","name"=>"最新援助","url"=>"http://4g.22356666.com/swt/"],
                    ["type"=>"view","name"=>"免费WIFI","url"=>"http://4g.22356666.com/swt/"],
                ]],
            ],
        ];
        $menu=json_encode($menu,JSON_UNESCAPED_UNICODE);
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getAccessToken();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $menu);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}
