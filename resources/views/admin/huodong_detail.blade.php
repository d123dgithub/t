@extends('common.admin_layout')
@section('content')
    @include('common.message')
    <div class="panel panel-default">
        <div class="panel-heading">活动详情</div>
        <div class="panel-body">


                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">活动名称</label>
                      {{$huodong->name}}
                </div>
                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">活动负责人</label>
                        {{$huodong->username}}
                </div>

                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">活动负责人电话</label>
                        {{$huodong->phone}}
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">开始时间</label>
                        {{date('Y-m-d',$huodong->open_time)}}
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">结束时间</label>
                    {{date('Y-m-d',$huodong->close_time)}}
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">活动简介</label>
                    <div  style="word-break: break-all	;">
                        {{$huodong->intro}}
                    </div>

                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">活动内容</label>
                    <div style="word-break: break-all	;">
                        {{$huodong->info}}
                    </div>


                </div>

        </div>
    </div>
@stop

@section('javascript')


@stop

