@extends('common/tuijianren_layout')

@section('content')
    <div class="panel panel-default">
        @include('common.message')
        <div class="list-group">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>姓名</th>
                    <th>电话</th>
                    <th>成交量</th>
                    <th>金额(元)</th>
                    <th>佣金(元)</th>
                    <th>添加时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($beituijianrens as $b)
                <tr>
                   <td>{{$b->username}}</td>
                    <td>{{$b->phone}}</td>
                    <td>{{$b->count}}</td>
                    <td>{{$b->money}}</td>
                    <td>{{$b->commission}}</td>
                    <td>{{date('Y-m-d H:i',$b->created_at)}}</td>
                    <td>{{date('Y-m-d H:i',$b->updated_at)}}</td>
                    <td><a href="{{url('tuijianren/edit',['id'=>$b->id])}}">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm('确定要删除吗？'))location.href='{{url('tuijianren/del',['id'=>$b->id])}}'">删除</a></td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@stop