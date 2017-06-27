@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>用户创建</h4>
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
                <label class="col-sm-2 control-label">用户名称</label>
                <div class="col-sm-4">
                    <input type="text" name="user[username]" class="form-control" placeholder="请输入用户名称">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">用户密码</label>
                <div class="col-sm-4">
                    <input type="text" name="user[password]" class="form-control" placeholder="请输入密码">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">联系人</label>
                <div class="col-sm-4">
                    <input type="text" name="user[realname]" class="form-control" placeholder="请输入联系人">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">手机号码</label>
                <div class="col-sm-4">
                    <input type="text" name="user[mobile]" class="form-control" placeholder="请输入用户电话">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-4">
                    <input type="text" name="user[email]" class="form-control" placeholder="请输入用户Email">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="submit" onclick="return store();" class="btn btn-primary">保存</button>
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
        url:"/superman/account/storeuser",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips']);
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
    window.location.href = '/superman/account/user';
}
</script>
@stop
