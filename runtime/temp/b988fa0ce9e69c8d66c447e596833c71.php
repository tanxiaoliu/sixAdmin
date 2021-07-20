<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"D:\phpstudy_pro\WWW\sixAdmin\public/../application/admin/view/login/index.html";i:1579057131;s:70:"D:\phpstudy_pro\WWW\sixAdmin\application\admin\view\public\header.html";i:1578966310;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $admin['name']; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/css/admin.css" media="all">
    <link rel="stylesheet" href="/static/admin/css/login.css" media="all">
    <script src="/static/layui/layui.js"></script>
    <script src="/static/layui/jquery.min.js"></script>
    <script src="/static/admin/js/index.js"></script>
</head>

<body class="layui-layout-body">
<div id="LAY_app">
    <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
        <div class="layadmin-user-login-main" style="margin-top: 90px;">
            <div class="layadmin-user-login-box layadmin-user-login-header">
                <h2><?php echo $admin['name']; ?></h2>
                <!--<p>XX管理平台</p>-->
            </div>
            <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                <div class="layui-form-item">
                    <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="user_name"></label>
                    <input type="text" name="user_name" id="user_name" lay-verify="required" placeholder="用户名" class="layui-input" value="<?php echo (isset($username) && ($username !== '')?$username:''); ?>">
                </div>
                <div class="layui-form-item">
                    <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="password"></label>
                    <input type="password" name="password" id="password" lay-verify="required" placeholder="密码" class="layui-input" value="">
                </div>
                <div class="layui-form-item">
                    <div class="layui-row">
                        <div class="layui-col-xs7">
                            <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="captcha"></label>
                            <input type="text" name="captcha" id="captcha" lay-verify="required" placeholder="图形验证码" class="layui-input">
                        </div>
                        <div class="layui-col-xs5">
                            <div style="margin-left: 10px;">
                                <img src="<?php echo url('admin/login/captcha'); ?>" alt="captcha" class="layadmin-user-login-codeimg" id="verify_img" onclick="refreshVerify()">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 20px;">
                    <input type="checkbox" name="remember" id="remember" lay-skin="primary" title="记住账号" checked="checked"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>记住密码</span><i class="layui-icon"></i></div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login-submit" id="loginSubmit">登 录</button>
                </div>
            </div>
        </div>

        <div class="layui-trans layadmin-user-login-footer">
            <p>Copyright © 2019-2025 <a href="<?php echo $admin['url']; ?>" target="_blank"><?php echo $admin['company']; ?></a></p>
        </div>

    </div>
</div>
<script>
    //从子页跳出
    if (window != top){
        top.location.href = location.href;
    }

    //验证码刷新
    function refreshVerify() {
        $('#verify_img').attr("src", "<?php echo url('admin/login/captcha'); ?>");
    }

    //enter提交登录
    $("body").keydown(function() {
        if (event.keyCode == "13") {
            $('#loginSubmit').click();
        }
    });

    //提交登录
    $('#loginSubmit').click(function(){
        var user_name = $.trim($('#user_name').val());
        if (!user_name) {
            layer.msg('请填写登录账号', {icon: 2, time : 1500});
            return false;
        }
        var password = $.trim($('#password').val());
        if (!password) {
            layer.msg('请填写密码', {icon: 2, time : 1500});
            return false;
        }
        var captcha = $.trim($('#captcha').val());
        if (!captcha) {
            layer.msg('请填写验证码', {icon: 2, time : 1500});
            return false;
        }
        var remember = $('#remember').is(':checked');
        remember = remember === true ? 1 : 0;
        $.ajax({
            type:'POST',
            url:'<?php echo url("admin/login/index"); ?>',
            dataType:'json',
            data:{
                user_name: user_name,
                password: password,
                captcha: captcha,
                remember:remember
            },
            success:function(data){
                if(data.code == 0){
                    layer.msg(data.msg, {icon: 6,time:1000}, function(index){
                        layer.close(index);
                        window.location.href = data.url;
                    });
                } else{
                    refreshVerify();
                    $('#captcha').val('');
                    layer.msg(data.msg, {icon: 2, time : 1500});
                }
            },
            error:function(jqXHR){
                layer.msg('登录失败', {icon: 2, time : 1500});
            }
        });
    });
</script>
</body>
</html>

