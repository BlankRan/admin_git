@extends('list')
@section('body_content')
    <div class="layui-form" lay-filter="layuiadmin-form-admin" id="layuiadmin-form-admin" style="padding: 20px 30px 0 30px;">
        <div class="layui-form-item">
            <label class="layui-form-label">应用名</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="must" placeholder="请输入应用名" autocomplete="off" class="layui-input" value="{{$item->name}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">服务域名</label>
            <div class="layui-input-inline">
                <input type="text" name="domain_name" lay-verify="must" placeholder="请输入服务域名" autocomplete="off" class="layui-input" value="{{$item->domain_name}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">节点</label>
            <div class="layui-input-inline">
                <input type="text" name="node[]" lay-verify="must" placeholder="请输入节点" autocomplete="off" class="layui-input" @if(!empty($ips))value="{{$ips[0]}}"@endif>
            </div>
            <div class="layui-form-mid">
                <button class="layui-btn layui-btn-xs" id="adds">
                    <i class="layui-icon">&#xe654;</i>
                </button>
            </div>
        </div>
        <div id="new_add">
            @if(!empty($ips))
            @foreach($ips as $v)
                @if($ips[0] != $v)
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-inline">
                        <input type="text" name="node[]" lay-verify="must" placeholder="请输入节点" autocomplete="off" class="layui-input" value="{{$v}}">
                    </div>
                    <div class="layui-form-mid">
                        <button class=" layui-btn layui-btn-xs layui-btn-danger deled">
                            <i class="layui-icon">&#xe640;</i>
                        </button>
                    </div>
                </div>
                @endif
            @endforeach
            @endif
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">git地址</label>
            <div class="layui-input-inline">
                <input type="text" name="git_url" lay-verify="must" placeholder="请输入git地址" autocomplete="off" class="layui-input" value="{{$item->git_url}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">代码目录</label>
            <div class="layui-input-inline">
                <input type="text" name="directory" lay-verify="must" placeholder="请输入代码目录" autocomplete="off" class="layui-input" value="{{$item->directory}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">服务器账号</label>
            <div class="layui-input-inline">
                <input type="text" name="server_account" lay-verify="must" placeholder="请输入服务器账号" autocomplete="off" class="layui-input" value="{{$item->server_account}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否初始化</label>
            <div class="layui-input-inline">
                <input type="checkbox" lay-filter="init" lay-skin="switch" lay-text="是|否" @if($item->init == 1) checked @endif>
            </div>
            <input class="layui-hide" name="init" id="init" value="{{$item->init}}">
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Composer</label>
            <div class="layui-input-inline">
                <input type="checkbox" lay-filter="composer"  lay-skin="switch" lay-text="是|否" @if($item->composer == 1) checked @endif>
            </div>
            <input class="layui-hide" name="composer" id="composer" value="{{$item->composer}}">
        </div>
        <input class="layui-hide" name="id" value="{{$item->id}}">
        <input class="layui-hide" name="_token" value="{{csrf_token()}}">
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

            form.on('switch(init)', function(data){
                if (data.elem.checked) {
                    $('#init').val('1');
                }else {
                    $('#init').val('-1');
                }
            });
            form.on('switch(composer)', function(data){
                if (data.elem.checked) {
                    $('#composer').val('1');
                }else {
                    $('#composer').val('-1');
                }
            });

        })
    </script>
@endsection