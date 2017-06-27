@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>友情链接添加</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">网站名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="text" name="link[title]" placeholder="请输入网站名称" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">链接地址</label>
                <div class="col-sm-4">
                    <input type="text" name="link[url]" placeholder="请输入链接地址" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示顺序</label>
                <div class="col-sm-4">
                    <input type="text" name="link[sort]" placeholder="请输入显示顺序" class="form-control" />
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
        url:"/superman/system/storelink",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips'])
            if (msg['status'] == 0) {
                window.location.href = '/superman/system/link';
            };
        },
        error: function(error){
            layer.msg("操作失败")
        }
    });
}
</script>
@stop