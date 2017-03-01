@extends('common.admin_layout')

@section('content')

@include('common.message')
        <!-- 自定义内容区域 -->
<div class="panel panel-default">
    <div><span>成交总额(元)：{{$data['money']}}</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span>成交量（单）：{{$data['szmno']}}</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span>佣金总额（元）：{{$data['commission']}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
        <span>已结算（元）：{{$data['commission1']}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
        <span>未结算（元）：{{$data['commission0']}}</span></div>
    <br/>
    <div class="list-group">
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th>姓名</th>
                <th>电话</th>
                {{--<th>商家ID</th>--}}
                <th>消费时间</th>
                <th>金额</th>
                <th>佣金</th>
                {{--<th>推荐人ID</th>--}}
                <th>数字码</th>
                <th>创建时间</th>
                <th>结算时间</th>
                <th>结算</th>
                {{--<th>操作</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($szms as $s)
                <tr>
                    <td>{{$s->username}}</td>
                    <td>{{$s->phone}}</td>
                    {{--<td>{{$s->shop}}</td>--}}
                    <td>{{date('m-d H:i',$s->order_time)}}</td>
                    <td>￥{{$s->money}}</td>
                    <td>￥{{$s->commission}}</td>
                    {{--<td>{{$s->tuijianren}}</td>--}}
                    <td>{{$s->szm}}</td>
                    <td>{{date('m-d H:i',$s->created_at)}}</td>
                    <td>{{date('m-d H:i',$s->updated_at)}}</td>
                    <td>@if($s->is_over==1) 已结@else 未结 @endif</td>
                    {{--<td><a href="">操作</a></td>--}}

                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $szms->links() !!}
    </div>
</div>

<!-- 分页  -->
<div>
    <div class="pull-right">

    </div>
</div>
@stop
