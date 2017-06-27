@extends('admin.adminbase')

@section('title', '新增城市')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增城市</h3>
        </div>
        <form action="{{url('/backstage/system/add-city')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">国家名称</label>
                            <div class="col-sm-2">
                                <select name="countryId" class="form-control"  >
                                    <option value="0">---请选择---</option>
                                    @if(isset($countries))
                                        @foreach($countries as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请选择国家</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">城市名称</label>
                            <div class="col-sm-4">
                                <input name="name" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入城市名称</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">英文城市名称</label>
                            <div class="col-sm-4">
                                <input name="nameEn" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入英文城市名称</p>
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