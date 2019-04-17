@extends('list')
@section('body_content')
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">登录名</label>
                        <div class="layui-input-block">
                            <input type="text" name="loginname" placeholder="请输入" autocomplete="off"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">手机</label>
                        <div class="layui-input-block">
                            <input type="text" name="telphone" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">邮箱</label>
                        <div class="layui-input-block">
                            <input type="text" name="email" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <!--
                    <div class="layui-inline">
                        <label class="layui-form-label">角色</label>
                        <div class="layui-input-block">
                            <select name="role">
                                <option value="0">管理员</option>
                                <option value="1">超级管理员</option>
                                <option value="2">纠错员</option>
                                <option value="3">采购员</option>
                                <option value="4">推销员</option>
                                <option value="5">运营人员</option>
                                <option value="6">编辑</option>
                            </select>
                        </div>
                    </div>
                    -->
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="LAY-user-back-search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <button class="layui-btn layuiadmin-btn-admin" data-type="batchdel">删除</button>
                    <button class="layui-btn layuiadmin-btn-admin" data-type="add">添加</button>
                </div>
                <table id="LAY-user-back-manage" lay-filter="LAY-user-back-manage"></table>
                <input id="token" class="layui-hide" value="{{csrf_token()}}">
                <script type="text/html" id="buttonTpl">
                    @{{#  if(d.status == 1){ }}
                    <button class="layui-btn layui-btn-xs">正常</button>
                    @{{#  } else { }}
                    <button class="layui-btn layui-btn-primary layui-btn-xs">禁用</button>
                    @{{#  } }}
                </script>

                {{--<!----}}
                <script type="text/html" id="table-useradmin-admin">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
                </script>
                {{---->--}}
                <input class="layui-hide" name="_token" value="{{csrf_token()}}">
            </div>
        </div>
    </div>

    <script>
        layui.config({
            base: '../../../layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'useradmin', 'table'], function () {
            var $ = layui.$
                , form = layui.form
                , table = layui.table;

            //监听搜索
            form.on('submit(LAY-user-back-search)', function (data) {
                var field = data.field;

                //执行重载
                table.reload('LAY-user-back-manage', {
                    where: field
                });
            });

            //事件
            var active = {
                add: function () {
                    layer.open({
                        type: 2
                        , title: '添加管理员'
                        , content: '{{url('user/adminform')}}'
                        , area: ['420px', '420px']
                        , btn: ['确定', '取消']
                        , yes: function (index, layero) {
                            var iframeWindow = window['layui-layer-iframe' + index]
                                , submitID = 'LAY-user-back-submit'
                                , submit = layero.find('iframe').contents().find('#' + submitID)
                                ,submitFilter = 'LAY-user-front-submit';

                            //监听提交
                            submit.trigger('click');
                            iframeWindow.layui.form.on('submit(' + submitFilter + ')', function (data) {
                                var field = data.field; //获取提交的字段

                                //提交 Ajax 成功后，静态更新表格中的数据
                                $.post("{{url('user/add')}}?_token={{csrf_token()}}",field,function (data) {
                                    if (data.code == 200) {
                                        layer.msg(data.msg, {
                                            icon: 1
                                        });
                                        layer.close(index); //关闭弹层
                                    }else {
                                        layer.msg(data.msg, {
                                            icon: 2
                                        });
                                    }
                                    // table.reload('LAY-user-back-manage'); //数据刷新

                                });
                            });
                        }
                    });
                }
            }
            $('.layui-btn.layuiadmin-btn-admin').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });
    </script>
@endsection