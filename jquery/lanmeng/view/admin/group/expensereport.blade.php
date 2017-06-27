@extends('admin.base')
@section('content')
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-bars"></i>费用报表</h4>
            <div class="tools hidden-xs">
                <a href="javascript:;" class="collapse">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="box-body" id="charts">
            <div class="row">
                <div class="col-sm-12">
                    <form action="/superman/group/expense-report-list" method="get">
                        <div class="pull-left">
                            <div class="dataTables_filter" id="datatable1_filter">
                                <label>
                                   <!-- <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> -->
                                    <input type="text" name="timeBegin" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                                </label>
                                <label>-
                                </label>
                                <label>
                                    <input type="text" name="timeEnd" placeholder="截止时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                                </label>
                                &nbsp;&nbsp;
                                <div class="pull-right">
                                    <input type="submit" value="查询" class="btn btn-sm btn-primary "  />
                                    <a href="/superman/group/order-list"  class="btn btn-sm btn-primary " >经销商订单详情</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="main" style=" width: 500px; height:400px;padding:10px;margin-left: 300px; " ></div>
            <div style="width: 100%; height: 50px; line-height: 50px; text-align: center; font-size: 20px; font-weight: bold; "  >柱状图表格明细</div>
            <table id="datatable1" style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                <tr role="row">
                    <th width="20%">经销商</th>
                    <th width="10%" >集团</th>
                    <th width="20%" >集团代付费用（万)</th>
                    <th width="15%" >集团代付费用占比</th>
                    <th width="20%" >经销商自付费用（万）</th>
                    <th width="15%" >经销商自付费用占比</th>
                </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                       @if(count($histogramList)>0)
                           @foreach($histogramList as $key => $value)
                        <tr>
                            <td style="WORD-WRAP: break-word" >{{$value['username']}}</td>
                            <td style="WORD-WRAP: break-word" >{{$value['realname']}}</td>
                            <td style="WORD-WRAP: break-word" >{{$value['groupPay']}}</td>
                            <td style="WORD-WRAP: break-word" >@if($value['groupPay']){{$value['groupPay']/100*$value['orderSum']}}@else 0 @endif%</td>
                            <td style="WORD-WRAP: break-word" >{{$value['selfPay']}}</td>
                            <td style="WORD-WRAP: break-word" >@if($value['selfPay']){{$value['selfPay']/100*$value['orderSum']}}@else 0 @endif%</td>
                        </tr>
                           @endforeach
                        @else
                         <tr>
                            <td colspan="6">暂无数据</td>
                         </tr>
                       @endif
                </tbody>
            </table>
            {!!$pager!!}
            <table id="datatable1" style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <tr>
                        <td style="WORD-WRAP: break-word" ></td>
                        <td style="WORD-WRAP: break-word" >总计</td>
                        <td style="WORD-WRAP: break-word" >{{$groupPay}}</td>
                        <td style="WORD-WRAP: break-word" >@if($groupPay){{$groupPay/100*$groupTotalPrice}}@else 0 @endif%</td>
                        <td style="WORD-WRAP: break-word" >{{$selfPay}}</td>
                        <td style="WORD-WRAP: break-word" >@if($selfPay){{$selfPay/100*$groupTotalPrice}}@else 0 @endif%</td>
                    </tr>
            </table>
        </div>
    </div>
    {!!HTML::script('super/laydate/laydate.js') !!}
    {!!HTML::script('common/echarts.min.js') !!}
    <script type="text/javascript">

        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '费用',
                x:'center'
            },
            tooltip: {},
            legend: {
                data:['销量'],
                x:'left'
            },
            xAxis: {
                data: ["集团代付","经销商付款"]
            },
            yAxis: {},
            series: [{
                name: '销量',
                type: 'bar',
                data: [<?php echo $groupPay ?>,<?php echo $selfPay ?>],

                itemStyle: {
                    normal: {
                        barBorderColor:'rgba(0,0,215,200)',
                        color:'rgba(0,0,215,200)'
                    },
                    emphasis: {
                        barBorderColor:'rgba(0,0,215,200)',
                        color: 'rgba(0,0,215,200)'
                    }
                }
            }]
        };
        myChart.setOption(option);
    </script>
@stop