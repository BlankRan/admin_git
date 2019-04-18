@extends('list')
@section('body_content')
    <div class="layui-form" lay-filter="layuiadmin-form-admin" id="layuiadmin-form-admin" style="padding: 20px 30px 0 0;">
        <div class="layui-form-item">
            <label class="layui-form-label">登录名</label>
            <div class="layui-input-inline">
                <input type="text" name="loginname" lay-verify="must" placeholder="请输入用户名" autocomplete="off" class="layui-input" value="{{$adminData->username}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登陆密码</label>
            <div class="layui-input-inline">
                <input type="password" name="loginpwd" lay-verify="must" placeholder="请输入登陆密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认密码</label>
            <div class="layui-input-inline">
                <input type="password" name="againpwd" lay-verify="must" placeholder="请在输入一次密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机</label>
            <div class="layui-input-inline">
                <input type="text" name="phone" lay-verify="must|phone" placeholder="请输入号码" autocomplete="off" class="layui-input" value="{{$adminData->phone}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-inline">
                <input type="text" name="email" lay-verify="must|email" placeholder="请输入邮箱" autocomplete="off" class="layui-input" value="{{$adminData->email}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Git账号</label>
            <div class="layui-input-inline">
                <input type="text" name="git_account" lay-verify="must" placeholder="请输入Git账号" autocomplete="off" class="layui-input" value="{{$adminData->git_account}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Git密码</label>
            <div class="layui-input-inline">
                <input type="password" name="git_password" lay-verify="must" placeholder="请输入Git密码" autocomplete="off" class="layui-input" value="{{$adminData->git_password}}">
            </div>
        </div>
        <!--
        <div class="layui-form-item">
            <label class="layui-form-label">角色</label>
            <div class="layui-input-inline">
                <input type="text" name="role" lay-verify="required" placeholder="请输入角色类型" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        -->
        <div class="layui-form-item">
            <label class="layui-form-label">审核状态</label>
            <div class="layui-input-inline">
                <input type="checkbox" lay-filter="switch" name="switch" lay-skin="switch" lay-text="通过|待审核" @if($adminData->status==1) checked @endif>
            </div>
        </div>
        <input class="layui-hide" name="status" id="status" value="{{$adminData->status}}">
        <input class="layui-hide" name="id" value="{{$adminData->id}}">
        <input class="layui-hide" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-back-submit" value="确认">
        </div>
    </div>

    <script>
        layui.config({
            base: '../../../layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'form'], function () {
            var $ = layui.$
                , form = layui.form;
            //审核checkbox监听
            form.on('switch(switch)', function(data){
                if (data.elem.checked) {
                    $('#status').val('1');
                }else {
                    $('#status').val('-1');
                }
            });
            form.verify({
                must: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if (!value || value == '0'){
                        return item.placeholder;
                    }
                }
            });
        })
    </script>
@endsection
