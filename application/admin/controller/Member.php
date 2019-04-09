<?php
namespace app\admin\controller;

use app\admin\model\Member as MemberModel;

/**
 * 会员管理
 * Member: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Member extends Controller
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
            $keyword = input('keyword');
            $map = array();
            if($keyword){
                $map['member_name'] = array('like', '%'.$keyword.'%');
            }
            $model = new MemberModel;
            $list = $model->getList($map, $page, $limit);
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
            $data = MemberModel::detail($id);
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
            ['member_name','require|max:25','会员名不能为空|会员名最多不能超过25个字符'],
            ['phone','regex:/^1[34578]{1}[0-9]{9}$/','手机格式错误'],
            ['email','email','邮箱格式错误'],
            ['address','max:50','地址最多不能超过50字符']
        ];
        $this->checkValidate($rule, $post);
        $model = new MemberModel;
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
        $model = MemberModel::detail($id);
        if(!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}