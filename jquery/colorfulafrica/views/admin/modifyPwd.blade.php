@extends('admin.adminbase')

@section('title', '修改密码')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">修改密码</h3>
        </div>
        <form class="form-horizontal" name="form" action="modify-pwd" m-bind="ajax">
        <div class="box-body">
            <div class="alert alert-danger errMsgBox">
                <button class="close">&times;</button>
                <div class="result"></div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2">管理员名称:</label>
                <div class="col-sm-4">
                    <div class="form-control-static">
                        <b class="text-yellow"><?= array_get(session(config('app.adminUser')), 'uname')?></b>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="userId" value="<?= array_get(session(config('app.adminUser')),'userId') ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="pwd_od" class="control-label col-sm-2 required">旧密码:</label>
                <div class="col-sm-4">
                    <input type="password" name="password_old" id="pwd_od" class="form-control">
                </div>
                <div class="col-sm-6">
                    <p class="samll text-muted form-control-static">必填项</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pwd" class="control-label col-sm-2 required">新密码:</label>
                <div class="col-sm-4">
                    <input type="password" name="password_new" id="pwd" class="form-control">
                </div>
                <div class="col-sm-6">
                    <p class="samll text-muted form-control-static">必填项</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pwd2" class="control-label col-sm-2 required">确认新密码:</label>
                <div class="col-sm-4">
                    <input type="password" name="password_new_repeat" id="pwd2" class="form-control">
                </div>
                <div class="col-sm-6">
                    <p class="samll text-muted form-control-static">必填项,两次密码必须一致</p>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="col-sm-offset-2">
                <button class="btn btn-primary">保存修改</button>
                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
            </div>
        </div>
        </form>
    </div>
@endsection