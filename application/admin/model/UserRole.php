<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 用户角色模型
 * User: Administrator
 * Date: 2019/3/14 0014
 * Time: 下午 10:52
 */
class UserRole extends Model
{
    /**
     * 根据用户ID获取用户角色
     * @param $userId
     * @return array|false|\PDOStatement|string|Model
     */
    function getRoleByUserId($userId)
    {
        return $this->where('user_id', $userId)->column('role_id');
    }

}