@extends('common.admin_layout')
@section('content')
    @include('common.message')
    <div class="panel panel-default">
        <div class="panel-heading">添加活动</div>
        <div class="panel-body">

            <form class="form-horizontal" method="post" action="">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">活动名称</label>

                    <div class="col-sm-5">
                        <input type="text" name="Huo[name]" class="form-control" id=""
                               value="{{old('Huo')['name']}}"
                               placeholder="请输入活动名称">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Huo.name')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">活动负责人</label>

                    <div class="col-sm-5">
                        <input type="text" name='Huo[username]' class="form-control" id="doorno"
                               value="{{old('Huo')['username']}}"
                               placeholder="请输入活动负责人">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger doorno">{{$errors->first('Huo.username')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">活动负责人电话</label>

                    <div class="col-sm-5">
                        <input type="text" name='Huo[phone]' class="form-control" id=""
                               value="{{old('Huo')['phone']}}"
                               placeholder="请输入活动负责人电话">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Huo.phone')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">开始时间</label>


                    <div class="col-sm-5">
                        <input class="datainp" id="open_time" name='Huo[open_time]' type="text" placeholder="请选择" readonly>
                    </div>

                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Huo.open_time')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">结束时间</label>

                    <div class="col-sm-5">
                        <input class="datainp" id="close_time" name='Huo[close_time]' type="text" placeholder="请选择" readonly>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Huo.close_time')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">简介(50字内)</label>

                    <div class="col-sm-5">


             <textarea name='Huo[intro]'  id="intro" class="form-control">
  {{old('Huo')['intro']}}
             </textarea>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Huo.intro')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">内容(500字内)</label>

                    <div class="col-sm-5">

                              <textarea name='Huo[info]'  id='info' class="form-control" rows="20">
                       {{old('Huo')['info']}}
                              </textarea>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Huo.info')}}</p>
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

    <script type="text/javascript" src="{{asset('static/jedate/jedate.js')}}"></script>
    <script type="text/javascript">
        $("#intro").keyup(function(){
            var len = $(this).val().length;
            if(len > 50){
                $(this).val($(this).val().substring(0,50));
            }

        });
        $("#info").keyup(function(){
            var len = $(this).val().length;
            if(len > 500){
                $(this).val($(this).val().substring(0,500));
            }
        });


        jeDate({
            dateCell: "#open_time",
            format: "YYYY-MM-DD",
            isinitVal: true,
            isTime: true, //isClear:false,
            minDate: "2014-09-19",
            okfun: function (val) {
                alert(val)
            }
        })
        jeDate({
            dateCell: "#close_time",
            format: "YYYY-MM-DD",
            isinitVal: true,
            isTime: true, //isClear:false,
            minDate: "2014-09-19",
            okfun: function (val) {
                alert(val)
            }
        })


    </script>
@stop

