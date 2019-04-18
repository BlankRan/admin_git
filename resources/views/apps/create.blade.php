@extends('list')
@section('body_content')
    <div class="layui-form" lay-filter="layuiadmin-form-admin" id="layuiadmin-form-admin" style="padding: 20px 30px 0 0;">
        <div class="layui-form-item">
            <label class="layui-form-label">应用名</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="must" placeholder="请输入应用名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">服务域名</label>
            <div class="layui-input-inline">
                <input type="text" name="domain_name" lay-verify="must" placeholder="请输入服务域名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">节点</label>
            <div class="layui-input-inline">
                <input type="text" name="node[]" lay-verify="must" placeholder="请输入节点" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid">
                <button class="layui-btn layui-btn-xs" id="adds">
                    <i class="layui-icon">&#xe654;</i>
                </button>
            </div>
        </div>
        <div id="new_add"></div>
        <div class="layui-form-item">
            <label class="layui-form-label">git地址</label>
            <div class="layui-input-inline">
                <input type="text" name="git_url" lay-verify="must" placeholder="请输入号码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">代码目录</label>
            <div class="layui-input-inline">
                <input type="text" name="directory" lay-verify="must" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-back-submit" value="确认">
        </div>
    </div>

    <div id="new_adds" style="display: none;">
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
                <input type="text" name="node[]" lay-verify="must" placeholder="请输入节点" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid">
                <button class=" layui-btn layui-btn-xs layui-btn-danger deled">
                    <i class="layui-icon">&#xe640;</i>
                </button>
            </div>
        </div>
    </div>

    <script>
        layui.config({
            base: '../../../layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'form','publictools'], function () {
            var $ = layui.$
                , form = layui.form;
            $("#adds").on('click',function() {
                var new_node = $("#new_adds").html();
                $("#new_add").append(new_node);
                form.render();
            });
            $("#new_add").on('click','.deled',function () {
                $(this).closest('.layui-form-item').remove();
                form.render();
            });
        })
    </script>
@endsection