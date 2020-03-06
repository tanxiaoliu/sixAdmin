<?php

namespace app\common\controller;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

//短信发送类
class Sms
{

  /**
   * 发送验证码短信
   */
  static function sendSms($phone, $signName = '立宇泰', $template = 'SMS_184816354')
  {
    try {

      //短信数据
      $data['PhoneNumbers'] = $phone;
      $data['SignName'] = $signName;
      $data['TemplateCode'] = $template;
      $code = rand(1000, 9999); //验证码
      $data['TemplateParam'] = json_encode(['code' => $code]);

      //发送数据
      AlibabaCloud::accessKeyClient(config('sms.AccessKeyID'), config('sms.AccessKeySecret'))->regionId('cn-hangzhou')->asDefaultClient();
      $msg['query'] = $data;
      $result = AlibabaCloud::rpc()
        ->product('Dysmsapi')
        // ->scheme('https') // https | http
        ->version('2017-05-25')
        ->action('SendSms')
        ->method('POST')
        ->host('dysmsapi.aliyuncs.com')
        ->options($msg)
        ->request();
      $res = $result->toArray();
      if ($res['Message'] != 'OK') {
        $data['status'] = 0; //标记状态失败
      }

      //数据入库
      $data['create_time'] = time();
      dump($res);

    } catch (ClientException $exception) {
      print_r($exception->getErrorMessage());
    } catch (ServerException $exception) {
      print_r($exception->getErrorMessage());
    }
  }
}
