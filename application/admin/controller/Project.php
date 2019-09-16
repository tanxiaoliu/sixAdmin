<?php
namespace app\admin\controller;

use app\admin\model\Project as ProjectModel;
use app\admin\model\Member as MemberModel;

/**
 * 项目管理
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Project extends Controller
{
    /**
     * 列表
     * @return mixed|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function lists(ProjectModel $model)
    {
        if (request()->isAjax()) {
            $page = input('page', 1);
            $limit = input('limit', 20);
            $projectName = input('project_name');
            $memberName = input('member_name');
            $map = array();
            if($projectName){
                $map['a.project_name'] = array('like', '%' . $projectName . '%');
            }
            if($memberName){
                $map['b.member_name'] = array('like', '%' . $memberName . '%');
            }
            $list = $model->getList($map, $page, $limit);
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
    function add(MemberModel $memberModel)
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $memberList = $memberModel->getMemberList();
            return $this->fetch('add', compact('memberList'));
        }
    }

    /**
     * 编辑
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    function edit(MemberModel $memberModel)
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $id = input('id');
            $data = ProjectModel::detail($id);
            $memberList = $memberModel->getMemberList();
            return $this->fetch('edit', compact('data', 'memberList'));
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
        $model = new ProjectModel;
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
        $model = ProjectModel::detail($id);
        if(!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 上传项目封面
     * @return array
     */
    function upload()
    {
        $file = request()->file('file');
        $path = ROOT_PATH . 'public' . DS . 'static/uploads/project/';
        $info = $file->validate(['size'=>156780,'ext'=>'jpg,png,gif'])->move( $path);
        if($info){
            return $this->renderSuccess('上传成功', '', '/uploads/project/'.$info->getSaveName());
        }
        return $this->renderError($file->getError());
    }
}
