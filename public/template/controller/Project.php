<?php
namespace app\admin\controller;

use app\admin\model\Project as ProjectModel;

/**
 * 项目表
 */
class Project extends Controller
{
    /**
     * 列表
     */
    function lists(ProjectModel $model)
    {
        if (request()->isAjax()) {
            $page = input('page', 1);
            $limit = input('limit', 20);
            $list = $model->getList('', $page, $limit);
            return ajax_list($list);
        } else {
            return $this->fetch();
        }
    }

    /**
     * 添加
     */
    function add()
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            return $this->fetch('add');
        }
    }

    /**
     * 编辑
     */
    function edit()
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $id = input('id');
            $data = ProjectModel::detail($id);
            return $this->fetch('edit', compact('data'));
        }
    }

    /**
     * 保存
     */
    function save($post)
    {
        $model = new ProjectModel;
        $post['status'] = $post['status'] == 'on' ? 0 : 1;
        $id = isset($post['id']) ? $post['id'] : '';
        if (!$model->edit($id, $post)) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }

    /**
     * 删除
     */
    function delete($id)
    {
        $model = ProjectModel::detail($id);
        if(!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }


}