@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>热门城市</h4>
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
                <div class="col-sm-10">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        @if ($city)
                        @foreach ($city as $value)
                        <tr>
                            <td style="width:30px;"><b><font color="red">{{ $value['parentname'] }}</font></b></td>
                        @if (isset($value['sub']))
                        <td>
                        @foreach ($value['sub'] as $v)
                            &nbsp;&nbsp;&nbsp;<input type="checkbox" @if(in_array($v['subid'], $hot)) checked @endif onclick="checknum(this)" name="city[]" value="{{ $v['subid'] }}">{{ $v['subname'] }}
                        @endforeach
                        </td>
                        </tr>
                        @endif
                        <tr style="height:5px;"></tr>
                        @endforeach
                        @endif
                    </table>
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
{!!HTML::script('common/ueditor/ueditor.config.js') !!}
{!!HTML::script('common/ueditor/ueditor.all.js') !!}
{!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js') !!}
<script type="text/javascript">
var ue = UE.getEditor('container');
</script>
<script type="text/javascript">
var num = 1;
function store()
{
    $.ajax({
        type: "POST",
        url:"/superman/trading/storecity",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips']);
            setTimeout("reload()", 1000)
        },
        error: function(error){
            layer.msg("操作失败");
        }
    });
}
function reload()
{
    window.location.reload();
}

function checknum(node){
    var num = $("input[type='checkbox']:checked").length;
    var maxSel = 6;
    if (num > maxSel) {
        node.checked = false;
        alert("最多值可以选择"+maxSel+"个城市");
    };
    return;
}
</script>
@stop