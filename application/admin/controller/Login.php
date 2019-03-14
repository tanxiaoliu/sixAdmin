<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Cookie;
use think\Session;

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
     * @return \think\response\View
     */
    function index()
    {
        if ($this->request->isPost()) {
            $post = $this->postData('User');
            if (!captcha_check($post['captcha'])) {
                $this->error('验证码不正确');
            }
            if (empty($post['username']) || empty($post['password'])) {
                $this->error('用户名或密码不能为空');
            }
            //查询用户
            $user = [];
            if (empty($user) || $user['state'] == 1) {
                $this->error('登录失败, 用户名或密码错误');
            }
            if (password_verify($post['password'], $user['password'])) {
                //设置登陆操作
                if (1) {
                    // 保存登录状态
                    Session::set('admin_user', [
                        'user' => [
                            'user_id' => $user['id'],
                            'user_name' => $user['user_name'],
                        ],
                        'is_login' => true,
                    ]);
                    //记住密码7天
                    $post['remember'] == 1 ? Cookie::set('user_name', $user['user_name'], 302400) : Cookie::clear('user_');
                    $this->success('登录成功', '/admin_bs/index/index');
                } else {
                    $this->error('登录失败');
                }
            } else {
                $this->error('登录失败, 用户名或密码错误');
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
        Session::clear('admin_user');
        $this->redirect('login/index');
    }

    /**
     * 验证码
     * @return \think\Response
     */
    function captcha()
    {
        $config = [
            'codeSet' => '0123456789',
            'length' => 4
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
}