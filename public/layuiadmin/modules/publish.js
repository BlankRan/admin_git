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


    treeGird.on('tool(LAY-user-back-manage)', function(obj) {
        var data = obj.data;
        if (obj.event === 'log') {
                $.post('/publish/log', {id: data.id, _token: $('#token').val()}, function (data) {
                    if (data.code == 200) {
                        layer.msg(data.msg, {
                            icon: 1
                        });
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
                layer.close(index);
        } else if (obj.event === 'rollback') {
            $.post('/publish/rollback', {id: data.id, _token: $('#token').val()}, function (data) {
                if (data.code == 200) {
                    layer.msg(data.msg, {
                        icon: 1
                    });
                } else {
                    layer.msg(data.msg, {
                        icon: 2
                    });
                }
            });
            layer.close(index);
        }else if (obj.event === 'release') {
            $.post('/publish/release', {id: data.id, _token: $('#token').val()}, function (data) {
                if (data.code == 200) {
                    layer.msg(data.msg, {
                        icon: 1
                    });
                } else {
                    layer.msg(data.msg, {
                        icon: 2
                    });
                }
            });
            layer.close(index);
        }else if (obj.event === 'quick') {
            $.post('/publish/quick', {id: data.id, _token: $('#token').val()}, function (data) {
                if (data.code == 200) {
                    layer.msg(data.msg, {
                        icon: 1
                    });
                } else {
                    layer.msg(data.msg, {
                        icon: 2
                    });
                }
            });
            layer.close(index);
        }
    });

    exports('publish', {});
});