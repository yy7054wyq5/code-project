@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>{{ isset($info->title) ? $info->title : "未知" }}-调研统计-样本数量：{{ $count }}&nbsp;&nbsp;<button class="btn btn-xs btn-info" onclick="window.location.href = '/superman/interact/exportexcel/{{ $id }}'">导出报表</button></h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body" id="charts">
        @if($lists)
        @foreach($lists as $key => $value)
        <div id="main_{{ $key+1 }}" style="height:300px;padding:10px;" data-title="{{ $value->title }}" data-option="{{ $value->option }}" data-value="{{ $value->answer }}"></div>
        @endforeach
        @endif
    </div>
</div>
{!!HTML::script('common/echarts.min.js') !!}
<script type="text/javascript">
var length = $('#charts').children().length;
for (var i = 1; i <= length; i++) {
    var myChart = echarts.init(document.getElementById("main_"+i));
    var title = $("#main_"+i).attr("data-title");
    var optionjson = eval('('+$("#main_"+i).attr("data-option")+')');
    var valuejson = eval('('+$("#main_"+i).attr("data-value")+')');
    var option = setOption(title, optionjson, valuejson);
    myChart.setOption(option);
};

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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
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
            name:'调查选项',
            type:'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data: temp
        }
        ]
    };
    return option;
}
</script>
@stop