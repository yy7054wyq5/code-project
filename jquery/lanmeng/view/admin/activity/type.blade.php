@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>活动分类</h4>
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
                    <div class="pull-left">
                        <form action="/superman/activity/type" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    <a href="/superman/coupons/addoffline" class="btn btn-sm btn-info">新增</a>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>优惠券码</th>
                        <th>优惠券名称</th>
                        <th>领用用户名</th>
                        <th>领取时间</th>
                        <th>使用时间</th>
                        <th>状态</th>
                        <th>使用订单号</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">

                    <tr>
                        <td colspan="9">暂无数据</td>
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