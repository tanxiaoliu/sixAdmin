<?php
namespace app\admin\controller;

use think\Session;

/**
 * 后台控制器基类
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:58
 */
class Controller extends \think\Controller
{
    /* @var array $store 后台用户登录信息 */
    protected $user;

    /* @var string $route 当前模块名称 */
    protected $module = '';

    /* @var string $route 当前控制器名称 */
    protected $controller = '';

    /* @var string $route 当前方法名称 */
    protected $action = '';

    /* @var string $route 当前路由uri */
    protected $routeUri = '';

    /* @var string $route 用户菜单 */
    protected $menus = '';

    /* @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'admin/Login/index',
        'admin/Login/logout',
        'admin/Login/captcha',
        'admin/Login/test',
    ];

    /**
     * 后台初始化
     */
    public function _initialize()
    {
        // 后台用户登录信息
        $this->user = Session::get('admin_user.user');
        // 当前路由信息
        $this->getRouteInfo();
        // 验证登录
        $this->checkAccess();
        $this->assign('menus', json_encode($this->menus));
        $this->assign('user', $this->user);
    }

    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteInfo()
    {
        // 模块名称
        $this->module = $this->request->module();
        // 控制器名称
        $this->controller = to_under_score($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 当前url
        $this->routeUri = $this->module . '/' . $this->controller . '/' . $this->action;
    }

    /**
     * 获取登录用户的后台菜单
     * @return array
     */
    private function menus()
    {
        $status = $this->user['user_id'] == 1 ? true : false;
        return model('Power')->getMenuByUserId($this->user['user_id'], $status);
    }

    /**
     * 验证后台用户登录
     */
    private function checkAccess()
    {
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }

        // 验证当前模块是否是admin
        if ($this->request->module() != 'admin' || !Session::has('admin_user')) {
            $this->redirect('Login/index');
            return false;
        }

        // 更新后台用户登录信息
//        $this->user = model('User')->getUserByUserId($this->user['user_id']);

        //获取用户菜单
        $this->menus = $this->menus();

        // 如果用户id是1，则无需判断
        if ($this->user['user_id'] == 1) {
            return true;
        } else {
            //判断用户的权限
            if (1) {
                dump($this->routeUri);
                return true;
            }
            $this->redirect('Login/index');
            return false;
        }
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(0, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }
}