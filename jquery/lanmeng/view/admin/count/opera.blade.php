@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>运营数据统计</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body" id="charts">
        <div class="row">
            <div class="col-sm-12">
                <form action="/superman/count/operate" method="get">
                <div class="pull-left">
                    <div class="dataTables_filter" id="datatable1_filter">
                        <label>
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="text" name="timeBegin" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                        </label>
                        <label>-
                        </label>
                        <label>
                            <input type="text" name="timeEnd" placeholder="截止时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss', choose:chooseCbk})" class="form-control" />
                        </label>
                        <input type="submit" value="查询" class="btn btn-sm btn-primary">
                    </div>
                </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
        @foreach($lists as $key => $value)
        <div id="main_{{ $key+1 }}" style="height:300px;padding:10px;" data-title="{{ $value['title'] }}" data-option="{{ $value['option'] }}" data-value="{{ $value['value'] }}"></div>
        @endforeach
    </div>
</div>
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('common/echarts.min.js') !!}
<script type="text/javascript">
var countnum = 0;
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
            name:'运营统计',
            type:'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data: temp,
            /*itemStyle:{
                normal:{
                    label:{
                        show: true,
                        formatter: '{b} : {c} ({d}%)'
                    },
                    labelLine :{show:true}
                }
            }*/
        },
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
