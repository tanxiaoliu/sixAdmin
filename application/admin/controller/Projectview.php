<?php
namespace app\admin\controller;

use think\Validate;

/**
 * 项目页面管理
 * Projectview: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Projectview extends Controller
{
    /**
     * 项目页面列表
     * @return \think\response\View
     */
    function lists()
    {
        return view();
    }

    /**
     * 获取项目页面列表数据
     * @return \think\response\Json
     */
    function getList()
    {
        $page = input('page', 0);
        $limit = input('limit', 20);
        $keyword = input('keyword');
        $map = array();
        if($keyword){
            $map['a.title'] = array('like', '%'.$keyword.'%');
        }
        $data = model('Projectview')->getList($map, $page, $limit);
        $count = model('Projectview')->countList($map);
        return ajax_list( $count,  $data);
    }

    /**
     * 添加、编辑页面
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function add()
    {
        $id = input('id');
        $data = array();
        if ($id) {
            $id = input('id');
            $data = model('Projectview')->find($id);
        }
        $memberList = model('Member')->getMemberList();
        $this->assign('memberList', $memberList);
        $this->assign('data', $data);
        return view();
    }

    /**
     * 项目页面新增、编辑操作
     * @return \think\response\View
     */
    function save()
    {
        $rule = [
            ['title','require|max:25','标题名称不能为空|标题名称最多不能超过25个字符'],
            ['project_ids','require','项目不能为空']
        ];
        $validate = new Validate($rule);
        $post = $this->postData('post');
        if(!$validate->check($post)){
            return ajax_return(1, $validate->getError());
        }
        $id = input('id');
        $map = array();
        if($id) {
            $map['id'] = $id;
        }
        $result = model('Projectview')->save($post, $map);
        if ($result) {
            return ajax_return(0, '保存成功', 'lists');
        } else {
            return ajax_return(1, '保存失败');
        }
    }

    /**
     * 删除项目页面
     * @return \think\response\Json
     */
    function delete()
    {
        $id = input('id' );
        $result = model('Projectview')->deleteById($id);
        if($result) {
            return ajax_return(0, '删除成功');
        } else {
            return ajax_return(1, '删除失败');
        }
    }

}