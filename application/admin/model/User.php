<?php
namespace app\admin\model;

use think\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/14 0014
 * Time: 下午 10:52
 */
class User extends Model
{

    /**
     * 获取列表信息
     * @param $map
     * @param string $field
     * @return false|\PDOStatement|string|\think\Collection
     */
    function lists($map, $field = '*')
    {
        return $this->where($map)->field($field)->select();
    }

    /**
     * 根据用户ID获取用户
     * @param $userId
     * @return array|false|\PDOStatement|string|Model
     */
    function getUserByUserId($userId)
    {
        return $this->where('id', $userId)->field('id, nickname, user_name, status')->find();
    }

    /**
     * 根据用户名获取用户信息
     * @param $userName
     * @return array|false|\PDOStatement|string|Model
     */
    function getUserByUserName($userName){
        return $this->where('user_name', $userName)->field('id, nickname, password, status')->find();
    }

}