@extends('list')
@section('body_content')
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">ID</label>
                        <div class="layui-input-block">
                            <input type="text" name="app_id" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">应用名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="app_name" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">域名</label>
                        <div class="layui-input-block">
                            <input type="text" name="domain_name" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="LAY-user-back-search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <button class="layui-btn layuiadmin-btn-admin" data-type="add">添加</button>
                </div>
                <table id="LAY-user-back-manage" lay-filter="LAY-user-back-manage"></table>
                <input id="token" class="layui-hide" value="{{csrf_token()}}">
                <script type="text/html" id="table-useradmin-admin">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
                    {{--<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="back"><i class="layui-icon layui-icon-delete"></i>回滚</a>--}}
                    {{--<a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="push"><i class="layui-icon layui-icon-delete"></i>发布</a>--}}
                </script>
                <input class="layui-hide" name="_token" value="{{csrf_token()}}" id="token">
            </div>
        </div>
    </div>

    <script>
        layui.config({
            base: '../../../layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'application', 'table'], function () {
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
                        , title: '添加应用'
                        , content: '{{url('application/addform')}}'
                        , area: ['500px', '420px']
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
                                $.post("{{url('application/add')}}?_token={{csrf_token()}}",field,function (data) {
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
                                });
                            });
                            submit.trigger('click');
                        }
                    });
                }
            };
            $('.layui-btn.layuiadmin-btn-admin').on('click', function () {

                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });
    </script>
@endsection