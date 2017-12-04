<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    private static $appid='wx110530c920ff4de6';// AppID
    private static $secret='a22459cc675a1f3cc5c6fdc3bcb82546';// AppSecret
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
