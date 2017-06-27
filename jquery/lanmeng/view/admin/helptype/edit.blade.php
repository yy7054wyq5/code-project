@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
    </style>
    <div class="row">
        <div class="col-md-12">
            <!-- BOX -->
            <div class="box border primary">
                <div class="box-title">
                    <h4><i class="fa fa-table"></i>修改帮助分类</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类名</label>
                            <div class="col-sm-4">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                                <input type="hidden" id="qid" name="typeId" value="{{$lists->typeId}}" />
                                <input type="text" name="typeName"  value="{{$lists->typeName}}" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button onclick="return store()" class="btn btn-primary">保存</button>
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

<script type="text/javascript" >
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/helptype/edit",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    if(!msg['status']){
                        setTimeout("reload()", 1200)
                    }
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/helptype/index';
    }
</script>
