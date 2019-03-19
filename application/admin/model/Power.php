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
//    protected $deleteTime = 'delete_time';
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
     * @param $userId
     * @param bool $status
     * @return array
     */
    function getMenuByUserId($userId, $status = false)
    {
        $roleIds = model('UserRole')->getRoleByUserId($userId);
        $authority = $this->getTreeList();
        //获取对应角色的id
//        if ($status == false) {
//            $result = db('role_power')->where('role_id', $roleId)->select();
//            $oneIds = array();
//            $ids = array();
//            foreach ($result as $key => $value) {
//                $oneIds[] = $this->where('id', $value['power_id'])->value('parent_id');
//                $ids[] = $value['power_id'];
//            }
//            $oneIds = array_unique($oneIds);
//
//            foreach ($authority as $key => $value) {
//                if (!in_array($value['id'], $oneIds)) {
//                    unset($authority[$key]);
//                }
//                foreach ($value['navlist'] as $k => $v) {
//                    if (!in_array($v['id'], $ids)) {
//                        unset($authority[$key]['navlist'][$k]);
//                    }
//                }
//            }
//        }
        return array_values($authority);
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