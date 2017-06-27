@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>模块管理</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">模块分类</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <select class="form-control" name="module[parentid]">
                        @if ($lists)
                        @foreach ($lists as $value)
                            <option value="{{ $value->moduleid }}">{{ $value->modulename }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">模块名称</label>
                <div class="col-sm-4">
                    <input type="text" name="module[modulename]" placeholder="请输入模块名称" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">模块Tag</label>
                <div class="col-sm-4">
                    <input type="text" name="module[moduletag]" placeholder="请输入模块Tag" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">请输入类似Tag,便于管理:Controller/Method</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button onclick="return store()" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function store()
{
    $.ajax({
        type: "POST",
        url:"/superman/index/storemodule",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips'])
        },
        error: function(error){
            layer.msg("操作失败")
        }
    });
}
</script>
@stop