<?php
namespace app\admin\model;

use think\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/14 0014
 * Time: 下午 10:52
 */
class UserModel extends Model
{
    /**
     * 用户信息
     * @param $user_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($user_id)
    {
        return self::get($user_id);
    }
}