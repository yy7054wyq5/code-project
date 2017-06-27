@extends('admin.adminbase')
@section('title', '编辑文章')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">编辑文章</h3>
        </div>
        <form action="<?= url('/backstage/about/edit-about') ?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">标题</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control" value="{{$list['name']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">英文标题</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control" value="{{$list['nameEn']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入英文标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">图文</label>
                    <div class="col-sm-8">
                        <textarea name="describe" type="password" id="container" >{{$list['describe']}}</textarea>
                    </div>
                </div>
                <!-- <div class="form-group">
                     <label for="username" class="control-label col-sm-2 required">英文图文</label>
                     <div class="col-sm-8">
                         <textarea name="describeEn" type="password" id="container" ></textarea>
                     </div>-->
                 </div>
                <div class="box-footer">
                    <div class="col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">确认更新</button>
                        <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                    </div>
                </div>
        </form>
    </div>
@endsection