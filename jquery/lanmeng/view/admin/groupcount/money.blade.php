@extends('admin.base')
@section('content')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>经销商消费金额对比曲线</h4>
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
                        <form action="/superman/groupcount/money" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="timeBegin" value="{{ Input::get('timeBegin') }}" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})" class="form-control input-sm" />
                            </label>
                            <label>-</label>
                            <label>
                                <input type="text" value="{{ Input::get('timeEnd') }}" name="timeEnd" placeholder="截止时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})" class="form-control input-sm" />
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
                                <select id="city" name="city" onchange="getUser();" class="form-control input-sm">
                                    <option>请选择城市</option>
                                </select>
                            </label>
                            <label>
                                <select name="usrelist[]" id="userlist" class="form-control input-sm selectpicker" multiple data-max-options="5" title="请选择经销商(最多5个)">
                                    @foreach($user as $value)
                                    <option data-id="{{ $value['uid'] }}" value="{{ $value['uid'] }}">{{ $value['username'] }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <div class="clearfix"></div>
                </div>
            </div>
            @if($data)
            @foreach($data as $key => $value)
            <div id="main_{{ $key+1 }}" style="height:300px;padding:10px;" data-title="{{ $value['title'] }}" data-option="{{ json_encode($value['user']) }}" data-value="{{ json_encode($value['pdata']) }}"></div>
            @endforeach
            @endif
        </div>
    </div>
</div>
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('common/echarts.min.js') !!}
<script type="text/javascript">
function getCity()
{
    var pid = $("#province option:selected").attr('data-id');
    $.post("/superman/trading/city", {id: pid, _token : $("#token").val()}, function(data){
      var t = '';
      $.each(data['content'], function () {
        t += '<option data-id="'+this.id+'" value="'+ this.id +'">'+ this.name +'</option>';
      });
      $("#city").empty();
      $("#city").append(t);
    }, "json");
}
function getUser()
{
    var pid = $("#province option:selected").attr('data-id');
    var cid = $("#city option:selected").attr('data-id');
    $.post("/superman/groupcount/userlistfromcity", {pid: pid, cid: cid, _token : $("#token").val()}, function(data){
    }, "json");
}
for (var i = 1; i <= 3; i++) {
    var myChart = echarts.init(document.getElementById("main_"+i));
    var title = $("#main_"+i).attr("data-title");
    var optionjson = eval('('+$("#main_"+i).attr("data-option")+')');
    var valuejson = eval('('+$("#main_"+i).attr("data-value")+')');
    var option = setOption(title, optionjson, valuejson);
    myChart.setOption(option);
};

function setOption(title, options, pdata)
{
    var series = [];
    var op = [];
    for (var key in options) {
        var obj = {
            name:key,
            type:'line',
            data:options[key],
        };
        series.push(obj);
        op.push(key);
    }
    var option = {
        title: {
            text: title,
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:op
        },
        toolbox: {
            show: true,
            feature: {
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: pdata
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '￥{value}'
            }
        },
        series: series
    };
    return option;
}
</script>
@stop