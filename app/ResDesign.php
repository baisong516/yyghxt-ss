<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use OSS\Core\OssException;
use OSS\OssClient;

class ResDesign extends Model
{
    /**
     * 获取OssClient
     * @return OssClient|string
     */
    public static function getOssClicent()
    {
        try {
            $ossClient = new OssClient(env('ACCESS_KEY_ID'), env('ACCESS_KEY_SECRET'), env('ENDPOINT'));
            return $ossClient;
        } catch (OssException $e) {
            dd($e->getMessage());
        }
    }

    /**
     * 获取指定目录下的子目录和文件
     * @param null $prefix dir
     * @return array
     * @throws OssException
     */
    public static function getList($prefix=null)
    {
        $ossClient=static::getOssClicent();
        $delimiter = '/';
        $options = array(
            'delimiter' => $delimiter,
            'prefix' => $prefix,
        );
        try{
            $listObjectInfo=$ossClient->listObjects(env('BUCKET'),$options);
        }catch (OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            dd($e->getMessage() . "\n");
            return;
        }
        //目录
        $dirInfo=$listObjectInfo->getPrefixList();
        $dirs=[];
        if (!empty($dirInfo)){
            foreach ($dirInfo as $info){
                $dirs[]=$info->getPrefix();
            }
        }
        //文件
        $objInfo=$listObjectInfo->getObjectList();
        $files=[];
        if (!empty($objInfo)){
            foreach ($objInfo as $info){
                if ($info->getSize()>0){
                    $files[]=[
                        'name'=>$info->getKey(),
                        'size'=>$info->getSize(),
//                    'size'=>$info->getSize()>= 1048576?round($info->getSize() / 1048576 * 100) / 100 . ' M':round($info->getSize() / 1024 * 100) / 100 . ' K',
                        'lastModified'=>date('Y-m-d H:i:s', strtotime($info->getLastModified())),
                        'url'=>'http://'.env('BUCKET').'.'.env('ENDPOINT').'/'.$info->getKey(),
                    ];
                }

            }
        }
        return [
            'dirs'=>$dirs,
            'files'=>$files,
        ];
    }
}
