<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ResDesign extends Model
{
    //获取指定目录下的子目录和文件
    public static function getListArray($directory=null)
    {
        //文件
        $files=Storage::disk('oss')->files($directory);
        //目录
        $dirs=Storage::disk('oss')->directories($directory);
        return [
            'dirs'=>$dirs,
            'files'=>$files,
        ];
    }
}
