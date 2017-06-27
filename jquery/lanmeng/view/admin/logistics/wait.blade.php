@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>待发货订单列表</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <div class="row">
                &nbsp;&nbsp;&nbsp;&nbsp;<button onclick="checkAll();" class="btn btn-sm btn-info">顺序发货</button>
                <div class="clearfix"></div>
            </div>
            <table id="datatable1" cellpadding="0" style="TABLE-LAYOUT: fixed"   cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="4%"><input type="checkbox" class="checkall"></th>
                        <th width="24%">订单号</th>
                        <th width="24%">分发管理员</th>
                        <th width="24%">分发时间</th>
                        <th width="24%">操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($list)
                    @foreach($list as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value['ordersn'] }}"></td>
                        <td>{{ $value['ordersn'] }}</td>
                        <td>{{ $value['username'] }}</td>
                        <td>{{ date('Y-m-d H:i', $value['created']) }}</td>
                        <td data-ordersn="{{ $value['ordersn'] }}"><button onclick="showModify(this)" class="btn btn-xs btn-info">发货</button></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php //echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
<script type="text/javascript">
/**
*扫码枪设置：
*接口输出格式为USB键盘模式
*结束符设为回车
*/
function showModify(data) {
    var ordersn = 0;
    if(isNaN(parseInt(data))){
        ordersn = $(data).parent('td').attr('data-ordersn');
    }else{
         ordersn = data; 
    }
    var html = '<table class="table table-striped table-hover table-bordered">';
    html += "<tr><td class='name' >订单单号</td><td class='ordersn'>";
    html += ordersn
    html += "</td></tr>";
    html += "<tr><td class='name'>物流单号</td><td>";
    html += "<input type=\"text\" id=\"newlogistics\" placeholder=\"物流单号\" class=\"form-control\" />";
    html += "</td></tr>";
    html += "<tr><td class='name'></td><td>";
    html += "<button class=\"btn btn-sm btn-info\" onclick=\"postUp('"+ordersn+"')\">确认修改</button>";
    html += "</td></tr>";
    html += "</table>";
    layer.open({
        type: 1,
        title: '订单发货',
        skin: 'layui-layer-rim', //加上边框
        area: ['450px', '230px'], //宽高
        content: html
    });
    $('#newlogistics').focus();
}

function postUp(ordersn) {
    var newlogistics = $('#newlogistics').val();
    $.post("/superman/logistics/waitlogistics", {ordersn : ordersn, logistics : newlogistics, _token : $("#token").val()})
        .done(function (data) {
            if (data.status == 0) {
                layer.msg('发货成功');
                $('td[data-ordersn="'+ordersn+'"]').parents('tr').remove();
                setTimeout("close()", 1000);
                console.log(ordersn);
            }
            else{
                console.log(data.tips);
            }
        })
        .error(function () {
            layer.msg('请重试');
        });
}

function close()
{
    layer.closeAll();
    //单独点击发货或者顺序发货结束   
    if(tmp===undefined||tmp.length===0){
        window.location.reload();
    }
    else if (tmp.length) {
        showModify(crtOid = tmp.shift());
    }
}

var tmp;
var crtOid;

//绑定回车
$(document).on('keydown', function (e) {
    if(crtOid===undefined){
        crtOid = $('.ordersn').text();
    }
    if (e.keyCode === 13) {
        if(crtOid!==''){
            postUp(crtOid);
        }
    }
})

//顺序发货
function checkAll () {
    tmp = $("input[name='check[]']:checked").map(function () {
        return this.value
    }).toArray();

     if (tmp.length) {
        crtOid = tmp.shift();
        showModify(crtOid);
        $(document).on('keydown', function (e) {
            if (e.keyCode === 13) {
                postUp(crtOid);
            }
        })
   }
}
</script>
@stop