@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>费用报表</h4>
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
                        <form action="/superman/groupcount/cost" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="timeBegin" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="{{ Input::get('timeBegin') }}" class="form-control input-sm" />
                            </label>
                            <label>-</label>
                            <label>
                                <input type="text" value="{{ Input::get('timeEnd') }}" name="timeEnd" placeholder="截止时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control input-sm" />
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
                                <select id="city" name="city" class="form-control input-sm">
                                    <option>请选择城市</option>
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
            <div id="main" style="height:500px;padding:10px;"></div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>经销商</th>
                        <th>集团</th>
                        <th>集团代付费用(万)</th>
                        <th>集团代付费用占比</th>
                        <th>经销商自付费用(万)</th>
                        <th>经销商自付费用占比</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    <?php $user = 0;$group = 0; ?>
                    @foreach($lists as $value)
                    <tr>
                        <td><a href="/superman/order/speciallist/{{ $value['uid'] }}">{{ $value['username'] }}</a></td>
                        <td></td>
                        <td>{{ $value['group'] / 10000 }}</td>
                        <?php $group += $value['group'] / 10000;?>
                        <td>{{ $value['group'] + $value['user'] ? sprintf("%.2f", ($value['group'] / ($value['group'] + $value['user'])) * 100) : '0.00' }}%</td>
                        <td>{{ $value['user'] / 10000 }}</td>
                        <?php $user += $value['user'] / 10000;?>
                        <td>{{ $value['group'] + $value['user'] ? sprintf("%.2f", ($value['user'] / ($value['group'] + $value['user'])) * 100) : '0.00' }}%</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td>总计</td>
                        <td><?php echo $group; ?></td>
                        <td><?php echo $group + $user ? sprintf("%.2f", ($group / ($group + $user)) * 100).'%' : '0.00%';?></td>
                        <td><?php echo $user; ?></td>
                        <td><?php echo $group + $user ? sprintf("%.2f", ($user / ($group + $user)) * 100).'%' : '0.00%';?></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="6">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
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
        t += '<option value="'+ this.id +'">'+ this.name +'</option>';
      });
      $("#city").empty();
      $("#city").append(t);
    }, "json");
}
var myChart = echarts.init(document.getElementById("main"));
var option = {
    title : {
        text: '费用',
        x:'center'
    },
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    toolbox: {
        show : true,
        feature : {
            saveAsImage : {show: true}
        }
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : ['集团代付', '经销商付款']
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'单位：'+'({{ $unit }}',
            type:'bar',
            data:[{{ $x }}, {{ $y }}]
        }
    ]
};

myChart.setOption(option);
</script>
@stop