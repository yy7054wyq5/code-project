@extends('admin.adminbase')
@section('title', '权限设置')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
        .editor-class { width: 800px;}
        .specimage1{
            position: relative;
            overflow: hidden;
            background: #00B7EE;
            border-color: #00B7EE;
            color: #fff;
        }
        .t1{
            position: absolute;
            top: 0;
            left: 0;
            font-size: 20px;
            opacity: 0;
        }
        .t2{
            margin: 5px 0;
        }
    </style>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增模块</h3>
        </div>
        <form action="<?= url('admin/system/addmodule') ?>" class="form-horizontal" method="post" m-bind="ajax">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>

                <div class="form-group spec" data-index="1">
                    <label for="" class="control-label col-sm-2 required"></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-addon">中文名</div>
                            <input type="text" class="form-control" name="name[1]">
                            <div class="input-group-addon">英文名</div>
                            <input type="text" class="form-control" name="nameEn[1]">
                            <div class="input-group-addon">控制器</div>
                            <input type="text" class="form-control" name="controller[1]">
                            <div class="input-group-addon">方法</div>
                            <input type="text" class="form-control" name="action[1]">
                            <div class="input-group-addon" onclick="$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>
                        </div>
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