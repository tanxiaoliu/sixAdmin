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
class Projectview extends Model
{
    use SoftDelete;
    protected $table = 'k_project_view';
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;

    /**
     * 获取列表
     * @param array $map
     * @param int $page
     * @param int $limit
     * @param string $order
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getList($map = array(), $page = 1, $limit = 20, $order = 'id desc')
    {
        $list['count'] = $this->where($map)->count();
        $list['data'] = $this->where($map)->page($page, $limit)->order($order)->select();
        return $list;
    }

    /**
     * 获取详情
     * @param $id
     * @return Member|null
     * @throws \think\exception\DbException
     */
    public static function detail($id)
    {
        return self::get($id);
    }

    /**
     * 新增、编辑
     * @param $id
     * @param $values
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($id, $values)
    {
        $model = self::detail($id) ?: $this;
        return $model->save($values) !== false;
    }

    /**
     * 删除
     * @return int
     */
    public function remove()
    {
        return $this->delete();
    }

}