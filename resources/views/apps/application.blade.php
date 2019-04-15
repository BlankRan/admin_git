@extends('list')
@section('body_content')
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">ID</label>
                        <div class="layui-input-block">
                            <input type="text" name="id" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">发帖人</label>
                        <div class="layui-input-block">
                            <input type="text" name="poster" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">发帖内容</label>
                        <div class="layui-input-block">
                            <input type="text" name="content" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">帖子状态</label>
                        <div class="layui-input-block">
                            <select name="top">
                                <option value="0">正常</option>
                                <option value="1">置顶</option>
                                <option value="2">封禁</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-forum-list" lay-submit
                                lay-filter="LAY-app-forumlist-search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <button class="layui-btn layuiadmin-btn-forum-list" data-type="batchdel">删除</button>
                </div>
                <table id="LAY-app-forum-list" lay-filter="LAY-app-forum-list"></table>

                <script type="text/html" id="table-forum-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                                class="layui-icon layui-icon-edit"></i>编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                                class="layui-icon layui-icon-delete"></i>删除</a>
                </script>
            </div>
        </div>
    </div>

    <script>
        layui.config({
            base: '../../../layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'forum', 'table'], function () {
            var $ = layui.$
                , form = layui.form
                , table = layui.table;

            //监听搜索
            form.on('submit(LAY-app-forumlist-search)', function (data) {
                var field = data.field;

                //执行重载
                table.reload('LAY-app-forum-list', {
                    where: field
                });
            });

            //事件
            var active = {
                batchdel: function () {
                    var checkStatus = table.checkStatus('LAY-app-forum-list')
                        , checkData = checkStatus.data; //得到选中的数据

                    if (checkData.length === 0) {
                        return layer.msg('请选择数据');
                    }

                    layer.confirm('确定删除吗？', function (index) {

                        //执行 Ajax 后重载
                        /*
                        admin.req({
                          url: 'xxx'
                          //,……
                        });
                        */
                        table.reload('LAY-app-forum-list');
                        layer.msg('已删除');
                    });
                }
            };

            $('.layui-btn.layuiadmin-btn-forum-list').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });
    </script>
@endsection