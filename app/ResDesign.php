<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OSS\Core\OssException;
use OSS\OssClient;

class ResDesign extends Model
{
    public static function getOssClient(){
        try {
            $ossClient = new OssClient(env('ACCESS_KEY_ID'), env('ACCESS_KEY_SECRET'), env('ENDPOINT'));
            return $ossClient;
        } catch (OssException $e) {
            return $e->getMessage();
        }
    }
    /**
     * 列出Bucket内所有目录和文件， 根据返回的nextMarker循环调用listObjects接口得到所有文件和目录
     * @param string $bucket 存储空间名称
     * @return null
     */
    public static function listAllObjects($bucket)
    {
        $dir = 'res';
        $ossClient=static::getOssClient();
        if (!$ossClient->doesObjectExist($bucket, $dir)){
            $ossClient->createObjectDir($bucket, $dir);
        }
        $prefix = 'res/';
        $delimiter = '/';
        $nextMarker = '';
        $maxkeys = 30;
        while (true) {
            $options = array(
                'delimiter' => $delimiter,
                'prefix' => $prefix,
                'max-keys' => $maxkeys,
                'marker' => $nextMarker,
            );
            try {
                $listObjectInfo = $ossClient->listObjects($bucket, $options);
            } catch (OssException $e) {
                printf(__FUNCTION__ . ": FAILED\n");
                printf($e->getMessage() . "\n");
                return;
            }
            // 得到nextMarker，从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
            $nextMarker = $listObjectInfo->getNextMarker();
            $listObject = $listObjectInfo->getObjectList();
            $listPrefix = $listObjectInfo->getPrefixList();
            var_dump($listObject);
            var_dump($listPrefix);
            if ($nextMarker === '') {
                break;
            }
        }
    }
}
