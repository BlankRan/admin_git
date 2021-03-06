/**

 @Name：layuiAdmin 用户管理 管理员管理 角色管理
 @Author：star1029
 @Site：http://www.layui.com/admin/
 @License：LPPL
    
 */


layui.define(['table', 'form'], function(exports){
  var $ = layui.$
  ,table = layui.table
  ,form = layui.form;

  //用户管理
  table.render({
    elem: '#LAY-user-manage'
    // ,url: layui.setter.base + 'json/useradmin/webuser.js' //模拟接口
      ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field: 'id', width: 100, title: 'ID', sort: true}
      ,{field: 'username', title: '用户名', minWidth: 100}
      ,{field: 'avatar', title: '头像', width: 100, templet: '#imgTpl'}
      ,{field: 'phone', title: '手机'}
      ,{field: 'email', title: '邮箱'}
      ,{field: 'sex', width: 80, title: '性别'}
      ,{field: 'ip', title: 'IP'}
      ,{field: 'jointime', title: '加入时间', sort: true}
      ,{title: '操作', width: 150, align:'center', fixed: 'right', toolbar: '#table-useradmin-webuser'}
    ]]
    ,page: true
    ,limit: 30
    ,height: 'full-220'
    ,text: '对不起，加载出现异常！'
  });
  
  //监听工具条
  table.on('tool(LAY-user-manage)', function(obj){
    var data = obj.data;
    if(obj.event === 'del'){
      layer.prompt({
        formType: 1
        ,title: '敏感操作，请验证口令'
      }, function(value, index){
        layer.close(index);
        
        layer.confirm('真的删除行么', function(index){
          obj.del();
          layer.close(index);
        });
      });
    } else if(obj.event === 'edit'){
      var tr = $(obj.tr);

      layer.open({
        type: 2
        ,title: '编辑用户'
        ,content: '../../../views/user/user/userform.html'
        ,maxmin: true
        ,area: ['500px', '450px']
        ,btn: ['确定', '取消']
        ,yes: function(index, layero){
          var iframeWindow = window['layui-layer-iframe'+ index]
          ,submitID = 'LAY-user-front-submit'
          ,submit = layero.find('iframe').contents().find('#'+ submitID);

          //监听提交
          iframeWindow.layui.form.on('submit('+ submitID +')', function(data){
            var field = data.field; //获取提交的字段
            
            //提交 Ajax 成功后，静态更新表格中的数据
            //$.ajax({});
            table.reload('LAY-user-front-submit'); //数据刷新
            layer.close(index); //关闭弹层
          });  
          
          submit.trigger('click');
        }
        ,success: function(layero, index){
          
        }
      });
    }
  });

  //管理员管理
  table.render({
    elem: '#LAY-user-back-manage'
    // ,url: layui.setter.base + 'json/useradmin/mangadmin.js' //模拟接口
      ,url: 'json/admin'
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
  
  //监听工具条
  table.on('tool(LAY-user-back-manage)', function(obj){
    var data = obj.data;
    if(obj.event === 'del'){
        layer.confirm('确定删除此管理员？', function(index){
            console.log(obj);
            $.post('/admin/del',{id:data.id,_token:$('#token').val()},function (data) {
              if (data.code == 200){
                  layer.msg(data.msg, {
                      icon: 1
                  });
              }else {
                  layer.msg('删除失败', {
                      icon: 2
                  });
              }
            });
            obj.del();
            layer.close(index);
        });
    }else if(obj.event === 'edit'){
      var tr = $(obj.tr);
        layer.open({
            type: 2
            , title: '编辑管理员'
            , content: '/admin/edit/'+data.id
            , area: ['420px', '420px']
            , btn: ['确定', '取消']
            , yes: function (index, layero) {
                var iframeWindow = window['layui-layer-iframe' + index]
                    , submitID = 'LAY-user-back-submit'
                    , submit = layero.find('iframe').contents().find('#' + submitID)
                    ,submitFilter = 'LAY-user-front-submit';
                //监听提交
                iframeWindow.layui.form.on('submit(' + submitFilter + ')', function (data) {
                    var field = data.field; //获取提交的字段
                    //提交 Ajax 成功后，静态更新表格中的数据
                    $.post("/user/add",field,function (data) {
                        if (data.code == 200) {
                            layer.msg('修改成功', {
                                icon: 1
                            });
                            table.reload('LAY-user-back-manage'); //数据刷新
                            layer.close(index); //关闭弹层
                        }else {
                            layer.msg('修改失败', {
                                icon: 2
                            });
                        }
                    });
                });
                submit.trigger('click');
            }
        })
    }else if (obj.event === 'open'){
        $.post("/user/status",{status:1,_token:$('#token').val(),id:data.id},function (data) {
            if (data.code == 200) {
                layer.msg('用户状态已启用', {
                    icon: 1
                });
                table.reload('LAY-user-back-manage'); //数据刷新
            }else {
                layer.msg('用户状态修改失败', {
                    icon: 2
                });
            }
        });
    }else if (obj.event === 'close'){
        $.post("/user/status",{status:-1,_token:$('#token').val(),id:data.id},function (data) {
            if (data.code == 200) {
                layer.msg('用户状态已禁用', {
                    icon: 1
                    ,time:500
                });
                table.reload('LAY-user-back-manage'); //数据刷新
            }else {
                layer.msg('用户状态修改失败', {
                    icon: 2
                    ,time:500
                });
            }
        });
    }
  });

  //角色管理
  table.render({
    elem: '#LAY-user-back-role'
    ,url: layui.setter.base + 'json/useradmin/role.js' //模拟接口
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field: 'id', width: 80, title: 'ID', sort: true}
      ,{field: 'rolename', title: '角色名'}
      ,{field: 'limits', title: '拥有权限'}
      ,{field: 'descr', title: '具体描述'}
      ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#table-useradmin-admin'}
    ]]
    ,text: '对不起，加载出现异常！'
  });
  
  //监听工具条
  table.on('tool(LAY-user-back-role)', function(obj){
    var data = obj.data;
    if(obj.event === 'del'){
      layer.confirm('确定删除此角色？', function(index){
        obj.del();
        layer.close(index);
      });
    }else if(obj.event === 'edit'){
      var tr = $(obj.tr);

      layer.open({
        type: 2
        ,title: '编辑角色'
        ,content: '../../../views/user/administrators/roleform.html'
        ,area: ['500px', '480px']
        ,btn: ['确定', '取消']
        ,yes: function(index, layero){
          var iframeWindow = window['layui-layer-iframe'+ index]
          ,submit = layero.find('iframe').contents().find("#LAY-user-role-submit");

          //监听提交
          iframeWindow.layui.form.on('submit(LAY-user-role-submit)', function(data){
            var field = data.field; //获取提交的字段
            
            //提交 Ajax 成功后，静态更新表格中的数据
            //$.ajax({});
            table.reload('LAY-user-back-role'); //数据刷新
            layer.close(index); //关闭弹层
          });  
          
          submit.trigger('click');
        }
        ,success: function(layero, index){
        
        }
      })
    }
  });

  exports('useradmin', {})
});
