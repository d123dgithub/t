@extends('common.layouts')

@section('content')
    @include('common.message')
    <div class="panel panel-default">
        <div class="panel-heading">推荐人注册</div>
        <div class="panel-body">

            <form class="form-horizontal" method="post" action="{{url('tuijianren/register')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">姓名</label>

                    <div class="col-sm-5">
                        <input type="text" name="Tuijianren[username]" class="form-control" id=""
                               value="{{old('Tuijianren')['username']}}"
                               placeholder="请输入推荐人姓名">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Tuijianren.username')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">电话</label>

                    <div class="col-sm-5">
                        <input type="text" name='Tuijianren[phone]' class="form-control" id="phone"
                               value="{{old('Tuijianren')['phone']}}"
                               placeholder="请输入推荐人手机号">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">@if(Session::has('is_exist')){{Session::get('is_exist')}}@else{{$errors->first('Tuijianren.phone')}}@endif</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">密码</label>

                    <div class="col-sm-5">
                        <input type="password" name='Tuijianren[password]' class="form-control" id=""
                               value=""
                               placeholder="请输入密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Tuijianren.password')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">确认密码</label>

                    <div class="col-sm-5">
                        <input type="password" name='Tuijianren[password_confirmation]' class="form-control" id=""
                               value=""
                               placeholder="请输入确认密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Tuijianren.password_confirmation')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">验证码</label>

                    <div class="col-sm-5">
                        <input type="text" name="captcha" class="form-control"  style="width:161px;display:inline">
                        <a onclick="javascript:re_captcha();" style="display:inline"><img src="{{ URL('kit/captcha/1') }}"  alt="验证码" title="刷新图片" width="100" height="34" id="captcha" border="0"></a>

                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">@if(Session::has('captcha_error')){{Session::get('captcha_error')}}@endif</p>
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
@stop
@section('javascript')
    <script type="text/javascript">
        $(function(){
            $('#phone').blur(function(){
                $.get("{{route('exist')}}",{'phone':$('#phone').val()},function(data){
                    if(data==0){
                        $('.phone_error').html('该电话号码已被注册');
                    }else{
                        $('.phone_error').html('');
                    }
                });
            });
        });
        function re_captcha() {
            $url = "{{ URL('kit/captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('captcha').src=$url;
        }
    </script>
@stop




