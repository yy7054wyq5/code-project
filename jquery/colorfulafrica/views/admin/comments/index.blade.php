@extends('admin.adminbase')
@section('title', '帖子管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">帖子列表</h3>
        </div>
        <div class="box-body">
             <form action="/backstage/system/module" method="get">
               <div class="form-group">
                    <label for="" class="control-label col-sm-1">产品名称</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info  btn-xs">搜索</button>
                </div>
                </form>
          <!--  <p><a href="{{--url('/admin/commodity/add-product')--}}" class="btn btn-primary">新增商品</a></p> -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="30%">帖子内容</th>
                        <th width="15%">用户昵称</th>
                        <th width="15%">用户头像</th>
                        <th width="25%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($lists) && count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['content']}}</td>
                                <td>{{$list['nickname']}}</td>
                                <td><img src="/image/get/{{$list['picKey']}}" style="width:50px; height: 50px;" /> </td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        <a href="/backstage/commodity/edit-product/{{$list['id']}}" class="label label-success" >编辑</a>
                                        <a href="/backstage/commodity/edit-product/{{$list['id']}}" class="label label-primary" >回复</a>
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
            @if(isset($pager))
             {!!$pager!!}
            @endif
        </div>
    </div>
@endsection