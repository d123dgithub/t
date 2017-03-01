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
                <th>ID</th>
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
                {{--<th>结算</th>--}}
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($szms as $s)
                <tr>
                    <td>{{$s->id}}</td>
                    <td>{{$s->username}}</td>
                    <td>{{$s->phone}}</td>
                    {{--<td>{{$s->shop}}</td>--}}
                    <td>{{date('m-d',$s->order_time)}}</td>
                    <td>￥{{$s->money}}</td>
                    <td>￥{{$s->commission}}</td>
                    {{--<td>{{$s->tuijianren}}</td>--}}
                    <td>{{$s->szm}}</td>
                    <td>{{date('m-d H:i',$s->created_at)}}</td>
                    <td>{{date('m-d H:i',$s->updated_at)}}</td>
                    {{--<td>@if($s->is_over==1) 已结@else 未结 @endif</td>--}}
                    <td>
                        @if($s->is_over==1) 已结@else <a href="{{url('js',['id'=>$s->id])}}" rel="{{$s->id}}" class="js">结算</a> @endif</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="2">本页合计</td>
                <td colspan="2">金额(元):{{$curr['curr_money']}}</td>
                <td colspan="2">已结佣金(元):{{$curr['curr_commission1']}}</td>
                <td colspan="2">未结佣金(元):{{$curr['curr_commission0']}}</td>
                <td colspan="2"><a @if($curr['ids']=='') href="javascript:alert('本页佣金已结清')"@else href="{{url('many_js',['ids'=>urldecode($curr['ids'])])}}" @endif>本页结算</a></td>
            </tr>
            </tbody>
        </table>
        {!! $szms->links() !!}
    </div>
</div>

@stop

@section('javascript')
    <script type="text/javascript">

        {{--$(function(){--}}
            {{--$('.js').click(function(){--}}
                {{--$.get("{{url('js')}}",{id:$(this).attr('rel')},function(data){--}}
                    {{--if(data)--}}
                    {{----}}
                {{--});--}}
                {{----}}
            {{--});--}}
            {{----}}
            {{----}}
        {{--});--}}
    </script>
@stop
