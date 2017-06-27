@extends('admin.adminbase')
@section('title', '平台管理员列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">平台管理员列表</h3>
        </div>
        <div class="box-body">
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.adminlist.addPlat.id'),$jurisdiction))
                   <a href="<?=url('backstage/account/add-plat')?>" class="btn btn-primary">添加平台管理员</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="75%" >用户名</th>
                        <th width="15%" >操作</th>
                    </tr>
                    </thead>
                    <tbody>
                     @if(!empty($adminUsers))
                     @foreach ($adminUsers as $user)
                    <tr>
                        <td><?=$user['id']?></td>
                        <td><?=$user['uname']?></td>
                        <td>
                            @if(in_array(\Illuminate\Support\Facades\Config::get('app.adminlist.modifyPlat.id'),$jurisdiction))
                                <a href="<?=url('backstage/account/modify-plat?userId=' . $user['id'] . '&start=' . Input::get('start', 0))?>" class='label label-primary'>修改</a>&nbsp;
                            @endif
                            @if(in_array(\Illuminate\Support\Facades\Config::get('app.adminlist.delPlat.id'),$jurisdiction))
                                <a href="<?=url('backstage/account/delete-plat?userId=' . $user['id'])?>"  class='label label-danger' m-bind='confirm'>删除</a></td>
                            @endif
                    </tr>
                     @endforeach
                     @else
                    <tr>
                        <td colspan="4" class="text-muted">未找到数据……</td>
                    </tr>
                     @endif
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                {!!$pager!!}
            </div>
        </div>
    </div>
@endsection