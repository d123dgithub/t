@extends('common.admin_layout')

@section('content')

@include('common.message')
        <!-- 自定义内容区域 -->
<div class="panel panel-default">
    <div class="list-group">
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>电话</th>
                <th>下线成交量</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tuijianrens as $t)
                <tr>
                    <td>{{$t->id}}</td>
                    <td>{{$t->username}}</td>
                    <td>{{$t->phone}}</td>
                    <td>{{$t->count}}</td>
                    <td>{{date('Y-m-d H:i',$t->created_at)}}</td>
                    <td>{{date('Y-m-d H:i',$t->updated_at)}}</td>
                    <td>
                        {{--<a href="{{url('admin_tjr_exit',['id'=>$t->id])}}">编辑</a>--}}
                        <a href="{{url('szm/list',['id'=>$t->id,'who'=>'tuijianren'])}}">查看数字码</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{url('tjr_btjr',['id'=>$t->id])}}">查看下线</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:if(confirm('确定删除吗？'))location.href='{{url('admin_tjr_delete',['id'=>$t->id])}}'">删除</a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">本页合计</td>
                <td colspan="3">成交量(单):{{$curr_count}}</td>
            </tr>
            </tbody>
        </table>
        {!! $tuijianrens->links() !!}
    </div>
</div>

@stop
