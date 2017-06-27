@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>角色信息管理</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">角色名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" id='groupid' value="{{ $info->groupid }}">
                    <input type="text" name="user[groupname]" class="form-control" value="{{ $info->groupname }}" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">角色描述</label>
                <div class="col-sm-4">
                    <input type="text" name="user[desc]"  class="form-control" value="{{ $info->desc }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">权限分配</label>
                <div class="col-sm-4">
                    <table style="width:450px;">
                        @if ($role)
                        @foreach ($role as $value)
                        <tr>
                            <td colspan="5"><b><font color="red">{{ $value['modulename'] }}</font></b></td>
                        </tr>
                        @if (isset($value['sub']))
                        @foreach ($value['sub'] as $v)
                        <tr>
                            <td>{{ $v['modulename'] }}</td>
                            <td><input type="checkbox" @if (strpos($v['function'], 'show') !== false) checked @endif name="module[{{ $value['moduleid'] }}][{{ $v['moduleid'] }}][]" value="show">查看</td>
                            <td><input type="checkbox" @if (strpos($v['function'], 'add') !== false) checked @endif name="module[{{ $value['moduleid'] }}][{{ $v['moduleid'] }}][]" value="add">新增</td>
                            <td><input type="checkbox" @if (strpos($v['function'], 'edit') !== false) checked @endif name="module[{{ $value['moduleid'] }}][{{ $v['moduleid'] }}][]" value="edit">修改</td>
                            <td><input type="checkbox" @if (strpos($v['function'], 'del') !== false) checked @endif name="module[{{ $value['moduleid'] }}][{{ $v['moduleid'] }}][]" value="del">删除</td>
                            @if($v['modulename'] == '会员列表')
                            <td><input type="checkbox" @if (strpos($v['function'], 'examine') !== false) checked @endif name="module[{{ $value['moduleid'] }}][{{ $v['moduleid'] }}][]" value="examine">审核</td>
                            <td><input type="checkbox" @if (strpos($v['function'], 'nobind') !== false) checked @endif name="module[{{ $value['moduleid'] }}][{{ $v['moduleid'] }}][]" value="nobind">解除绑定</td>
                            @endif
                            <!-- @if(in_array($value['moduleid'], [12,13,14,15]))<td><input type="checkbox" @if (strpos($v['function'], 'export') !== false) checked @endif name="module[{{ $value['moduleid'] }}][{{ $v['moduleid'] }}][]" value="export">导出</td>@endif -->
                        </tr>
                        @endforeach
                        @endif
                        <tr style="height:8px;"></tr>
                        @endforeach
                        @endif
                    </table>
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
        url:"/superman/role/update/" + $('#groupid').val(),
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips'])
            if (msg['status'] == 0) {
                setTimeout("reload()", 1000)
            };
        },
        error: function(error){
            layer.msg("保存失败")
        }
    });
}
function reload()
{
    window.location.href = '/superman/role/list';
}
</script>
@stop