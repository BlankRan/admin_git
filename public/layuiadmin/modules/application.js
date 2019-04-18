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
        ,url: 'json/application'
        ,where:{_token:$('#token').val()}
        ,method:'POST'
        ,cols: [[
            {fixed: 'left',field: 'id', width: 80, title: 'ID', sort: true,align:'center'}
            ,{field: 'username', title: '登录名',align:'center'}
            ,{field: 'phone', title: '手机',align:'center'}
            ,{field: 'email', title: '邮箱',align:'center'}
            // ,{field: 'role', title: '角色'}
            ,{field: 'created_at', title: '创建时间', sort: true,align:'center'}
            ,{field: 'check', title:'用户状态', templet: '#buttonTpl', minWidth: 80, align: 'center',align:'center'}
            ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#table-useradmin-admin'}
        ]]
        ,text: '对不起，加载出现异常！'
    });


    exports('application', {});
});