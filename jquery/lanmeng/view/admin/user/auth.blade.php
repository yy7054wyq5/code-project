@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4>
            <i class="fa fa-columns"></i>
            <span class="hidden-inline-mobile">认证资料</span>
        </h4>
    </div>
    <div class="box-body">
        <div class="tabbable header-tabs">
            <ul class="nav nav-tabs">
                @if($group == 8)
                <li class="active">
                    <a href="#box_tab3" data-toggle="tab">
                        <span class="hidden-inline-mobile">合作伙伴</span>
                    </a>
                </li>
                @elseif($group == 7)
                <li class="active">
                    <a href="#box_tab2" data-toggle="tab">
                        <span class="hidden-inline-mobile">区域分销商</span>
                    </a>
                </li>
                @elseif($group == 6)
                <li class="active">
                    <a href="#box_tab1" data-toggle="tab">
                        <span class="hidden-inline-mobile">经销商</span>
                    </a>
                </li>
                @else
                <li class="active">
                    <a href="#box_tab1" data-toggle="tab">
                        <span class="hidden-inline-mobile">详细资料</span>
                    </a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                @if($group == 8)
                <div class="tab-pane fade in active" id="box_tab3">
                    <!-- 合作伙伴 Begin -->
                    @include('admin.user.partner', $lists)
                    <!-- 合作伙伴 Begin -->
                </div>
                @elseif($group == 7)
                <div class="tab-pane fade in active" id="box_tab2">
                    <!-- 区域经销商 Begin -->
                    @include('admin.user.distributor', $lists)
                    <!-- 区域经销商 End -->
                </div>
                @elseif($group == 6)
                <div class="tab-pane fade in active" id="box_tab1">
                    <!-- 经销商 Begin -->
                    @include('admin.user.dealer', $lists)
                    <!-- 经销商 End -->
                </div>
                @else
                <div class="tab-pane fade in active" id="box_tab1">
                    <!-- 经销商 Begin -->
                    @include('admin.user.dealer', $lists)
                    <!-- 经销商 End -->
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function update()
{
    $.ajax({
        type: "POST",
        url:"/superman/account/updateuserauth/{{ $info->uid }}",
        data:$('.form-horizontal').serialize(),
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

function changeCity(data)
{
    var id = $(data).val();
    $(".city").val(id);
}

function changeBrand(data)
{
    var id = $(data).val();
    $(".brand").val(id);
}

function changeAddress(data){
    var val = $(data).val();
    $(".address").val(val);
}

function changeTaxnum(data){
    var val = $(data).val();
    $(".taxnum").val(val);
}

function changeBank(data){
    var val = $(data).val();
    $(".bank").val(val);
}

function changeAccount(data){
    var val = $(data).val();
    $(".account").val(val);
}
</script>
@stop