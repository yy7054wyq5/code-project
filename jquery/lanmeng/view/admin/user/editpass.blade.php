@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>密码修改</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">当前用户</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="text" readonly name="user[username]" value="{{ $info['username'] }}" class="form-control" />
                    <input type="hidden" name="user[uid]" value="{{ $info['uid'] }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">请输入旧密码</label>
                <div class="col-sm-4">
                    <input type="password" name="user[oldpass]" placeholder="请输入旧密码" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*(必填)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">请输入新密码</label>
                <div class="col-sm-4">
                    <input type="password" name="user[newpass]" placeholder="请输入新密码" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*(必填)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">请验证新密码</label>
                <div class="col-sm-4">
                    <input type="password" name="user[valpass]" placeholder="请验证新密码" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*(必填)</font></p>
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
        url:"/superman/user/uppass",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips']);
            if (msg['url']) {
                setTimeout("reload('"+msg['url']+"')", 1000)
            };
        },
        error: function(error){
            layer.msg("操作失败");
        }
    });
}
function reload(url)
{
    location.href = url;
}
</script>
@stop