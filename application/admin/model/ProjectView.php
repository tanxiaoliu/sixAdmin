<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 项目页面模型.
 * ProjectView: Administrator
 * Date: 2019/3/14 0014
 * Time: 下午 10:52
 */
class ProjectView extends Model
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
     * 根据ID删除
     * @param $id
     * @return int
     */
    function deleteById($id)
    {
        return self::destroy($id);
    }

}