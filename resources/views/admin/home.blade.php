@extends('common.admin_layout')
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
        <table class="table table-striped table-hover table-responsive">
            <tr><td>总金额(元)：{{$data['money']}}</td></tr>
            <tr><td>总成交(单)：{{$data['szmno']}}</td></tr>
            <tr><td>总佣金(元)：{{$data['commission']}}</td></tr>
            <tr><td>已结佣金(元)：{{$data['commission1']}}</td></tr>
            <tr><td>未结佣金(元)：{{$data['commission0']}}</td></tr>
            <tr><td>商家数量(家)：{{$data['shopno']}}</td></tr>
            <tr><td>推荐人数量(个)：{{$data['tuijianrenno']}}</td></tr>
            <tr><td>被推荐人数量(个)：{{$data['beituijianrenno']}}</td></tr>
        </table>
    </div>
</div>
@stop
