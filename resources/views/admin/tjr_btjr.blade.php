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
                <th>成交量</th>
                <th>金额</th>
                <th>佣金</th>
                <th>创建时间</th>
                <th>修改时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($beituijianrens as $t)
                <tr>
                    <td>{{$t->id}}</td>
                    <td>{{$t->username}}</td>
                    <td>{{$t->phone}}</td>
                    <td>{{$t->count}}</td>
                    <td>{{$t->money}}</td>
                    <td>{{$t->commission}}</td>
                    <td>{{date('Y-m-d H:i',$t->created_at)}}</td>
                    <td>{{date('Y-m-d H:i',$t->updated_at)}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $beituijianrens->links() !!}
    </div>
</div>

<!-- 分页  -->
<div>
    <div class="pull-right">
        {{--{{$students->render()}}--}}
    </div>
</div>
@stop
