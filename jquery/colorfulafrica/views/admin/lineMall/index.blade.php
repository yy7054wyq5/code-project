@extends('admin.adminbase')
@section('title', '线下商店管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">线下商店管理</h3>
        </div>
        <div class="box-body">
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.mallManage.addMall.id'),$jurisdiction))
                     <a href="{{url('/backstage/commodity/add-mall')}}" class="btn btn-primary">新增门店介绍</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>门店名称</th>
                        <th>英文门店名称</th>
                         <th >点赞数</th>
                        <th>评价</th>
                        <th >详情</th>
                        <th>门店缩略图</th>
                        <th>操作</th>
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
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.mallManage.editMall.id'),$jurisdiction))
                                           <a href="/backstage/commodity/edit-mall/{{$list['id']}}?start={{Input::get('start',0)}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.mallManage.removeMall.id'),$jurisdiction))
                                           <a href="/backstage/commodity/remove-mall/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                        @endif
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