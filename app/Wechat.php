<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    private static $appid='wx721ef49077cecf22';// AppID
    private static $secret='1edc12b639f8af7cd07eb873e097e0fb';// AppSecret
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
