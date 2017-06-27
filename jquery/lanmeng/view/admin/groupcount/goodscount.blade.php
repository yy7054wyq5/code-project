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
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>经销商名称</th>
                        <th>占比</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    @foreach($lists as $value)
                    <tr>
                        <td><a href="/superman/order/speciallist/{{ $value['uid'] }}">{{ $value['username'] }}</a></td>
                        <td>{{ $count ? sprintf("%.2f", ($value['count'] / $count) * 100).'%' : '0.00%' }}</td>
                    </tr>
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
@stop