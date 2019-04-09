<?php
namespace app\admin\controller;

use app\admin\model\Projectview as ProjectviewModel;
use app\admin\model\Member as MemberModel;

/**
 * 项目页面管理
 * Projectview: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Projectview extends Controller
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
            $keyword= input('keyword');
            $map = array();
            if($keyword){
                $map['title'] = array('like', '%' . $keyword . '%');
            }
            $model = new ProjectviewModel;
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
    function add()
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $memberModel = new MemberModel;
            $memberList = $memberModel->getMemberList();
            return $this->fetch('add', compact('memberList'));
        }
    }

    /**
     * 编辑
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    function edit()
    {
        if (request()->isPost()) {
            return $this->save($this->postData('post'));
        } else {
            $id = input('id');
            $data = ProjectviewModel::detail($id);
            $memberModel = new MemberModel;
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
            ['title','require|max:25','标题名称不能为空|标题名称最多不能超过25个字符'],
            ['member_id','require','会员不能为空'],
            ['project_ids','require','项目不能为空']
        ];
        $this->checkValidate($rule, $post);
        $model = new ProjectviewModel;
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
        $model = ProjectviewModel::detail($id);
        if(!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}