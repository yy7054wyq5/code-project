@extends('admin.base')
@section('content')
{!!HTML::style('common/multiple/multi-select.css')!!}
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>运费模板设置</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">模板名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="text" name="info[name]" value="{{ $info['name'] }}" placeholder="请输入活动名称" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">计价方式</label>
                <div class="col-sm-4">
                    <select class="form-control" name="info[type]">
                        <option value="4" @if($info['type'] == 4) selected @endif>按件数计算(单位：件)</option>
                        <option value="5" @if($info['type'] == 5) selected @endif>按重量计算(单位：Kg)</option>
                        <option value="6" @if($info['type'] == 6) selected @endif>按体积计算(单位：立方)</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">起计量</label>
                <div class="col-sm-4">
                    <input type="text" value="{{ $info['startnum'] }}" name="info[startnum]" placeholder="起计量" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">累加量</label>
                <div class="col-sm-4">
                    <input type="text" value="{{ $info['accnum'] }}" name="info[accnum]" placeholder="累加量"  class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">起计量价格</label>
                <div class="col-sm-4">
                    <input type="text" value="{{ $info['startprice'] }}" name="info[startprice]" placeholder="起计量价格" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">累加量价格</label>
                <div class="col-sm-4">
                    <input type="text" value="{{ $info['accprice'] }}" name="info[accprice]" placeholder="累加量价格"  class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group" id="ordersn">
                <label class="col-sm-2 control-label">配送方式</label>
                <div class="col-sm-4">
                    <div class='hero-multiselect'>
                        <select multiple id="class" name="type[]">
                            <option value="0" @if(in_array(0, $ship)) selected @endif>快递</option>
                            <option value="1" @if(in_array(1, $ship)) selected @endif>EMS</option>
                            <option value="2" @if(in_array(2, $ship)) selected @endif>平邮</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">选择城市</label>
                <div class="col-sm-9">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        @if ($city)
                        @foreach ($city as $value)
                        <tr>
                            <td style="width:30px;"><b><font color="red">{{ $value['parentname'] }}</font></b>
                            <input type="checkbox" @if(in_array($value['parentid'], $citylist)) checked @endif class="checkall" name="city[]" value="{{ $value['parentid'] }}">
                            </td>
                        @if (isset($value['sub']))
                        <td class="sub-check">
                        @foreach ($value['sub'] as $v)
                            &nbsp;&nbsp;&nbsp;<input type="checkbox" @if(in_array($v['subid'], $citylist)) checked @endif name="city[]" value="{{ $v['subid'] }}">{{ $v['subname'] }}
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
                    <button onclick="return store()" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
{!!HTML::script('common/multiple/jquery.multi-select.js') !!}
<script type="text/javascript">
var $class = $('#class').multiSelect();

$(document).on('click', '.checkall', function(event) {
    var $input = $(this).parent('td').siblings('td').children('input');
    if($(this).prop('checked')) $input.prop('checked', 'checked');
    else $input.prop('checked', '');
});

$(document).on('click', '.sub-check>input', function(event) {
    if(!$(this).prop('checked')) $(this).parent('td').siblings('td').children('.checkall').prop('checked', '');
});

function store() {
    $.ajax({
        type: "POST",
        url:"/superman/freight/update/{{ $info['id'] }}",
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
    window.location.href = '/superman/freight/list';
}
</script>
@stop