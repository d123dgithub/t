@extends('common.layouts')
@section('leftmenu')
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">管理员设置</div>
        <div class="panel-body">

            <form class="form-horizontal" method="post" action="{{url('tuiguangadmin/create')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">账号</label>

                    <div class="col-sm-5">
                        <input type="text" name="Admin[username]" class="form-control" id="username"
                               value="{{old('Admin')['username']}}"
                               placeholder="请输入推荐人姓名" onblur="exist('username')">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger username_error">@if(Session::has('username_is_exist')){{Session::get('username_is_exist')}}@else{{$errors->first('Admin.username')}}@endif</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">电话</label>

                    <div class="col-sm-5">
                        <input type="text" name='Admin[phone]' class="form-control" id="phone"
                               value="{{old('Admin')['phone']}}"
                               placeholder="请输入推荐人手机号"  onblur="exist('phone')">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">@if(Session::has('is_exist')){{Session::get('is_exist')}}@else{{$errors->first('Admin.phone')}}@endif</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">密码</label>

                    <div class="col-sm-5">
                        <input type="password" name='Admin[password]' class="form-control" id=""
                               value=""
                               placeholder="请输入密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Admin.password')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">确认密码</label>

                    <div class="col-sm-5">
                        <input type="password" name='Admin[password_confirmation]' class="form-control" id=""
                               value=""
                               placeholder="请输入确认密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Admin.password_confirmation')}}</p>
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
        function  exist(para){

            $.get("{{route('admin_exist')}}",{para:$('#'+para).val(),iswhat:para},function(data){
                if(data==0){
                    var para_name=para=='phone'?'电话':'账号';
                    $('.'+para+'_error').html('该'+para_name+'号码已被注册');
                }else{
                    $('.'+para+'_error').html('');
                }
            });
        }
        function re_captcha() {
            $url = "{{ URL('kit/captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('captcha').src=$url;
        }
    </script>
@stop




