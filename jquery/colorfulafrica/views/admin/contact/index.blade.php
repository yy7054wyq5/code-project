@extends('admin.adminbase')
@section('title', '联系我们')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">联系我们列表</h3>
        </div>
        <div class="box-body">
             <form action="/backstage/contact/list" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">标题</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
                </form>
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.contactManage.addContact.id'),$jurisdiction))
                   <a href="{{url('/backstage/contact/add-article')}}" class="btn btn-primary">新增文章</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="10%">标题</th>
                        <th width="10%">英文标题</th>
                        <th width="10%">发布时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($lists) && count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td width="35%" >{{$list['name']}}</td>
                                <td width="35%" >{{$list['nameEn']}}</td>
                                <td width="20%" >{{$list['createTime']}}</td>
                                <td width="10%" >
                                    @if($list['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.contactManage.editContact.id'),$jurisdiction))
                                           <a href="/backstage/contact/edit-article/{{$list['id']}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.contactManage.removeContact.id'),$jurisdiction))
                                           <a href="/backstage/contact/remove/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
            {{isset($pager) && $pager}}
        </div>
    </div>
@endsection