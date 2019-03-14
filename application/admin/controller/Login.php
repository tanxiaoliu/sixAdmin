<?php
/**
 * Created by PhpStorm.
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:58
 */

namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Cookie;

//后台登陆
class Login extends Controller
{

    /**
     * 登陆
     */
    function index(){
        if (request()->isPost()) {
            $username = trim(input('post.username'));
            $password = trim(input('post.password'));
            $captcha = input('post.captcha');
            $remember = input('post.remember');
            if (!captcha_check($captcha)) {
                $this->error('验证码不正确');
            }
            if (empty($username) || empty($password)) {
                $this->error('用户名或密码不能为空');
            }
            //查询用户
            $userInfo = [];
            if (empty($userInfo)) {
                $this->error('登录用户不存在');
            }
            if ($userInfo['state'] == 1) {
                $this->error('该用户已被禁止登录');
            }
            if (password_verify($password, $userInfo['password'])) {
                //设置登陆操作
                if (1) {
                    //记住密码7天
                    if ($remember == 1) {
                        Cookie::set('user_name', $username, 302400);
                    } else {
                        Cookie::clear('user_');
                    }
                    return $this->sucecss('登录成功', '/admin_bs/index/index');
                } else {
                    $this->error('登录失败');
                }
            } else {
                $this->error('您输入的密码不正确');
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