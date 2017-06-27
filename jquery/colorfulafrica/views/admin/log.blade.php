@extends('admin.adminbase')
@section('title', '后台操作日志下载')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">操作日志下载</h3>
        </div>

        <form name="form1" id="fileUpload" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">日志下载</label>
                    <div class="col-sm-6">
                        <a class="btn btn-info" href="/admin/config/download-log">下载</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection