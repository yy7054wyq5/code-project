@extends('admin.adminbase')
@section('title', '角色管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">角色管理</h3>
        </div>
        <div class="box-body">
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.rolelist.addRole.id'),$jurisdiction))
                    <a href="{{url('/backstage/role/add-role')}}" class="btn btn-primary">新增角色</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="35">角色名称</th>
                        <th width="35%">角色英文名称</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['nameEn']}}</td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.rolelist.editRole.id'),$jurisdiction))
                                           <a href="/backstage/role/edit-role/{{$list['id']}}?start={{Input::get('start',0)}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.rolelist.delRole.id'),$jurisdiction))
                                           <a href="/backstage/role/remove-ad/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
            <?php echo $pager ?>
        </div>
    </div>
@endsection