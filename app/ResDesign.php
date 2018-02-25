<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ResDesign extends Model
{
    //获取所有文件和目录的数组
    public static function getListArray()
    {
        $dirs=Storage::disk('oss')->allFiles();
        return $dirs;
    }
}
