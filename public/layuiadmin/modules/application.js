/**
    @name:应用列表展示
    @Date: 2019年4月18日
 */

layui.define(['table', 'form'], function(exports){
    var $ = layui.$
        , table = layui.table
        , form = layui.form;

    table.render({
        elem: '#LAY-user-back-manage'
        // ,url: layui.setter.base + 'json/useradmin/mangadmin.js' //模拟接口
        ,url: '/json/application'
        ,where:{_token:$('#token').val()}
        ,method:'POST'
        ,cols: [[
            {fixed: 'left',field: 'id', width: 80, title: 'ID', sort: true,align:'center'}
            ,{field: 'name', title: '应用名称',align:'center'}
            ,{field: 'git_url', title: 'git地址',align:'center'}
            ,{field: 'directory', title: '代码目录',align:'center'}
            ,{field: 'init', title: '是否初始化',align:'center'}
            ,{field: 'composer', title: 'composer',align:'center'}
            ,{field: 'created_at', title: '创建时间', sort: true,align:'center'}
            ,{field: 'updated_at', title: '更新时间', sort: true,align:'center'}
            ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#table-useradmin-admin'}
        ]]
        ,text: '对不起，加载出现异常！'
    });

    table.on('tool(LAY-user-back-manage)', function(obj) {
        var data = obj.data;
        if (obj.event === 'del') {
            layer.confirm('确定删除此应用？', function (index) {
                console.log(obj);
                $.post('/application/del', {id: data.id, _token: $('#token').val()}, function (data) {
                    if (data.code == 200) {
                        layer.msg(data.msg, {
                            icon: 1
                        });
                    } else {
                        layer.msg('删除失败', {
                            icon: 2
                        });
                    }
                });
                obj.del();
                layer.close(index);
            });
        } else if (obj.event === 'edit') {
            var tr = $(obj.tr);
            layer.open({
                type: 2
                , title: '编辑应用'
                , content: '/application/edit/' + data.id
                , area: ['500px', '420px']
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    var iframeWindow = window['layui-layer-iframe' + index]
                        , submitID = 'LAY-user-back-submit'
                        , submit = layero.find('iframe').contents().find('#' + submitID)
                        , submitFilter = 'LAY-user-front-submit';
                    //监听提交
                    iframeWindow.layui.form.on('submit(' + submitFilter + ')', function (data) {
                        var field = data.field; //获取提交的字段
                        //提交 Ajax 成功后，静态更新表格中的数据
                        $.post("/application/add", field, function (data) {
                            if (data.code == 200) {
                                layer.msg('修改成功', {
                                    icon: 1
                                });
                                table.reload('LAY-user-back-manage'); //数据刷新
                                layer.close(index); //关闭弹层
                            } else {
                                layer.msg('修改失败', {
                                    icon: 2
                                });
                            }
                        });
                    });
                    submit.trigger('click');
                }
            })
        }
    });

    exports('application', {});
});