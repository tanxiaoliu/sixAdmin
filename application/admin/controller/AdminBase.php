<?php
/**
 * 后台主控
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:58
 */

namespace app\admin\controller;

use think\Controller;

class AdminBase extends Controller
{
    function _initialize()
    {
        parent::_initialize();
        $session_admin_id = session('ADMIN_ID');
        if (!empty($session_admin_id)) {
            if (!$this->checkAccess($session_admin_id)) {
                $this->error("您没有访问权限！");
            }
        } else {
            if (request()->isPost()) {
                $this->error("您还没有登录！", url("admin/login/index"));
            } else {
                header("Location:" . url("admin/login/index"));
                exit();
            }
        }
    }

    /**
     * 检查后台用户访问权限
     * @param $userId
     * @return bool
     */
    private function checkAccess($userId)
    {
        // 如果用户id是1，则无需判断
        if ($userId == 1) {
            return true;
        }
    }
}