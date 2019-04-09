var form,element,layer,table,laytpl;
layui.use(['form','layer','table','element','laytpl'], function(){
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
    obj.del();
    layer.confirm('真的删除行么', function(index){
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                id: obj.data.id
            },
            success: function (data) {
                if(data.code == 0){
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
 * @returns {boolean}
 */
function submitPost(url, post) {
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
                    search();
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
function edit(url, title) {
    var loading = layer.load();
    $.get(url, {}, function (str) {
        layer.close(loading); 
        layer.open({
            title: title,
            type: 1,
            content: str
        });
        form.render(null, "alert");
    });
    return false;
}

