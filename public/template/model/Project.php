<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 项目表
 */
class Project extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;

    /**
     * 获取列表
     */
    function getList($map = array(), $page = 1, $limit = 20, $order = 'id desc')
    {
        $list['count'] = $this->where($map)->count();
        $list['data'] = $this->where($map)->page($page, $limit)->order($order)->select();
        return $list;
    }

    /**
     * 获取详情
     */
    public static function detail($id)
    {
        return self::get($id);
    }

    /**
     * 保存
     */
    public function edit($id, $values)
    {
        $model = self::detail($id) ?: $this;
        return $model->save($values) !== false;
    }

    /**
     * 删除
     */
    public function remove()
    {
        return $this->delete();
    }

}