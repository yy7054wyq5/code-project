@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>QQ客服修改</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">客服名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" id="qid" value="{{ $info->id }}">
                    <input type="text" name="user[name]" placeholder="请输入客服名称" value="{{ $info->name }}" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">QQ号码</label>
                <div class="col-sm-4">
                    <input type="text" name="user[qq]" placeholder="请输入客服QQ号码" value="{{ $info->qq }}" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示顺序</label>
                <div class="col-sm-4">
                    <input type="text" name="user[num]" placeholder="请输入显示顺序" value="{{ $info->num }}" class="form-control" />
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
        url:"/superman/system/update/" + $('#qid').val(),
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips'])
            if (msg['status'] == 0) {
                setTimeout("reload()", 1000)
            };
        },
        error: function(error){
            layer.msg("操作失败")
        }
    });
}
function reload()
{
    location.href = '/superman/system/qq';
}
</script>
@stop