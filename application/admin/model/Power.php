<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 权限模型
 * User: Administrator
 * Date: 2019/3/17 0017
 * Time: 下午 7:28
 */
class Power extends Model
{
    use SoftDelete;
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

    /**
     * 获取树形菜单列表
     * @return array
     */
    function getTreeList()
    {
        $map['type'] = 0;
        $map['parent_id'] = 0;
        $listOne = $this->where($map)->order('sort')->select();
        $list = array();
        if ($listOne) {
            foreach ($listOne as $val) {
                $one = array();
                $one['navname'] = $val['power_name'];
                $one['id'] = $val['id'];
                $one['icon'] = $val['icon'];
                $map['parent_id'] = $val['id'];
                $listTwo = $this->where($map)->order('sort')->select();
                if ($listTwo) {
                    foreach ($listTwo as $vl) {
                        $two['name'] = $vl['power_name'];
                        $two['id'] = $vl['id'];
                        $two['uri'] = $vl['uri'];
                        $one['navlist'][] = $two;
                    }
                }
                $list[] = $one;
            }
        }
        return $list;
    }

    /**
     * 根据角色获取权限回显
     * @param $roleId
     * @return array
     */
    function getPowerByRoleId($roleId)
    {
        $authority = $this->getTreeList();
        //获取对应角色的id
        $result = db('role_power')->where('role_id', $roleId)->select();
        $oneIds = array();
        $ids = array();
        foreach ($result as $key => $value) {
            $oneIds[] = $this->where('id', $value['power_id'])->value('parent_id');
            $ids[] = $value['power_id'];
        }
        $oneIds = array_unique($oneIds);

        foreach ($authority as $key => $value) {
            if (in_array($value['id'], $oneIds)) {
                $authority[$key]['status'] = 1;
            } else {
                $authority[$key]['status'] = 0;
            }
            foreach ($value['navlist'] as $k => $v) {
                if (in_array($v['id'], $ids)) {
                    $authority[$key]['navlist'][$k]['status'] = 1;
                } else {
                    $authority[$key]['navlist'][$k]['status'] = 0;
                }
            }
        }
        return $authority;
    }

    /**
     * 根据角色获取权限菜单
     * @param $roleId
     * @param bool $status
     * @return array
     */
    function getMenuByUserId($roleId, $status = false)
    {
        $authority = $this->getTreeList();
        //获取对应角色的id
        if ($status == false) {
            $result = db('role_power')->where('role_id', $roleId)->select();
            $oneIds = array();
            $ids = array();
            foreach ($result as $key => $value) {
                $oneIds[] = $this->where('id', $value['power_id'])->value('parent_id');
                $ids[] = $value['power_id'];
            }
            $oneIds = array_unique($oneIds);

            foreach ($authority as $key => $value) {
                if (!in_array($value['id'], $oneIds)) {
                    unset($authority[$key]);
                }
                foreach ($value['navlist'] as $k => $v) {
                    if (!in_array($v['id'], $ids)) {
                        unset($authority[$key]['navlist'][$k]);
                    }
                }
            }
        }
        return array_values($authority);
    }

}