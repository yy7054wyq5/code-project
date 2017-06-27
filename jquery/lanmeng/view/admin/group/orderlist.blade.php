@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 14px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table">&nbsp;&nbsp;经销商订单详情</i></h4>
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
                                <div class="dataTables_filter" id="datatable1_filter"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
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
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td>{{ $value->ordersn }}</td>
                                <td>{{$value->username}}</td>
                                <td>{{$value->price}}</td>
                                <td>{{date('Y-m-d H:i',$value->created) }}</td>
                                <td>{{$payModelArr[$value->pay]}}</td>
                                <td>{{$value->payusername}}</td>
                                <td><a href="/superman/order/show/{{$value->ordersn}}" class="btn btn-success btn-xs">详情</a>&nbsp;</td>
                            </tr>
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