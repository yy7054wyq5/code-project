@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>模板列表</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>模板名称</th>
                        <th>分类个数</th>
                        <th>广告位个数</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <tr>
                        <td colspan="5">暂无数据</td>
                    </tr>
                </tbody>
            </table>
            <?php //echo $page ?>
        </div>
    </div>
</div>
<script type="text/javascript">
$('.checkall').click(function() {
    var value = $(".checkall:checked").val() == "on" ? true : false;
    $("input[name='check[]']").each(function(){
        this.checked = value;
    });
});
</script>
@stop