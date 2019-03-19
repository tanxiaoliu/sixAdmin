<?php
namespace app\admin\controller;

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
        $map = array();
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
        $this->assign('data', $data);
        return view();
    }

    /**
     * 项目新增、编辑操作
     * @return \think\response\View
     */
    function save()
    {
        $post = $this->postData('post');
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