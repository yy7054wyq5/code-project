@extends('admin.base')
@section('content')
{!!HTML::style('common/multiple/multi-select.css')!!}
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>优惠券发放</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">发放数量</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="cid"  value="{{ $id }}">
                    <input type="text" name="coupons[num]" placeholder="请输入发放数量" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">会员类型</label>
                <div class="col-sm-4">
                    <select class="form-control" id="group" onchange="changeType(this)">
                        <option value="">---请选择会员类型---</option>
                        @if($usertype)
                        @foreach($usertype as $value)
                        <option value="{{ $value['groupid'] }}">{{ $value['groupname'] }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group" id="brand">
                <label class="col-sm-2 control-label">选择品牌</label>
                <div class="col-sm-4">
                    <select class="form-control" onchange="getUserList()" id="brand">
                        <option value="">---请选择品牌---</option>
                        @if($brand)
                        @foreach($brand as $value)
                        <option value="{{ $value['brandId'] }}">{{ $value['brandName'] }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">会员选择</label>
                <div class="col-sm-4">
                    <div class='hero-multiselect'>
                        <select multiple id="user" name="coupons[user][]">
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">输入会员</label>
                <div class="col-sm-4">
                    <textarea class="form-control" name="coupons[usertext]"></textarea>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static">输入完整用户名，并以,分隔</p>
                    <p class="text-muted small form-control-static">如：张三,李四,王五</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button onclick="return store({{ $status }})" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
{!!HTML::script('common/multiple/jquery.multi-select.js') !!}
<script type="text/javascript">
function store(status) {
    if (status == 1) {
        layer.msg("该优惠券处于冻结状态，无法发放");
        return false;
    }
    $.ajax({
        type: "POST",
        url:"/superman/coupons/putcoupons",
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
    window.location.href = document.referrer;
}

var $user = $('#user').multiSelect();

function changeType(data)
{
    if ($(data).val() == 9) {
        $('#brand').hide();
    } else {
        $('#brand').show();
    }
    getUserList();
}

function getUserList()
{
    var groupid = $("#group option:selected").val();
    var bid = $("#brand option:selected").val();
    $.post("/superman/account/userlist", {group: groupid, brand : bid, _token : $("#token").val()}, function(data){
      var t = '';
      $.each(data['content'], function () {
        t += '<option value="'+ this.id +'">'+ this.username +'</option>';
      });
      $user.html(t).multiSelect('refresh');
    }, "json");
}
</script>
@stop
