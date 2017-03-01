@extends('common.admin_layout')
@section('content')
    @include('common.message')
    <div class="panel panel-default">
        <div class="panel-heading">添加商家</div>
        <div class="panel-body">

            <form class="form-horizontal" method="post" action="">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">商家名称</label>

                    <div class="col-sm-5">
                        <input type="text" name="Shop[shopname]" class="form-control" id=""
                               value="{{old('Shop')['shopname']}}"
                               placeholder="请输入商家名称">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Shop.shopname')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">门牌号</label>

                    <div class="col-sm-5">
                        <input type="text" name='Shop[doorno]' class="form-control" id="doorno"
                               value="{{old('Shop')['doorno']}}"
                               placeholder="请输入门牌号" onblur="door_exist()">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger doorno">@if(session('is_exist')){{session('is_exist')}}@else{{$errors->first('Shop.doorno')}}@endif</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">商家联系人</label>

                    <div class="col-sm-5">
                        <input type="text" name='Shop[username]' class="form-control" id=""
                               value="{{old('Shop')['username']}}"
                               placeholder="请输入商家联系人">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Shop.username')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">电话</label>

                    <div class="col-sm-5">
                        <input type="text" name='Shop[phone]' class="form-control" id="phone"
                               value="{{old('Shop')['phone']}}"
                               placeholder="请输入手机号">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Shop.phone')}}</p>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
       function   door_exist(){
           $.get("{{url('doorno_exist')}}",{doorno:$('#doorno').val()},function(data){
            if(data==1){
             $('.doorno').html('');
            }else{
                $('.doorno').html('该门牌号的商家已添加!');
            }

           });
       }
    </script>
@stop

