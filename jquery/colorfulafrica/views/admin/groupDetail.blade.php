@extends('admin.adminbase')
@section('title', '圈子列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$detail['name']}}圈子</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered detail">
                <tbody>
                <tr>
                    <th>组织名称</th>
                    <th>{{$detail['name']}}</th>
                </tr>
                <tr>
                    <th>组织介绍</th>
                    <th>{{$detail['description']}}</th>
                </tr>

                <tr>
                    <th>组织兴趣</th>
                    <th>
                    @if(array_get($detail,'interests'))
                        {{implode(',', \App\Utils\Helpers::array2ValueList(array_get($detail,'interests'), 'name'))}}
                    @endif
                    </th>
                </tr>
                <tr>
                    <th>发布者</th>
                    <th>{{array_get($detail,'creater')?array_get($detail,'creater')['nickname'] : ''}}</th>
                </tr>
                <tr>
                    <th>发布者电话</th>
                    <th>{{array_get($detail,'creater')?array_get($detail,'creater')['mobile'] : ''}}</th>
                </tr>
                <tr>
                    <th>成员列表</th>
                    <th><a role="button" target="_self" href="/admin/group/joiners?groupId={{array_get($detail,'id')}}">点击查看</a></th>
                </tr>
            </tbody>
            </table>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>


@endsection