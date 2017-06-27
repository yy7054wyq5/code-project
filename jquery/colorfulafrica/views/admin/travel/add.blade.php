@extends('admin.adminbase')

@section('title', '新增版块')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增版块</h3>
        </div>
        <form action="<?= url('/backstage/travel/add-category') ?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">版块名称</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入版块名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">版块英文名称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入版块英文名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">层级</label>
                    <div class="col-sm-4">
                        <input name="level" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入层级</p>
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