@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>聚惠分类添加</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">分类名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="text" name="info[name]" placeholder="请输入分类名称" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示顺序</label>
                <div class="col-sm-4">
                    <input type="text" name="info[sort]" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">支付方式</label>
                <div class="col-sm-4">
                    <select name="info[payMethod]" class="form-control">
                        <option value="1">蓝深-展厅家具</option>
                        <option value="2">旅游产品-悠迪</option>
                        <option value="3">其他产品-祎策</option>
                    </select>
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
function store() {
    $.ajax({
        type: "POST",
        url:"/superman/gather/storetype",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips']);
            if (msg['status'] == 0) {
                setTimeout("reload()", 1000);
            };
        },
        error: function(error){
            layer.msg("操作失败");
        }
    });
}
function reload() {
    location.href = '/superman/gather/type';
}
</script>
@stop