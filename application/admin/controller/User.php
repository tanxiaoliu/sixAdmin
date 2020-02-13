<?php
namespace app\admin\controller;

use app\admin\model\User as UserModel;
use app\admin\model\Role as RoleModel;

/**
 * 用户管理
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class User extends Controller
{
    /**
     * 列表
     * @return mixed|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function lists(UserModel $model)
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
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function add(RoleModel $roleModel)
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $roleList = $roleModel->getRoleByStatus();
            return $this->fetch('add', compact('roleList'));
        }
    }

    /**
     * 编辑
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    function edit(RoleModel $roleModel)
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $id = input('id');
            $data = UserModel::detail($id);
            $roleList = $roleModel->getRoleByStatus();
            return $this->fetch('edit', compact('data', 'roleList'));
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
            ['project_name','require|max:25','项目名称不能为空|项目名称最多不能超过25个字符'],
            ['member_id','require','会员不能为空'],
            ['cover','require','项目封面不能为空'],
            ['path','require','项目路径不能为空']
        ];
        $this->checkValidate($rule, $post);
        $model = new UserModel;
        $id = isset($post['id']) ? $post['id'] : '';
        //判断超级管理员
        if($id == 1){
            return ajax_return(1, '没有权限操作');
        }
        //检验账号
        if($model->checkUserName($post['user_name'], $id)){
            return ajax_return(1, '保存失败,账号重复');
        }
        //验证密码
        if($post['password']){
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        } else {
            unset($post['password']);
        }
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
        //判断超级管理员
        if($id == 1){
            return ajax_return(1, '没有权限操作');
        }
        $model = UserModel::detail($id);
        if(!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}