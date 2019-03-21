<?php
namespace app\admin\controller;

use think\Validate;

/**
 * 项目管理
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Project extends Controller
{
    /**
     * 项目列表
     * @return \think\response\View
     */
    function lists()
    {
        return view();
    }

    /**
     * 获取项目列表数据
     * @return \think\response\Json
     */
    function getList()
    {
        $page = input('page', 0);
        $limit = input('limit', 20);
        $searchType = input('search_type', 0);
        $keyword= input('keyword');
        $map = array();
        if($keyword){
            if($searchType == 0) {
                $map['a.project_name'] = array('like', '%' . $keyword . '%');
            } else {
                $map['b.member_name'] = array('like', '%' . $keyword . '%');
            }
        }
        $data = model('Project')->getList($map, $page, $limit);
        $count = model('Project')->countList($map);
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
            $data = model('Project')->find($id);
        }
        $memberList = model('Member')->getMemberList();
        $this->assign('memberList', $memberList);
        $this->assign('data', $data);
        return view();
    }

    /**
     * 项目新增、编辑操作
     * @return \think\response\View
     */
    function save()
    {
        $rule = [
            ['project_name','require|max:25','项目名称不能为空|项目名称最多不能超过25个字符'],
            ['member_id','require','会员不能为空'],
            ['cover','require','项目封面不能为空'],
            ['path','require','项目路径不能为空']
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
        $result = model('Project')->save($post, $map);
        if ($result) {
            return ajax_return(0, '保存成功', 'lists');
        } else {
            return ajax_return(1, '保存失败');
        }
    }

    /**
     * 删除项目
     * @return \think\response\Json
     */
    function delete()
    {
        $id = input('id' );
        $result = model('Project')->deleteById($id);
        if($result) {
            return ajax_return(0, '删除成功');
        } else {
            return ajax_return(1, '删除失败');
        }
    }

    /**
     * 上传项目封面
     * @return \think\response\Json
     */
    function upload()
    {
        $file = request()->file('file');
        $path = ROOT_PATH . 'public' . DS . 'static/uploads/project/';
        $info = $file->validate(['size'=>156780,'ext'=>'jpg,png,gif'])->move( $path);
        if($info){
            return ajax_return(0, '上传成功',  '/uploads/project/'.$info->getSaveName());
        }else{
            return ajax_return(1, $file->getError());
        }
    }
}