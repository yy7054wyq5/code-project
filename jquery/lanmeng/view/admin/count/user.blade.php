@extends('admin.base')
@section('content')
<style type="text/css">
    th,td {text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>转化率&活跃度&签到数</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body" id="charts">
        <div class="row">
            <div class="col-sm-12">
                <form action="/superman/count/user" method="get">
                <div class="pull-left">
                    <div class="dataTables_filter" id="datatable1_filter">
                        <label>
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="text" id="begin" value="{{ Input::get('timeBegin') }}" name="timeBegin" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                        </label>
                        <label>-
                        </label>
                        <label>
                            <input type="text" id="end" value="{{ Input::get('timeEnd') }}" name="timeEnd" placeholder="截止时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss', choose:chooseCbk})" class="form-control" />
                        </label>
                        <input type="submit" value="查询" class="btn btn-sm btn-primary">
                    </div>
                </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
        @foreach($charts as $key => $value)
        <div id="main_{{ $key+1 }}" style="height:300px;padding:10px;" data-title="{{ $value['title'] }}" data-option="{{ $value['option'] }}" data-value="{{ $value['value'] }}"></div>
        @endforeach
    </div>
</div>
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('common/echarts.min.js') !!}
<script type="text/javascript">
var countnum = 0;
var myChart1 = echarts.init(document.getElementById("main_1"));
var title = $("#main_1").attr("data-title");
var optionjson = eval('('+$("#main_1").attr("data-option")+')');
var valuejson = eval('('+$("#main_1").attr("data-value")+')');
var option = setOption(title, optionjson, valuejson);
myChart1.setOption(option);
myChart1.on('click', function (params) {
    window.open('/superman/count/userlist?type=1&level=' + params.name + '&begin=' + $('#begin').val() + '&end=' + $('#end').val());
});

var myChart2 = echarts.init(document.getElementById("main_2"));
var title = $("#main_2").attr("data-title");
var optionjson = eval('('+$("#main_2").attr("data-option")+')');
var valuejson = eval('('+$("#main_2").attr("data-value")+')');
var option = setOption(title, optionjson, valuejson);
myChart2.setOption(option);
myChart2.on('click', function (params) {
    window.open('/superman/count/userlist?type=2&level=' + params.name + '&begin=' + $('#begin').val() + '&end=' + $('#end').val());
});

var myChart3 = echarts.init(document.getElementById("main_3"));
var title = $("#main_3").attr("data-title");
var optionjson = eval('('+$("#main_3").attr("data-option")+')');
var valuejson = eval('('+$("#main_3").attr("data-value")+')');
var option = setOption(title, optionjson, valuejson);
myChart3.setOption(option);
myChart3.on('click', function (params) {
    window.open('/superman/count/userlist?type=3&level=' + params.name + '&begin=' + $('#begin').val() + '&end=' + $('#end').val());
});

var myChart4 = echarts.init(document.getElementById("main_4"));
var title = $("#main_4").attr("data-title");
var optionjson = eval('('+$("#main_4").attr("data-option")+')');
var valuejson = eval('('+$("#main_4").attr("data-value")+')');
var option = setOption(title, optionjson, valuejson);
myChart4.setOption(option);


function setOption(title, option, pdata)
{
    var count = option.length;
    var temp = new Array();
    for (var i = 0; i <= count; i++) {
        temp[i] = {value:pdata[i], name:option[i]};
    };
    var option = {
        title : {
            text: title,
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            /*formatter: "{a} <br/>{b} : {c} ({d}%)"*/
        },
        legend: {
            orient : 'vertical',
            x : 'left',
            data:option
        },
        toolbox: {
            show : true,
            feature : {
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        series : [
        {
            name:'运营统计',
            type:'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data: temp
        }
        ]
    };
    return option;
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