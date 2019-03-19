<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 用户模型.
 * User: Administrator
 * Date: 2019/3/14 0014
 * Time: 下午 10:52
 */
class User extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;

    /**
     * 获取列表
     * @param array $map
     * @param int $page
     * @param int $limit
     * @param string $order
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getList($map = array(), $page = 1, $limit = 20, $order = 'id desc')
    {
        return $this->where($map)->page($page, $limit)->order($order)->select();
    }

    /**
     * 获取数量
     * @param array $map
     * @return int|string
     * @throws \think\Exception
     */
    public function countList($map = array())
    {
        return $this->where($map)->count();
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

    /**
     * 根据ID删除
     * @param $id
     * @return int
     */
    function deleteById($id)
    {
        return self::destroy($id);
    }

}