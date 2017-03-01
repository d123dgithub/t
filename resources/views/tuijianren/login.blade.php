@extends('common.layouts')

@section('content')
    @include('common.message')
    <div class="panel panel-default">
        <div class="panel-heading">推荐人登录</div>
        <div class="panel-body">

            <form class="form-horizontal" method="post" action="{{url('tuijianren/login')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">手机号码</label>

                    <div class="col-sm-5">
                        <input type="text" name="phone" class="form-control" id=""
                               value="{{old('phone')}}"
                               placeholder="请输入推荐人手机号">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">密码</label>

                    <div class="col-sm-5">
                        <input type="password" name='password' class="form-control" id=""
                               value=""
                               placeholder="请输入密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
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
                        <button type="submit" class="btn btn-primary">登录</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        function re_captcha() {
            $url = "{{ URL('kit/captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('captcha').src=$url;
        }
    </script>
@stop