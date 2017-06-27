@extends('admin.adminbase')

@section('title', '游记管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">审核</h3>
        </div>
        <form action="<?= url('/backstage/travel/examine') ?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$detail['id']}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">标题</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" readonly="true" class="form-control" value="{{$detail['name']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">状态</label>
                    <div class="col-sm-2">
                        <select name="status" class="form-control">
                            <option value="0" @if($detail['status'] == 0) selected="selected" @endif >未审核</option>
                            <option value="1" @if($detail['status'] == 1) selected="selected" @endif  >审核通过</option>
                            <option value="2" @if($detail['status'] == 2) selected="selected" @endif  >审核未通过</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
@endsection