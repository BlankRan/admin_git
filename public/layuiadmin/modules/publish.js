/**
 @name:应用列表展示
 @Date: 2019年4月18日
 */
layui.config({
    base:'/layuiadmin/extend/'
}).extend({
    treeGrid:'treeGrid'
});

layui.define(['table', 'form','treeGrid'], function(exports){
    var $ = layui.$
        , table = layui.table
        , form = layui.form
        , treeGird = layui.treeGrid;

    treeGird.render({
        elem: '#LAY-user-back-manage'
        ,where:{_token:$('#token').val()}
        ,method:'POST'
        ,url:'/json/publish'
        ,idField:'id'
        ,iconOpen:false
        ,treeId:'id'//树形id字段名称
        ,treeUpId:'pid'//树形父id字段名称
        ,treeShowName:'name'//以树形式显示的字段
        ,isOpenDefault:false
        ,cols: [[
        // {width:100,title: '操作', align:'center'/*toolbar: '#barDemo'*/
        //     ,templet: function(d){
        //         var html='';
        //         var addBtn='<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="add">添加</a>';
        //         var delBtn='<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
        //         return addBtn+delBtn;
        //     }
        // }
            {type:'checkbox'}
             ,{field: 'id', title: 'id',width:'40',align:'center'}
            , {field: 'name',  title: '应用名称',width:'140',align:'center'}
            , {field: 'domain_name',  title: '应用域名',width:'120',align:'center'}
            , {field: 'number',  title: '节点个数',width:'60',align:'center'}
            , {field: 'ip',  title: '主机地址',align:'center',width:'120'}
            , {field: 'commit_id',  title: '本次版本号',align:'center',width:'130'}
            , {field: 'last_commit_id',  title: '上一个版本号',align:'center',width:'130'}
            , {field: 'updated_at',  title: '更新时间',align:'center',minWidth:'79'}
            ,{title: '操作', minWidth:'175', align: 'center',toolbar: '#table-useradmin-admin'}
        ]]
        ,page:false
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

    exports('publish', {});
});