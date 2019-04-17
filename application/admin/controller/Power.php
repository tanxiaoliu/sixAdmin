<?php
namespace app\admin\controller;

use app\admin\model\Power as PowerModel;
use app\admin\model\Role as RoleModel;

/**
 * 权限管理
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Power extends Controller
{
    /**
     * 列表
     * @return mixed|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function lists()
    {
        if (request()->isAjax()) {
            $model = new PowerModel;
            $list = $model->getList('','sort asc');
            return ajax_list($list);
        } else {
            return $this->fetch();
        }
    }

    /**
     * 添加
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    function add()
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $model = new PowerModel;
            $menu = $model->getOneMenu('', 'sort asc');
            return $this->fetch('add', compact('menu'));
        }
    }

    /**
     * 编辑
     * @return array|mixed|\think\response\Json
     * @throws \think\exception\DbException
     */
    function edit()
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $id = input('id');
            $data = PowerModel::detail($id);
            $model = new PowerModel;
            $menu = $model->getOneMenu('', 'sort asc');
            return $this->fetch('edit', compact('data','menu'));
        }
    }

    /**
     * 新增、编辑操作
     * @param $post
     * @return array
     * @throws \think\exception\DbException
     */
    function save($post)
    {
        $rule = [
            ['power_name','require','权限名称不能为空'],
            ['uri','require','uri名称不能为空'],
        ];
        $this->checkValidate($rule, $post);
        $model = new PowerModel;
        $id = isset($post['id']) ? $post['id'] : '';
        if (!$model->edit($id, $post)) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }

    /**
     * 删除操作
     * @param $id
     * @return array
     * @throws \think\exception\DbException
     */
    function delete($id)
    {
        $model = PowerModel::detail($id);
        if(!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 分配权限
     * @param $id
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function allot($id)
    {
        $model = new PowerModel;
        $list = $model->getPowerZTreeByRoleId($id);
        return $this->fetch('allot', compact('list', 'id'));
    }

    /**
     * 更新规则
     * @return array
     * @throws \think\exception\DbException
     */
    public function updatePower()
    {
        $post = $this->postData('post');
        $post['power_ids'] = is_array($post['power_ids']) ? implode(',', $post['power_ids']) : '';
        $roleModel = new RoleModel;
        if (!$post['id']) {
            return $this->renderError('操作失败，角色ID不能为空');
        }
        if (!$roleModel->edit($post['id'], $post)) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }

}