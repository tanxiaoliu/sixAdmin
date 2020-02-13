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
     * @param string $order
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getList($map = array(), $order = 'id desc')
    {
        $data = $this->where($map)->order($order)->select();
        $list['data'] = array2Level($data);
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
     * 获取一级菜单【后期缓存】
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getOneMenu()
    {
        $map['type'] = 0;
        $map['parent_id'] = 0;
        return $this->where($map)->order('sort')->select();
    }

    /**
     * 根据用户获取左侧权限菜单【后期缓存】
     * @param $userId
     * @param bool $status
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getMenuByUserId($userId, $status = false)
    {
        $data = db('user')->alias('a')
            ->field('b.power_ids')
            ->join('role b', 'a.role_id = b.id', 'left')
            ->where('a.id', $userId)->find();
        $powerArr = explode(',', $data['power_ids']);

        //获取树形菜单
        $map['type'] = 0;
        $map['parent_id'] = 0;
        $listOne = $this->where($map)->order('sort')->select();
        $authority = array();
        if ($listOne) {
            foreach ($listOne as $val) {
                if (in_array($val['id'], $powerArr) || $status) {
                    $one = array();
                    $one['navname'] = $val['power_name'];
                    $one['id'] = $val['id'];
                    $one['icon'] = $val['icon'];
                    $map['parent_id'] = $val['id'];
                    $listTwo = $this->where($map)->order('sort')->select();
                    if ($listTwo) {
                        foreach ($listTwo as $vl) {
                            if (in_array($vl['id'], $powerArr) || $status) {
                                $two['name'] = $vl['power_name'];
                                $two['id'] = $vl['id'];
                                $two['uri'] = $vl['uri'];
                                $one['navlist'][] = $two;
                            }
                        }
                    }
                    $authority[] = $one;
                }
            }
        }
        $data['menu'] = array_values($authority);
        $data['uri'] = $this->where('parent_id', 'neq', 0)->whereIn('id', $powerArr)->column('uri');
        return $data;
    }

    /**
     * 获取权限zTree数据类型，用于分配权限页面【后期缓存】
     * @param $roleId
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getPowerZTreeByRoleId($roleId)
    {
        $role = model('role')->find($roleId);
        $powerArr = explode(',', $role['power_ids']);
        $list = $this->field('id, power_name, parent_id')->select();
        foreach ($list as $key => $val) {
            in_array($val['id'], $powerArr) && $list[$key]['checked'] = true;
        }
        return json_encode($list);
    }

}