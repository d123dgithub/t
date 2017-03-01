<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>家园佳居国际城</title>
    <!-- Bootstrap CSS 文件 -->
    <link rel="stylesheet" href="{{asset('static/bootstrap/css/bootstrap.min.css')}}">
    @section('style')

    @show
</head>
<body>

<!-- 头部 -->
@section('header')
    <div class="jumbotron">
        <div class="container">
            <a href="{{url('index')}}"><h2>家园佳居国际城--皮草城推广</h2></a>
        </div>
    </div>
    @show

            <!-- 中间内容区局 -->
    <div class="container">
        <div class="row">
            <!-- 左侧菜单区域   -->
            <div class="col-md-3">
                @section('leftmenu')
                    <div class="container">
                        你好，{{session('tuijianren')->username}}! &nbsp;&nbsp;&nbsp;&nbsp; <a href="{{url('tuijianren/exit')}}">退出登录</a>
                    </div>
                    <br/>
                    <div class="list-group">
                        <a href="{{url('tuijianren/tuijianren')}}" class="list-group-item {{ Request::getPathInfo()=='/tuijianren/tuijianren'?'active':'' }}">被推荐人列表</a>
                        <a href="{{url('tuijianren/add')}}" class="list-group-item {{ Request::getPathInfo()=='/tuijianren/add'?'active':'' }}">添加被推荐人</a>
                        <a href="{{url('tuijianren/szm',[session('tuijianren')->id])}}" class="list-group-item {{ Request::getPathInfo()=='/tuijianren/szm/'.session('tuijianren')->id?'active':'' }}">查看数字码</a>
                    </div>
                @show
            </div>

            <!-- 右侧内容区域 -->
            <div class="col-md-9">


                @yield('content')


            </div>
        </div>
    </div>

    <!-- 尾部 -->
@section('footer')
    <div class="jumbotron" style="margin:0;">
        <div class="container">
            <span>  @2016 家园佳居国际城</span>
        </div>
    </div>
    @show

            <!-- jQuery 文件 -->
    <script src="{{asset('static/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap JavaScript 文件 -->
    <script src="{{asset('static/bootstrap/js/bootstrap.min.js')}}"></script>

@section('javascript')
@show
</body>
</html>