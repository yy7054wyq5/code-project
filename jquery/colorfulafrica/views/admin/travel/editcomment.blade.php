@extends('admin.adminbase')

@section('title', '编辑商品')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">编辑商品</h3>
        </div>
        <form action="{{url('/backstage/travel/edit-comment')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="resourceId" value="{{$detail['resourceId']}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">回帖者昵称</label>
                    <div class="col-sm-4">
                        <input  type="text" readonly="true" class="form-control" value="{{$detail['nickname']}}" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">回帖者头像</label>
                    <div class="col-sm-4">
                        <div id="image"><image style="width:150px; height:150px;" src="/image/get/{{$detail['picKey']}}" /></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">帖子内容</label>
                    <div class="col-sm-6">
                        <textarea  name="content" rows="5" class="form-control" >{{$detail['content']}}</textarea>
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