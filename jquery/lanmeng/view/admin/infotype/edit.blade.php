@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="box border primary">
                <div class="box-title">
                    <h4><i class="fa fa-table"></i>添加信息类别</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="typeid" id="token" value="{{ $lists->typeid}}">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别名称</label>
                            <div class="col-sm-4">
                                {!! Form::text("type_name",$lists->type_name,['class' => 'form-control'])!!}
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                            </div>
                        </div>
                      <!--  <div class="form-group">
                            <label class="col-sm-2 control-label">修改时间</label>
                            <div class="col-sm-4">
                                {!! Form::text("updated",$lists->updated,['class' => 'form-control'])!!}
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button onclick="return store()" class="btn btn-primary">确定</button>
                                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

{!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
{!! HTML::script('uploadify/jquery.uploadify.min.js')!!}
{!! HTML::style('uploadify/uploadify.css') !!}

{!!HTML::script('super/ueditor/ueditor.config.js')!!}
{!!HTML::script('super/ueditor/ueditor.all.min.js')!!}
{!!HTML::script('super/ueditor/lang/zh-cn/zh-cn.js')!!}

<script type="text/javascript" >
    var ue = UE.getEditor('editor');
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/infotype/edit",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/infotype/index';
    }
</script>
