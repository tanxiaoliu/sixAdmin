var form,element,layer,table,laytpl;
layui.use(['form','layer','table','element','laytpl'], function() {
    element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
    layer = layui.layer;
    form = layui.form;
    table = layui.table;
    laytpl = layui.laytpl;
});

/**
 * 删除的公共方法
 * @param url
 * @param obj
 */
function deleted(url, obj) {
    layer.confirm('真的删除行么', function(index){
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                id: obj.data.id
            },
            success: function (data) {
                if(data.code == 0 && data.wait != 3){
                    obj.del();
                    layer.msg(data.msg,{icon:6,time:2000}, function(){
                        layer.closeAll();
                    })
                } else{
                    layer.msg(data.msg,{icon:5,time:2000})
                }
            }
        });
    });
}

/**
 * 跳转添加页面的公共方法
 * @param url
 * @returns {boolean}
 */
function add(url, title) {
    $.get(url, {}, function (str) {
        layer.open({
            title: title,
            type: 1,
            content: str
        });
        form.render(null, "alert");
    });
    return false;
}

/**
 * 添加操作的公共方法
 * @param url
 * @param post
 * @param status
 */
function submitPost(url, post, status) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            post: post
        },
        success: function (data) {
            if (data.code == 0) {
                layer.msg(data.msg, {icon: 6, time: 2000}, function () {
                    layer.closeAll();
                    if(status == '') {
                        search();
                    }
                })
            } else {
                layer.msg(data.msg, {icon: 5, time: 2000})
            }
        },
        error: function (jqXHR) {
            layer.msg('操作失败', {icon: 5, time: 2000})
        }
    });
}

/**
 * 跳转编辑页面的公共方法
 * @param url
 * @param title
 * @returns {boolean}
 */
function edit(url, title, w, h) {
    var width = w != null ? w : '500px';
    var height = h != null ? h : '';
    var title = title != null ? title : false;
    var url = url != null ? url : "404.html";
    var loading = layer.load();
    $.get(url, {}, function (str) {
        layer.close(loading);
        if(str.code == 0 && str.wait == 3){
            layer.msg(str.msg, {icon: 5, time: 2000})
        } else {
            layer.open({
                area: [width, height],
                title: title,
                type: 1,
                content: str,
                maxmin: true,
                shadeClose: true,
                shade: 0.2
            });
            form.render(null, "alert");
        }
    });
    return false;
}
