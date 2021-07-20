<?php

namespace app\index\controller;

use think\Db;

class Index
{

    public function index()
    {
        $tables = ['project'];
        foreach ($tables as $val) {
            $this->createHmtl($val);
        }
    }

    public function createHmtl($name = 'project',  $prefix = 'k_')
    {
        $tablename = $prefix . $name;
        $ucwordsname = ucwords($name);

        //查表
        $tablecomment = Db::query("SELECT TABLE_COMMENT AS comment  FROM information_schema.TABLES  WHERE table_name = '$tablename'");
        $table = Db::query("SELECT COLUMN_NAME AS field, COLUMN_COMMENT AS comment  FROM information_schema.COLUMNS  WHERE table_name = '$tablename'");

        // 整理表数据
        $addfrom = '';
        $editfrom = '';
        $listsfrom = '';
        foreach ($table as $val) {
            $field =  $val['field'];
            $comment =  $val['comment'];
            if (!in_array($field, ['id', 'create_time', 'update_time', 'delete_time'])) {
                $addfrom .= <<<EOF
                        <div class="layui-form-item">
                            <label class="layui-form-label">$comment</label>
                            <div class="layui-input-block">
                                <input type="text" name="$field" value="" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                    EOF;

                $value = '{$data.' . $field . "|default=''}";
                $editfrom .= <<<EOF
                    <div class="layui-form-item">
                        <label class="layui-form-label">$comment</label>
                        <div class="layui-input-block">
                            <input type="text" name="$field" value="$value" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    EOF;

                $listsfrom .= <<<EOF
                    ,{field: '$field', title: '$comment'}

                    EOF;
            }
        }

        //创建文件夹
        if (!file_exists("./template/controller/")) {
            mkdir("./template/controller/", 0755, true);
        }
        if (!file_exists("./template/model/")) {
            mkdir("./template/model/", 0755, true);
        }
        if (!file_exists("./template/view/$name/")) {
            mkdir("./template/view/$name/", 0755, true);
        }

        //添加页
        $addhtml = <<<EOF
            <div class="layui-card-body" id="alert_form">
            <form class="layui-form" action="" lay-filter="alert">
                $addfrom
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="save">保存</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
            </div>
            <script>
                //监听提交
                form.on('submit(save)', function (obj) {
                    var post = obj.field;
                    submitPost('{:url("admin/$name/add")}', post);
                });
            </script>
        EOF;

        file_put_contents("./template/view/$name/add.html", $addhtml);

        //编辑页
        $id = '"{$data.id}"';
        $edithtml = <<<EOF
            <div class="layui-card-body" id="alert_form">
            <form class="layui-form" action="" lay-filter="alert">
                $editfrom
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="save">保存</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
            </div>
            <script>
                //监听提交
                form.on('submit(save)', function (obj) {
                    var post = obj.field;
                    post.id = $id
                    submitPost('{:url("admin/$name/edit")}', post);
                });
            </script>
        EOF;
        file_put_contents("./template/view/$name/edit.html", $edithtml);

        //列表页
        $listshtml = <<<EOF
        {include file="admin@public/header" /}
            <body>
            <div class="layui-fluid">
                <div class="layui-card" id="table">
                    <div class="layui-card-body">
                        <div>
                            <button class="layui-btn" data-type="add">添加</button>
                        </div>
                        <table class="layui-table" id="test" lay-filter="test"></table>
                    </div>
                </div>
            </div>
            <script type="text/html" id="optTpl">
                <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>
            <script type="text/javascript">
                var curr_page = 1;
                //搜索
                function search(curr) {
                    //执行重载
                    table.reload('test', {page: {curr: curr}, where: {}});
                }
                layui.use(['laydate', 'table'], function() {
                    var table = layui.table;
                    table.render({
                        elem: '#test'
                        ,url: '/admin/user/lists'
                        ,page: true //开启分页
                        ,cols: [[ //表头
                            {field: 'id', title: 'ID', width:60}
                            $listsfrom
                            ,{field: 'create_time', title: '创建时间', width:155}
                            ,{fixed: 'right', title:'操作', toolbar: '#optTpl', width:150}
                        ]],
                        done: function (res, curr, count) {
                            curr_page = curr;
                        }
                    });
                    $('.layui-btn').click(function () {
                        var type = $(this).data('type');
                        if(type == 'add'){
                            edit("{:url('/admin/$name/add')}", '新增');
                        }
                    });
                    //监听行工具事件
                    table.on('tool(test)', function(obj){
                        var data = obj.data;
                        if(obj.event === 'del'){
                            deleted("{:url('admin/$name/delete')}", obj)
                        } else if(obj.event === 'edit'){
                            edit("{:url('/admin/$name/edit/id/"+ data.id +"')}", '编辑');
                        }
                    });
                });
            </script>
            </body>
            </html>
        EOF;
        file_put_contents("./template/view/$name/lists.html", $listshtml);

        //控制器
        $controllerhtml = str_replace(array("{{a}}", "{{b}}"), array($ucwordsname, $tablecomment[0]['comment']), file_get_contents('./template/controller.php'));
        file_put_contents("./template/controller/$ucwordsname.php", $controllerhtml);

        //模型
        $modelhtml = str_replace(array("{{a}}", "{{b}}"), array($ucwordsname, $tablecomment[0]['comment']), file_get_contents('./template/model.php'));
        file_put_contents("./template/model/$ucwordsname.php", $modelhtml);

        //parent_id icon

        //插入权限表
        // $listdata = ['power_name' => $tablecomment[0]['comment'] . '列表', 'parent_id' => 0, 'uri' => '/admin/' . $name . '/lists', 'icon' => 'template-1', 'type' => 0];
        // $powerid = Db::name('power')->insertGetId($listdata);
        // $data = [
        //     ['power_name' => '添加' . $tablecomment[0]['comment'], 'parent_id' => $powerid, 'uri' => '/admin/' . $name . '/add', 'type' => '1'],
        //     ['power_name' => '编辑' . $tablecomment[0]['comment'], 'parent_id' => $powerid, 'uri' => '/admin/' . $name . '/edit', 'type' => '1'],
        //     ['power_name' => '删除' . $tablecomment[0]['comment'], 'parent_id' => $powerid, 'uri' => '/admin/' . $name . '/delete', 'type' => '1']
        // ];
        // Db::name('power')->insertAll($data);

        echo 'ok';
    }
}
