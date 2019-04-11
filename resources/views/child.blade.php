@extends('app')

@section('title', 'test')

@section('sidebar')
    @parent
    <p>Laravel学院致力于提供优质Laravel中文学习资源</p>
@endsection

@section('content')
    <p>这里是主体内容，完善中1...</p>
@endsection