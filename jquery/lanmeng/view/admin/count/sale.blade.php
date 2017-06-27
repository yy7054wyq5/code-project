@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>销售数据统计</h4>
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
                        <form action="/superman/count/sale" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="timeBegin" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control input-sm" />
                            </label>
                            <label>-</label>
                            <label>
                                <input type="text" name="timeEnd" placeholder="截止时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss', choose:chooseCbk})" class="form-control input-sm" />
                            </label>
                            <label>
                                <select name="pay"  class="form-control input-sm">
                                    <option value="">收款方选择</option>
                                    @foreach(Config::get('pay.payMethod') as $key => $value)
                                    <option @if(Input::get('pay') == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-left">
                        <label>
                            当前时间段客单价：<font color="red">{{ $avg_price }}</font>
                        </label>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <label>
                            当前时间段总积分：<font color="red">{{ $total_integral }}</font>
                        </label>
                    </div>
                    &nbsp;&nbsp;
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>产品名称</th>
                        <th>所属板块</th>
                        <th>产品销量</th>
                        <th>销售额</th>
                        <th>转化率</th>
                        <th>评论数</th>
                        <th>用户分布</th>
                        <th>积分数</th>
                        <th>关注次数</th>
                        <th>订单数</th>
                        <th>购物车数量</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    @foreach($lists as $value)
                    <tr>
                        <td>{{ $value['cname'] }}</td>
                        <td>{{ $value['ctype'] }}</td>
                        <td>{{ $value['csaleNumber'] }}</td>
                        <td>{{ $value['totalprice'] }}</td>
                        <td>{{ $value['cpoint'] ? round($value['csaleNumber'] / $value['cpoint'], 2) * 100 . '%' : $value['csaleNumber'] * 100 . '%' }}</td>
                        <td>{{ $value['ccommentNumber'] }}</td>
                        <td>{{ $value['city'] }}&nbsp;<button onclick="showCity({{ $value['cid'] }})" class="btn btn-xs btn-info">more</button></td>
                        <td>{{ $value['integral'] }}</td>
                        <td>{{ $value['follow'] }}</td>
                        <td>{{ $value['ordercount'] }}</td>
                        <td>{{ $value['cart'] }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="11">暂无数据</td>
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
var countnum = 0;
function showCity(id)
{
    var begin = {{ Input::get('timeBegin') ? Input::get('timeBegin') : 0 }};
    var end = {{ Input::get('timeEnd') ? Input::get('timeEnd') : 0 }};;
    $.post("/superman/count/city", {id: id, begin: begin, end: end, _token : $("#token").val()}, function(data){
        var table = '<table class="table table-striped table-hover table-bordered">';
        $.each(data['content'], function (index, val) {
            table += "<tr><td class='name'>"+val+"</td>";
            table += "</tr>";
        });
        table += "</table>";
        layer.open({
            type: 1,
            title: "用户分布",
            skin: 'layui-layer-rim', //加上边框
            area: ['700px', '320px'], //宽高
            content: table
        });
    }, "json");
}
function chooseCbk(dates)
{
    countnum++;
    var h = dates.substring(11,13);
    var m = dates.substring(14,16);
    var s = dates.substring(17,19);
    if (h == '00' && m=='00' && s=='00' && countnum==1) $('input[name="timeEnd"]').val(dates.substring(0,10) + ' 23:59:59');
}
</script>
@stop