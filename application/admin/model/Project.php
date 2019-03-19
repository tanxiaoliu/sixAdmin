<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 项目模型
 * User: Administrator
 * Date: 2019/3/14 0014
 * Time: 下午 10:52
 */
class Project extends Model
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
    function getList($map = array(), $page = 1, $limit = 20, $order = 'a.id desc')
    {
        $result = $this->alias('a')
            ->field('a.*, b.member_name')
            ->join('member b', 'a.member_id = b.id', 'left')
            ->where($map)
            ->page($page, $limit)
            ->order($order)
            ->select();
        return $result;
    }

    /**
     * 获取数量
     * @param array $map
     * @return int|string
     * @throws \think\Exception
     */
    public function countList($map = array())
    {
        return $this->alias('a')
            ->field('a.*,b.user_name')
            ->join('member b','a.member_id = b.id', 'left')
            ->where($map)
            ->count();
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