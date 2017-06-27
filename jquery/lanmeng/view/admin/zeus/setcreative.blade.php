@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>素材关联</h4>
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
                    <button class="btn btn-sm btn-primary" onclick="delCheckItems();">关联</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>创意设计ID</th>
                        <th>创意设计名称</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    @foreach($lists as $value)
                    <tr role="row">
                        <th><input type="checkbox" name="check[]" value="{{ $value['creativeId'] }}"></th>
                        <th>{{ $value['creativeId'] }}</th>
                        <th>{{ $value['commodityName'] }}</th>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
<script type="text/javascript">
function delCheckItems() {
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要将文件关联至选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/zeus/setfilesid/{{$id}}", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}

function reload()
{
    window.location.reload();
}
</script>
@stop