@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>已发货订单列表</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <div class="row">
                <div class="clearfix"></div>
            </div>
            <table id="datatable1" cellpadding="0" style="TABLE-LAYOUT: fixed"   cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="20%">订单号</th>
                        <th width="20%">快递单号</th>
                        <th width="20%">分发管理员</th>
                        <th width="20%">分发时间</th>
                        <th width="20%">操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($list)
                    @foreach($list as $value)
                    <tr>
                        <td>{{ $value['ordersn'] }}</td>
                        <td>{{ $value['logistics'] }}</td>
                        <td>{{ $value['username'] }}</td>
                        <td>{{ date('Y-m-d H:i', $value['created']) }}</td>
                        <td data-logistics="{{ $value['logistics'] }}" data-ordersn="{{ $value['ordersn'] }}"><button onclick="showModify(this)" class="btn btn-xs btn-info">修改</button></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
<script type="text/javascript">
function showModify(data) {
    var logistics = $(data).parent('td').attr('data-logistics');
    var ordersn = $(data).parent('td').attr('data-ordersn');
    var html = '<table class="table table-striped table-hover table-bordered">';
    html += "<tr><td class='name'>订单单号</td><td>";
    html += ordersn
    html += "</td></tr>";
    html += "<tr><td class='name'>原物流单号</td><td>";
    html += logistics;
    html += "<tr><td class='name'>新物流单号</td><td>";
    html += "<input type=\"text\" id=\"newlogistics\" placeholder=\"新物流单号\" class=\"form-control\" />";
    html += "</td></tr>";
    html += "<tr><td class='name'></td><td>";
    html += "<button class=\"btn btn-sm btn-info\" onclick=\"postUp('"+ordersn+"')\">确认修改</button>";
    html += "</td></tr>";
    html += "</table>";
    layer.open({
        type: 1,
        title: '物流单号修改',
        skin: 'layui-layer-rim', //加上边框
        area: ['450px', '280px'], //宽高
        content: html
    });
}
function postUp(ordersn) {
    var newlogistics = $('#newlogistics').val();
    $.post("/superman/logistics/modifylogistics", {ordersn : ordersn, logistics : newlogistics, _token : $("#token").val()}, function(data){
        if (data.status == 0) {
            layer.msg(data.tips);
            setTimeout("close()", 1000);
        } else {
            layer.msg(data.tips);
        }
    }, "json");
}

function close()
{
    layer.closeAll();
    window.location.reload();
}
</script>
@stop