<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Cookie;
use think\Log;
use think\Session;
use app\admin\model\User as UserModel;

/**
 * 后台登录
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:58
 */
class Login extends Controller
{

    /**
     * 登陆
     * @return array|\think\response\View
     */
    function index(UserModel $userModel)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!captcha_check($post['captcha'])) {
                return $this->renderError('验证码不正确');
            }
            if (empty($post['user_name']) || empty($post['password'])) {
                return $this->renderError('账号或密码不能为空');
            }
            //查询用户
            $user = $userModel->getUserByUserName($post['user_name']);
            if (empty($user) || $user['status'] == 1) {
                return $this->renderError('登录失败, 账号或密码错误');
            }
            if (password_verify($post['password'], $user['password'])) {
                // 保存登录状态
                Session::set('admin_user', [
                    'user' => [
                        'user_id' => $user['id'],
                        'nickname' => $user['nickname'],
                    ]
                ]);
                //记住密码7天
                $post['remember'] == 1 ? Cookie::set('user_name', $post['user_name'], 302400) : Cookie::clear('user_');
                return $this->renderSuccess('登录成功', '/admin/index/index');
            } else {
                return $this->renderError('登录失败, 账号或密码错误');
            }
        } else {
            $userName = Cookie::get('user_name');
            if ($userName) {
                $this->assign('username', $userName);
            }
            return view();
        }
    }

    /**
     * 退出登录
     */
    function logout()
    {
        Session::clear();
        $this->redirect('login/index');
    }

    /**
     * 验证码
     * @return \think\Response
     */
    function captcha()
    {
        ob_clean();
        $config = [
            'codeSet' => '0123456789',
            'length' => 4
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    /**
     * GRPC测试
     */
    function grpc()
    {
        //echo 'GRPC调用测试'.date('Y-m-d H:i:s');
        echo json_encode($_POST);
    }
}
