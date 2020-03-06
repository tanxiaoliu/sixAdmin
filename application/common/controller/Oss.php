<?php

namespace app\common\controller;

use OSS\OssClient;
use OSS\Core\OssException;

//阿里云对象存储类
class Oss
{

  /**
   * 上传文件
   */
  static function uploadFile($object, $filePath, $bucket = 'yuleji')
  {
    try {
      $ossClient = new OssClient(config('oss.AccessKeyID'), config('oss.AccessKeySecret'), config('oss.endpoint'));
      $res = $ossClient->uploadFile($bucket, $object, $filePath);
      // dump($res['info']['url']);
    } catch (OssException $e) {
      printf(__FUNCTION__ . ": FAILED\n");
      printf($e->getMessage() . "\n");
      return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
  }
}
