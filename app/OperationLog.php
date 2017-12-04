<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    protected $table = 'operations';
    protected $fillable = ['user_id', 'path', 'method', 'ip', 'input'];
    public static $methodColors = [
        'GET'       => 'green',
        'POST'      => 'yellow',
        'PUT'       => 'blue',
        'DELETE'    => 'red',
    ];

    public static $methods = [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH', 'LINK', 'UNLINK', 'COPY', 'HEAD', 'PURGE',
    ];

    public function getmethodcolor($method){
        return static::$methodColors[$method];
    }
}
