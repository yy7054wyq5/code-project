@extends('admin.adminbase')
@section('title', '线下商店管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">线下商店管理</h3>
        </div>
        <div class="box-body">
            <p><a href="{{url('/backstage/commodity/add-mall')}}" class="btn btn-primary">新增门店介绍</a></p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="35">门店名称</th>
                        <th width="35">英文门店名称</th>
                        <th width="35%">门店缩略图</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['nameEn']}}</td>
                                <td><img src="/image/get/{{$list['picKey']}}" style="width:50px; height: 50px;" /> </td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        <a href="/backstage/line/edit-category/{{$list['id']}}" class="label label-success" >编辑</a>
                                        <a href="/backstage/adinfo/remove-ad/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <?php //echo $pager ?>
        </div>
    </div>
@endsection