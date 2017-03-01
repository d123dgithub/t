@extends('common/tuijianren_layout')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">添加被推荐人</div>
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
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">推荐链接</label>

                    <div class="col-sm-5">
                        <p class="form-control">
                            <input type="hidden" value="{{$yaoqing.url('invite',['id'=>base64_encode(session('tuijianren')->id)])}}" id="yaoqing">
                     <a href="javascript:;" id="copyBtn">点击后分享吧！</a>
                        </p>
                    </div>

                </div>

            </form>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{asset('static/zclib/jquery.zclip.min.js')}}"></script>
    <script type="text/javascript">

        $(function () {

            $('#phone').blur(function () {
                exist();
            });

            $('#copyBtn').zclip({
                path: "{{asset('static/zclib/ZeroClipboard.swf')}}",
                copy: function () {
                    return $('#yaoqing').val()+$('#addselfurl').text();
                },
                afterCopy: function () {
                    alert('复制成功');
                }
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
@stop