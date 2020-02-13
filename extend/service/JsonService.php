<?php
/**
 * 返回基类
 */

namespace service;


class JsonService
{
    private static $SUCCESSFUL_DEFAULT_MSG = '操作成功';

    private static $FAIL_DEFAULT_MSG = '操作失败';

    public static function result($code, $msg = '', $data = [])
    {
        exit(json_encode(compact('code', 'msg', 'data')));
    }

    public static function fail($msg = '操作失败', $data = [], $code = 1)
    {
        if (is_array($msg) || is_object($msg)) {
            $data = $msg;
            $msg = self::$FAIL_DEFAULT_MSG;
        }
        return self::result($code, $msg, $data);
    }

    public static function success($msg = '操作成功', $data = [])
    {
        if (is_array($msg) || is_object($msg)) {
            $data = $msg;
            $msg = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        return self::result(0, $msg, $data);
    }
}
