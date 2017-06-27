@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>商品购买明细</h4>
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
                        <form action="/superman/groupcount/buy" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="timeBegin" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control input-sm" />
                            </label>
                            <label>-</label>
                            <label>
                                <input type="text" name="timeEnd" placeholder="截止时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control input-sm" />
                            </label>
                            <label>
                                <select class="form-control input-sm" id="province" name="province" onchange="getCity();">
                                    <option>请选择省份</option>
                                    @foreach($city as $value)
                                    <option data-id="{{ $value['id'] }}" value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <select id="city" name="city" class="form-control input-sm selectpicker">
                                    <option>请选择城市</option>
                                </select>
                            </label>
                            <label>
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="经销商名称关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>商品名称</th>
                        <th>商品所属板块</th>
                        <th>订单号</th>
                        <th>笔单价</th>
                        <th>商品数量</th>
                        <th>下单时间</th>
                        <th>支付方式</th>
                        <th>经销商名称</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    @foreach($lists as $value)
                    <tr>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ $value['type'] }}</td>
                        <td>{{ $value['ordersn'] }}</td>
                        <td>{{ $value['price'] }}</td>
                        <td>{{ $value['num'] }}</td>
                        <td>{{ date('Y-m-d H:i', $value['created']) }}</td>
                        <td>{{ $value['pay'] }}</td>
                        <td>{{ $value['username'] }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php //echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('super/laydate/laydate.js') !!}
<script type="text/javascript">
function getCity()
{
    var pid = $("#province option:selected").attr('data-id');
    $.post("/superman/trading/city", {id: pid, _token : $("#token").val()}, function(data){
      var t = '';
      $.each(data['content'], function () {
        t += '<option value="'+ this.id +'">'+ this.name +'</option>';
      });
      $("#city").empty();
      $("#city").append(t);
    }, "json");
}
</script>
@stop