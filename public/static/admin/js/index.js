var form,element,layer,table;
layui.use(['form','layer','table','element','laytpl'], function(){
   element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
  layer = layui.layer;
  form = layui.form;
  table = layui.table;
  var laytpl = layui.laytpl;
});

/**
 * 删除的公共方法
 * @param url
 * @returns {boolean}
 */
function deleted(url, str, url_data) {
    var checkStatus = table.checkStatus('test_id'), data = checkStatus.data;
    if (data.length > 0) {
        if (data.length == 1) {
            var id = data[0]['id'];
        } else {
            var id = '';
            for (var i = 0; i < data.length; i++) {
                id += data[i]['id'] + ',';
            }
            id = id.substring(0, id.length - 1);
        }
        layer.open({
            title: '信息',
            type: 1,
            content: '<div style="padding: 20px 100px;">'+str+'</div>',
            btn: ['确定', '取消'],
            yes: function () {
                layer.closeAll();
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function (data) {
                         if(data.code == 0){
                            layer.msg(data.msg,{icon:1,time:2000}, function(){
                                layer.closeAll();
                                if(url_data == 1){
                                    $(".search").click();
                                } else {
                                    location.reload();
                                }
                            })
                        } else{
                             layer.msg(data.msg,{icon:2,time:2000})
                        }
                    }
                });
            },
            btn2: function () {
            }
        });
    }
    return false;
}

/**
 * 添加的公共方法
 * @param url
 * @returns {boolean}
 */
function add(url, title) {
    $.post(url, {}, function (str) {
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
 * 编辑的公共方法
 * @param url
 * @returns {boolean}
 */
function edit(url, title) {
    var loading = layer.load();
    $.post(url, {}, function (str) {
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