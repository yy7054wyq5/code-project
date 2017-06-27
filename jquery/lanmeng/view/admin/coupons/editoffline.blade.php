@extends('admin.base')
@section('content')
{!!HTML::style('common/multiple/multi-select.css')!!}
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>优惠券修改</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">活动名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="text" name="coupons[name]" value="{{ $info->name }}" placeholder="请输入活动名称" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">优惠券有效时间</label>
                <div class="col-sm-3">
                    <input type="text" name="coupons[begintime]" value="{{ date('Y-m-d H:i', $info->begintime) }}" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                </div>
                <div class="col-sm-3">
                    <input type="text" name="coupons[endtime]" value="{{ date('Y-m-d H:i', $info->endtime) }}" placeholder="结束时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*(必填)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">生成数量</label>
                <div class="col-sm-4">
                    <input type="text" name="coupons[num]" readonly value="{{ $info->num }}" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*(不能修改)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">抵扣类型</label>
                <div class="col-sm-4">
                    <select class="form-control" onchange="changeType(this)" name="coupons[type]">
                        <option value="1" @if($info->type == 1) selected @endif>满减抵扣</option>
                        <option value="0" @if($info->type == 0) selected @endif>直接抵扣</option>
                    </select>
                </div>
            </div>
            <div class="form-group" id="ordersn" style="display:{{ $info->type == 0 ? 'none' : ''}}">
                <label class="col-sm-2 control-label">订单金额</label>
                <div class="col-sm-4">
                    <input type="text" name="coupons[orderprice]" value="{{ $info->orderprice }}" placeholder="" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">金额</label>
                <div class="col-sm-4">
                    <input type="text" readonly name="coupons[price]" value="{{ $info->price }}" placeholder="" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*(不能修改)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">品类</label>
                <div class="col-sm-4">
                    <div class='hero-multiselect'>
                        <select multiple id="class" name="coupons[class][]">
                        @if($type)
                        @foreach($type as $value)
                        <option @if(strpos($class, $value['id'].'/'.$value['type']) !== false) selected @endif value="{{ $value['id'].'/'.$value['type'] }}">{{ $value['name'] }}</option>
                        @endforeach
                        @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">状态</label>
                <div class="col-sm-4">
                    <select class="form-control" name="coupons[status]">
                        <option value="0" @if($info->status == 0) selected @endif>正常</option>
                        <option value="1" @if($info->status == 1) selected @endif>冻结</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button onclick="return edit()" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
{!!HTML::script('common/multiple/jquery.multi-select.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
<script type="text/javascript">
var $class = $('#class').multiSelect();

function edit() {
    $.ajax({
        type: "POST",
        url:"/superman/coupons/editoffcoupons/{{ $info->id }}",
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
    window.location.href = '/superman/coupons/offline';
}

function changeType(data)
{
    if ($(data).val() == 1) {
        $('#ordersn').show();
    } else {
        $('#ordersn').hide();
    }
}
</script>
@stop