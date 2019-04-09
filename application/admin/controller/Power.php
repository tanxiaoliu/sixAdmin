<?php
namespace app\admin\controller;

use app\admin\model\Power as PowerModel;

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
            $page = input('page', 1);
            $limit = input('limit', 20);
            $model = new PowerModel;
            $list = $model->getList('', $page, $limit);
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
            return $this->fetch();
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
            return $this->fetch('edit', compact('data'));
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

}