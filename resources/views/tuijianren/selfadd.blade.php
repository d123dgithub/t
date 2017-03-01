<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>家园佳居国际城</title>
    <!-- Bootstrap CSS 文件 -->
    <link rel="stylesheet" href="{{asset('static/bootstrap/css/bootstrap.min.css')}}">

</head>
<body>

<!-- 头部 -->

    <div class="jumbotron">
        <div class="container">
            <a href="{{url('index')}}"><h2>家园佳居国际城--皮草城推广</h2></a>
        </div>
    </div>


            <!-- 中间内容区局 -->
    <div class="container">
        <div class="row">
            <!-- 左侧菜单区域   -->
            <div class="col-md-3">

            </div>

            <!-- 右侧内容区域 -->
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">被推荐人自荐</div>
                    <div class="panel-body">

                        <form class="form-horizontal" method="post" action="">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">姓名</label>

                                <div class="col-sm-5">
                                    <input type="text" name="Beituijianren[username]" class="form-control" id=""
                                           value="{{old('Beituijianren')['username']}}"
                                           placeholder="请输入被推荐人姓名">
                                </div>
                                <div class="col-sm-5">
                                    <p class="form-control-static text-danger">{{$errors->first('Beituijianren.username')}}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="age" class="col-sm-2 control-label">电话</label>

                                <div class="col-sm-5">
                                    <input type="text" name='Beituijianren[phone]' class="form-control" id="phone"
                                           value="{{old('Beituijianren')['phone']}}"
                                           placeholder="请输入被推荐人手机号">
                                </div>
                                <div class="col-sm-5">
                                    <p class="form-control-static text-danger phone_error">@if(Session::has('is_exist')){{Session::get('is_exist')}}@else{{$errors->first('Beituijianren.phone')}}@endif</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="" class="btn btn-primary">提交</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>




            </div>
        </div>
    </div>

    <!-- 尾部 -->

    <div class="jumbotron" style="margin:0;">
        <div class="container">
            <span>  @2016 家园佳居国际城</span>
        </div>
    </div>


            <!-- jQuery 文件 -->
    <script src="{{asset('static/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap JavaScript 文件 -->
    <script src="{{asset('static/bootstrap/js/bootstrap.min.js')}}"></script>


</body>
<script type="text/javascript">
    $(function () {
        $('#phone').blur(function () {
            exist();
        });
    });



    function exist() {
        $.get("{{route('beituijianren_exist')}}", {'phone': $('#phone').val()}, function (data) {
            if (data == 0) {
                $('.phone_error').html('该电话号码已存在');
            } else {
                $('.phone_error').html('');
            }
        });
    }

</script>
</html>
















