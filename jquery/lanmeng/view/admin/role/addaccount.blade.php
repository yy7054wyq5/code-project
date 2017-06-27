@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>新增管理员</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body big  " >
        <form class="form-horizontal" id="form"  onsubmit="return false;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-sm-2 control-label">所属角色</label>
                <div class="col-sm-4">
                    <select class="form-control select-role " name="admin[usergroup]">
                        @if ($group)
                            @foreach ($group as $key => $value)
                                <option value="{{ $value->groupid }}">{{ $value->groupname }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
                </div>
            </div>
            @include('admin.role.addordinary')
            @include('admin.role.addgroup')
            @include('admin.role.addlogistics')
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-6">
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
    var  url = '/superman/account/store';
    if($('.select-role').val() == 39){
        url = '/superman/account/add-group-user';
    }
    if($('.select-role').val() == 40){
        url = '/superman/account/add-logistics-user';
    }
    $.ajax({
        type: "POST",
        url:url,
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
    window.location.href = '/superman/account/list';
}

function getCity(data) {
    var pid = $(data).val();
    $(".province").val(pid);
    var data = $.ajax({url:"/superman/user/getcity", data:{'id':pid}, async:false}).responseText;
    data = eval('('+data+')');
    $(".city").empty();
    data.content.forEach(function(e){
        $(".city").append("<option value='"+e.id+"'>"+e.name+"</option>");
    })
}

function changeCitys()
{
    var pid = $(".province  option:selected").val();
    var data = $.ajax({url:"/superman/user/getcity", data:{'id':pid}, async:false}).responseText;
    data = eval('('+data+')');
    $(".city").empty();
    data.content.forEach(function(e){
        $(".city").append("<option value='"+e.id+"'>"+e.name+"</option>");
    })
}

$('#checkall').click(function() {
    var value = $("#checkall:checked").val() == "on" ? true : false;
    $("input[name='admin[role][]']").each(function(){
        this.checked = value;
    });
});
$('.select-role').on('change',function(){
        var val = $(this).val();
        if(val == 39){
            $('.add-ordinary').css('display','none');
            $('.add-logistics').css('display','none');
           $('.add-group').css('display','block');
        }else if(val == 40){
            $('.add-group').css('display','none');
            $('.add-ordinary').css('display','none');
            $('.add-logistics').css('display','block');
        }
        else{
            $('.add-group').css('display','none');
            $('.add-logistics').css('display','none');
            $('.add-ordinary').css('display','block');
        }
})
</script>
@stop