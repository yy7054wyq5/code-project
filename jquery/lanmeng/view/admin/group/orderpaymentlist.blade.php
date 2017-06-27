@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 14px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table">&nbsp;&nbsp;订单代付审批列表</i></h4>
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
                            <form action="/superman/group/orderpaymentlist" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    &nbsp;&nbsp;<label>代付方式:</label>
                                    <label>
                                        <select  name="paymentMode"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @if(count($paymethod))
                                            @foreach($paymethod as $key => $value)
                                              <option value="{{$key}}" @if(array_get($_GET, 'paymentMode') == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                             @endif
                                        </select>
                                    </label>

                                    &nbsp;&nbsp;<label>订单审核状态:</label>
                                    <label>
                                        <select  name="groupStatus"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @if(count($groupStatus)>0)
                                            @foreach($groupStatus as $key => $value)
                                                <option value="{{$key}}" @if(array_get($_GET, 'groupStatus') == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th>订单ID</th>
                        <th>下单用户</th>
                        <th>代付方式</th>
                        <th>下单时间</th>
                        <th>订单审核状态</th>
                        <th>订单总价</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td>{{ $value->ordersn }}</td>
                                <td>{{$value->username}}</td>
                                <td>{{$paymethod[$value->grouppay]}}</td>
                                <td>{{ date('Y-m-d H:i',$value->created) }}</td>
                                <td>
                                    @if($value->grouppay != \App\Model\Order::$DealerNotNeedPay)
                                    {{(isset($groupStatus[$value->groupStatus]))?$groupStatus[$value->groupStatus]:'待审核'}}
                                    @else
                                        ————
                                    @endif
                                </td>
                                <td>{{$value->totalPrice}}</td>
                                <td>
                                    @if($value->grouppay != \App\Model\Order::$DealerNotNeedPay && $value->groupStatus != \App\Model\Order::$alreadyPaidGroupStatus)
                                      <a href="/superman/group/examine/{{$value->orderid}}" class="btn btn-success btn-xs">审核通过</a>&nbsp;
                                      <a href="/superman/group/reject/{{$value->orderid}}" class="btn btn-danger btn-xs">驳回</a>&nbsp;
                                       @if($value->grouppay == \App\Model\Order::$DealerGroupApprovalPayment && $value->groupStatus == \App\Model\Order::$waitPayGroupStatus )
                                            <a href="/user/api/pay/{{$value->ordersn}}" id="pay" data-ordersn="{{$value->ordersn}}"  class="btn btn-info btn-xs">支付</a>&nbsp;@endif
                                       @if(($value->grouppay==\App\Model\Order::$DealerApproval || $value->grouppay == \App\Model\Order::$DealerGroupApprovalPayment)
                                        && $value->status != \App\Model\Order::$cancelOrder
                                        && $value->groupStatus != \App\Model\Order::$cancelOrderGroupStatus )
                                            <a href="/superman/group/pay-mothed/{{$value->orderid}}"   class="btn btn-primary btn-xs">修改支付方式</a></td>@endif
                                    @else
                                        @if(($value->grouppay==\App\Model\Order::$DealerApproval
                                        || $value->grouppay == \App\Model\Order::$DealerGroupApprovalPayment)
                                        && $value->status != \App\Model\Order::$cancelOrder
                                        && $value->groupStatus != \App\Model\Order::$cancelOrderGroupStatus )
                                            <a href="/superman/group/pay-mothed/{{$value->orderid}}"   class="btn btn-primary btn-xs">修改支付方式</a></td>
                                        @else
                                            ————
                                        @endif
                                    @endif
                            </tr>
                            <!-- 模态框（Modal） -->
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">
                              {!!$pager!!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
{!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
<script type="text/javascript">
    $(function(){
        //全选
        $('.J_checkall').click(function(){
            var J_checkall = $(this).attr('checked');
            $('.J_checkitem').each(function(){
                if(J_checkall == 'checked'){
                    $(this).attr('checked',true);
                }else{
                    $(this).attr('checked',false);
                }
            });
        });
    });

</script>