@extends('admin.adminbase')
@section('title', '订单列表')
@section('head')
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">订单列表</h3>
        </div>

        <div class="box-body">

           <form action="/backstage/order/list" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">订单编号</label>
                    <div class="col-sm-2">
                        <input type="text" name="orderNo" value="{{request('orderNo')? request('orderNo') : ''}}">
                    </div>
                    <label for="" class="control-label col-sm-1">下单用户(手机号)</label>
                    <div class="col-sm-2">
                        <input type="text" name="mobile" value="{{request('mobile')? request('mobile') : ''}}">
                    </div>
                    <label for="" class="control-label col-sm-1">支付状态</label>
                    <div class="col-sm-2">
                        <select name="payState"  class="form-control" style="display: inline-block;width: auto;">
                            <option value="0" @if(request('payState')==-1)selected="selected" @endif>全部</option>
                            <option value="1" @if(request('payState')==1)selected="selected" @endif>未支付</option>
                            <option value="2" @if(request('payState')==2)selected="selected" @endif>已支付</option>
                            <option value="3" @if(request('payState')==3)selected="selected" @endif>已发货</option>
                            <option value="4" @if(request('payState')==4)selected="selected" @endif>已完成</option>
                            <option value="5" @if(request('payState')==5)selected="selected" @endif>退货中</option>
                            <option value="6" @if(request('payState')==6)selected="selected" @endif>已退货</option>
                        </select>
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
            </form>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>订单编号</th>
                        <th>价格</th>

                        <th>用户手机</th>
                        <th>支付方式</th>
                        <th>支付状态</th>
                        <th>下单时间</th>
                        {{--<th>操作</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @if($orders)
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order['orderNo']}}</td>
                                <td>{{$order['price']}}</td>

                                <td>{{$order['mobile']?$order['mobile']:'---'}}</td>
                                @if($order['payment'] == 1)
                                <td>支付宝</td>
                                @elseif($order['payment'] == 2)
                                    <td>微信</td>
                                @elseif($order['payment'] == 3)
                                    <td>银联</td>
                                @endif
                                @if($order['payState'] == 1)
                                    <td>未支付</td>
                                @elseif($order['payState'] == 2)
                                    <td>已支付</td>
                                @elseif($order['payState'] == 3)
                                    <td>已发货</td>
                                @elseif($order['payState'] == 4)
                                    <td>已完成</td>
                                @elseif($order['payState'] == 5)
                                    <td>退货中</td>
                                @elseif($order['payState'] == 6)
                                    <td>已退货</td>
                                @endif
                                <td>{{$order['createTime']}}</td>
                                <td>
                                    <a href="/backstage/order/order-detail/{{$order['id']}}"
                                       class="label label-default">详情</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
  </div>
        <div class="box-footer">
            <?php echo $pager ?>
        </div>
    <script type="text/javascript" >
        /**
         * 更改订单状态
         */
        $('.payState').change(function()
        {
            var payState = $(this).val();
            var orderId = $(this).data('orderid');
            $.get('/backstage/order/update-paystate', {'orderId':orderId,'payState':payState}, function (res){
                if(res['status'] == 'success') {
                    window.location.reload();
                } else {
                    alert(res['msg']);
                }

            });

        });
    </script>
    </div>
@endsection