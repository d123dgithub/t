@extends('common.admin_layout')
@section('style')
    <style>
        .datainp{ width:120px; height:30px; border:1px #ccc solid;}
        .datep{ margin-bottom:40px;}
    </style>
@stop
@section('content')
    @include('common.message')
    <div class="panel panel-default">
        <div class="panel-heading">登记获取数字码</div>
        <div class="panel-body">

            <form class="form-horizontal" method="post" action="">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">被推荐人姓名</label>

                    <div class="col-sm-5">
                        <input type="text" name="Dj[username]" class="form-control" id=""
                               value="{{old('Dj')['username']}}"
                               placeholder="请输入被推荐人姓名" >
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Dj.username')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">被推荐人电话</label>

                    <div class="col-sm-5">
                        <input type="text" name='Dj[phone]' class="form-control" id="phone"
                               value="{{old('Dj')['phone']}}"
                               placeholder="请输入被推荐人电话" onblur="search_tuijianren()">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger doorno">{{$errors->first('Dj.phone')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">商家</label>

                    <div class="col-sm-5" style="width: 80%">

                        <?php  $i = 0;?>
                        @foreach($shops as $s)
                            <input name="Dj[shop]" value="{{$s->id}}" type="radio">{{$s->shopname}}
                            <?php  $i++;?>
                            @if($i%10==0)
                                <br/>
                            @endif
                        @endforeach

                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('Dj.shop')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">开票时间</label>

                    <div class="col-sm-5">
                        <input class="datainp" id="dateinfo" name='Dj[order_time]' type="text" placeholder="请选择"  readonly>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Dj.order_time')}}</p>
                    </div>
                </div>


                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">金额（元）</label>

                    <div class="col-sm-5">

                        <input type="text" name='Dj[money]' class="form-control" id="doorno" value="{{old('Dj')['money']}}" placeholder="请输入消费金额">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Dj.money')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">推荐人</label>

                    <div class="col-sm-5  tuijianren_radio">

                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger phone_error">{{$errors->first('Dj.tuijianren')}}</p>
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
     function search_tuijianren(){
     $('.tuijianren_radio').html('');
         $.get("{{url('search_tuijianren')}}",{phone:$('#phone').val()},function(data){
            var data= JSON.parse(data);
             var html=''
             $(data).each(function(){
                 var  radio_text="<span>"+this.username+':'+this.phone+"</span>";
                 html+="<input name='Dj[tuijianren]' value="+this.id+" type='radio'>"+radio_text;

             })

             $(html).appendTo('.tuijianren_radio');
             return;
         })
     }

        jeDate({
            dateCell:"#dateinfo",
            format:"YYYY-MM-DD",
            isinitVal:true,
            isTime:true, //isClear:false,
            minDate:"2014-09-19",
            okfun:function(val){alert(val)}
        })
    </script>
@stop

