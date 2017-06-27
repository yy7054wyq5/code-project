@extends('admin.adminbase')
@section('title', '私人订制')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">私人订制</h3>
        </div>
        <form action="{{url('/backstage/line/add-invest')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <input type="hidden" name="id" value="{{isset($invest)?$invest['qid']:''}}">
            <input type="hidden" name="start" value="{{Input::get('start',0)}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">标题</label>
                    <div class="col-sm-4">
                        <input name="title" id="name" type="text"  value="{{isset($invest)?$invest['title']:''}}" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入标题(不能超过50字)</p>
                    </div>
                </div>

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
