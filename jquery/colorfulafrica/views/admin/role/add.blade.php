@extends('admin.adminbase')
@section('title', '新增角色')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增角色</h3>
        </div>
        <form action="<?= url('/backstage/role/add-role') ?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">角色名称</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入角色名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">英文角色名称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入英文角色名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">角色权限</label>
                    <div class="col-sm-4">

                        <table class="table table-striped table-hover table-bordered"  >
                            <thead>
                            <tr>
                                <td width="15%">选择</td>
                                <th width="45%">模块名称</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($list) && count($list))
                                @foreach($list as $item)
                                <tr>
                                    <td><input type="checkbox" name="rules[]" value="{{$item['id']}}"   /></td>
                                    <td>{{$item['name']}}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认添加</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
@endsection