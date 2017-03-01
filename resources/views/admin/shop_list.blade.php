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
                <th>店铺名称</th>
                <th>门牌号</th>
                <th>联系人</th>
                <th>电话</th>
                <th>成交量</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($shops as $t)
                <tr>
                    <td>{{$t->id}}</td>
                    <td>{{$t->shopname}}</td>
                    <td>{{$t->doorno}}</td>
                    <td>{{$t->username}}</td>
                    <td>{{$t->phone}}</td>
                    <td>{{$t->count}}</td>
                    <td>{{date('m-d H:i',$t->created_at)}}</td>
                    <td>{{date('m-d H:i',$t->updated_at)}}</td>
                    <td>
                        <a href="{{url('szm/list',['id'=>$t->id,'who'=>'shop'])}}">商家数字码</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{url('admin_sj_edit',['id'=>$t->id])}}">编辑</a> &nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="javascript:if(confirm('确定删除吗？'))location.href='{{url('admin_sj_delete',['id'=>$t->id])}}'">删除</a></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5">本页合计</td>
                <td colspan="6">成交量(单):{{$curr_count}}</td>
            </tr>
            </tbody>
        </table>
        {!! $shops->links() !!}
    </div>
</div>

<!-- 分页  -->
<div>
    <div class="pull-right">
        {{--{{$students->render()}}--}}
    </div>
</div>
@stop
