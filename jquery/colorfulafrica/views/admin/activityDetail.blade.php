@extends('admin.adminbase')
@section('title', '活动列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{array_get($detail,'name')}}详情</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered detail">
                <tbody>
                    <tr>
                        <th>标题</th>
                        <th>{{array_get($detail,'name')}}</th>
                    </tr>
                    <tr>
                        <th>发布者</th>
                        <th>{{array_get($detail,'userInfo')?array_get($detail,'userInfo')['nickname'] : ''}}</th>
                    </tr>
                    <tr>
                        <th>发布者电话</th>
                        <th>{{array_get($detail,'userInfo')?array_get($detail,'userInfo')['mobile'] : ''}}</th>
                    </tr>
                    <tr>
                        <th>活动类型</th>
                        @if(array_get($detail,'type') == 1)
                            <th>圈子</th>
                        @else
                            <th>个人</th>
                        @endif
                    </tr>
                    <tr>
                        <th>活动详情说明</th>
                        <th>{{array_get($detail,'description')}}</th>
                    </tr>
                    <tr>
                        <th>开始时间</th>
                        <th>{{array_get($detail,'timeStart')}}</th>
                    </tr>
                    <tr>
                        <th>结束时间</th>
                        <th>{{array_get($detail,'timeEnd')}}</th>
                    </tr>
                    <tr>
                        <th>活动地址</th>
                        <th>{{array_get($detail,'address')}}</th>
                    </tr>
                    <tr>
                        <th>活动单价</th>
                        <th>{{array_get($detail,'fee')}}元</th>
                    </tr>
                    <tr>
                        <th>参与人数</th>
                        <th>{{array_get($detail,'sumJoiners')}}人</th>
                    </tr>
                    <tr>
                        <th>活动兴趣</th>
                        <th>
                            @if(array_get($detail,'interests'))
                                {{implode(',', \App\Utils\Helpers::array2ValueList(array_get($detail,'interests'), 'name'))}}
                            @endif
                        </th>
                    </tr>
                    @if(array_get($detail,'deleted') == 0)
                    <tr>
                        <th>更多详情</th>
                        <th><a class="col-sm-2" role="button" target="_self" href="/admin/activity/joiners?activityId={{array_get($detail,'id')}}">参与信息列表</a><a class="col-sm-2" role="button" target="_self" href="/admin/activity/images?activityId={{array_get($detail,'id')}}">活动相册</a><a class="col-sm-2" role="button" target="_self" href="/admin/activity/comments?activityId={{array_get($detail,'id')}}">活动评论列表</a></th>
                    </tr>
                    @endif
                </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>


@endsection