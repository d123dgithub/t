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
                <th>名称</th>
                <th>负责人</th>
                <th>电话</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($huodongs as $h)
                <tr>
                    <td>{{$h->id}}</td>
                    <td>{{$h->name}}</td>
                    <td>{{$h->username}}</td>
                    <td>{{$h->phone}}</td>
                    <td>{{date('m-d',$h->open_time)}}</td>
                    <td>{{date('m-d',$h->close_time)}}</td>
                    <td>{{date('m-d H:i',$h->created_at)}}</td>
                    <td>{{date('m-d H:i',$h->updated_at)}}</td>
                    <td>
                        <a href="{{url('huodong/detail',['id'=>$h->id])}}">查看</a> &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{url('huodong/eidt',['id'=>$h->id])}}">编辑</a> &nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="javascript:if(confirm('确定删除吗？'))location.href='{{url('huodong/delete',['id'=>$h->id])}}'">删除</a></td>
                </tr>
            @endforeach

            </tbody>
        </table>
        {!! $huodongs->links() !!}
    </div>
</div>


@stop
