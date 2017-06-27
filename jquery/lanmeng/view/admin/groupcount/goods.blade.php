@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>商城产品类型统计</h4>
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
                        <form action="/superman/groupcount/goods" method="get">
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
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>商品类型名称</th>
                        <th>占比</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($type)
                    @foreach($type as $value)
                    <tr>
                        @if(isset($value['sub']))
                        <td>{{ $value['name'] }}&nbsp;({{ $value['type'] }})</td>
                        @else
                        <td><a href="/superman/groupcount/goodscount/{{ $value['id'] }}">{{ $value['name'] }}</a>&nbsp;({{ $value['type'] }})</td>
                        @endif
                        <td>{{ $value['pro'] }}</td>
                    </tr>
                    @if(isset($value['sub']))
                    @foreach($value['sub'] as $v)
                    <tr>
                        <td><a href="/superman/groupcount/goodscount/{{ $v['id'] }}"><font color="blue">{{ $v['name'] }}</font></a></td>
                        <td>{{ $v['pro'] }}</td>
                    </tr>
                    @endforeach
                    @endif
                    @endforeach
                    @else
                    <tr>
                        <td colspan="2">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
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