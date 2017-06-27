@extends('admin.base')
@section('content')
<style type="text/css">
    th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>创意设计订单素材列表</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    <a class="btn btn-sm btn-info" href="/superman/order/addnewfile/{{ $ordersn }}">新增</a>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                <tr role="row">
                    <th><input type="checkbox" class="checkall"></th>
                    <th>系统ID</th>
                    <th>订单编号</th>
                    <th>素材名称</th>
                    <th>上传时间</th>
                    <!-- <th>操作</th> -->
                </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                @if(isset($lists))
                @foreach($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value['id'] }}"></td>
                        <td>{{ $value['id'] }}</td>
                        <td>{{ $value['ordersn'] }}</td>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ date('Y-m-d H:i', $value['created']) }}</td>
                        <!-- <td><a class="btn btn-success btn-xs" href="/superman/order/editfile/{{ $value['id'] }}">修改</a></td> -->
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6">暂无数据</td>
                </tr>
                @endif
                </tbody>
            </table>
            <?php //echo $pager ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
<script type="text/javascript">
    function reload()
    {
        window.location.reload();
    }
    function delCheckItems() {
        var temp = "";
        $("input[name='check[]']:checked").each(function(){
            temp += ',' + $(this).val();
        });
        layer.confirm('您确定要删除选中的内容么？', {
            btn: ['确定','取消']
        }, function(){
            $.post("/superman/order/delorder", { group: temp,  _token : $("#token").val() } );
            layer.msg('操作成功,1s后本页将自动刷新');
            setTimeout("reload()", 1000);
        });
    }
</script>
@stop