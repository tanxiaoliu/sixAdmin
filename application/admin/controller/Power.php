<?php
namespace app\admin\controller;

use think\Validate;

/**
 * 权限管理
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Power extends Controller
{
    /**
     * 权限列表
     * @return \think\response\View
     */
    function lists()
    {
        return view();
    }

    /**
     * 获取权限列表数据
     * @return \think\response\Json
     */
    function getList()
    {
        $page = input('page', 0);
        $limit = input('limit', 20);
        $map = array();
        $data = model('Power')->getList($map, $page, $limit);
        $count = model('Power')->countList($map);
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
            $data = model('Power')->find($id);
        }
        $this->assign('data', $data);
        return view();
    }

    /**
     * 权限新增、编辑操作
     * @return \think\response\View
     */
    function save()
    {
        $rule = [
            ['power_name','require','权限名称不能为空'],
            ['uri','require','uri名称不能为空'],
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
        $result = model('Power')->save($post, $map);
        if ($result) {
            return ajax_return(0, '保存成功', 'lists');
        } else {
            return ajax_return(1, '保存失败');
        }
    }

    /**
     * 删除权限
     * @return \think\response\Json
     */
    function delete()
    {
        $id = input('id' );
        $result = model('Power')->deleteById($id);
        if($result) {
            return ajax_return(0, '删除成功');
        } else {
            return ajax_return(1, '删除失败');
        }
    }

}