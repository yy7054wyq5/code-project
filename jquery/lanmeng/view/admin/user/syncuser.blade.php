@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>用户同步</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body big">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-sm-2 control-label">功能说明</label>
                <div class="col-sm-8">
                    <p>2016年2月18日以前注册的用户(包含所有时间段在原系统注册并导入本系统的用户)无法自动实现与论坛的同步登陆，需通过本功能进行同步.</p>
                    <p>请点击下面同意按钮完成同步操作!</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="submit" onclick="return store();" class="btn btn-primary">同意</button>
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
        url:"/superman/account/syncusersave",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg("系统正在同步会员数据，将在1秒后返回会员列表");
            setTimeout("reload()", 1000);
        },
        error: function(error){
            layer.msg("操作失败")
        }
    });
}
function reload()
{
    window.location.href = '/superman/account/user';
}
</script>
@stop