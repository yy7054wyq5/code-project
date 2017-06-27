@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>{{ Input::get('type') == 'normal' ? '消费详情' : '经销商订单' }}</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table id="datatable1" style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>订单号</th>
                        <th>经销商账号</th>
                        <th>订单金额</th>
                        <th>下单时间</th>
                        <th>支付方式</th>
                        <th>支付方</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    @foreach($lists as $value)
                    <tr>
                    <td style="WORD-WRAP: break-word">{{ $value['ordersn'] }}</td>
                    <td style="WORD-WRAP: break-word">{{ $username }}</td>
                    <td style="WORD-WRAP: break-word">{{ $value['orderprice'] }}</td>
                    <td style="WORD-WRAP: break-word">{{ date('Y-m-d H:i', $value['created']) }}</td>
                    <td style="WORD-WRAP: break-word">{{ $value['pay'] }}</td>
                    <td style="WORD-WRAP: break-word">{{ $value['grouppay'] }}</td>
                    <td style="WORD-WRAP: break-word"><a class="btn btn-success btn-xs" href="/superman/order/specialdetail/{{ $value['ordersn'] }}">详细</a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
@stop