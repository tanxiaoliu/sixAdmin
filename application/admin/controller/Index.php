<?php
namespace app\admin\controller;

/**
 * Created by PhpStorm.
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Index extends Controller
{
    /**
     * layout
     * @return \think\response\View
     */
    function index()
    {
        return view();
    }

    /**
     * 后台主页
     */
    function home()
    {
        return view();
    }
}