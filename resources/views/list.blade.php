<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{env('APP_TITLE')}}</title>
    <link rel="stylesheet" href="{{url('layuiadmin/layui/css/layui.css')}}" media="all"/>
    <link rel="stylesheet" href="{{url('layuiadmin/layui/css/layui.css')}}" media="all"/>
    <link rel="stylesheet" href="{{url('layuiadmin/style/admin.css')}}" media="all"/>
</head>
<body>
<script src="{{url('layuiadmin/layui/layui.js')}}" charset="utf-8"></script>
@yield('body_content')
</body>
</html>