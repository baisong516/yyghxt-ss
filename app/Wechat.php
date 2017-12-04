<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    private static $appid='wx05870b92430fc13c';// AppID
    private static $secret='e0c43637771e20f1724527773b001799';// AppSecret
    private static $token='gzysyy';

    /**
     * @return string
     */
    public static function getAppid()
    {
        return static::$appid;
    }

    /**
     * @return string
     */
    public static function getSecret()
    {
        return static::$secret;
    }

    /**
     * @return string
     */
    public static function getToken()
    {
        return static::$token;
    }// Token



}
