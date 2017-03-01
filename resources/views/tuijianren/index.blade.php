@extends('common.layouts')
<style>
    .list-group-item{
        margin:0 auto;
        text-align : center ;
    }
</style>


@section('content')

@include('common.message')
        <!-- 自定义内容区域 -->
<div class="panel panel-default">
    <div class="list-group">
                推广规则或者介绍
        </div>
</div>

<!-- 分页  -->
<div>
    <div class="pull-right">
        {{--{{$students->render()}}--}}
    </div>
</div>
@stop
