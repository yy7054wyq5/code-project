@extends('admin.adminbase')
@section('title', '订单详情')
@section('head')
@endsection
@section('content')
  <div class="box box-primary">
    <div class="box-body">
        <form class="form-horizontal">
            <h4 style="border-bottom: 1px solid #CCCCCC; padding: 10px 2px; font-weight: bold">订单详情</h4>
            <table class="table table-condensed table-hover table-bordered rounded">
                <tr>
                    <td>订单编号</td>
                    <td><font class='text-yellow'>{{$detail['orderNo']}}</font></td>
                    <td>手机号</td>
                    <td><font class='text-red'>{{$detail['userInfo']['mobile']}}</font></td>
                    <td>下单用户</td>
                    <td><font class='text-yellow'>{{$detail['userInfo']['nickname']}}</font></td>
                    <td>下单时间</td>
                    <td><font class='text-blue'>{{$detail['createTime']}}</font></td>
                </tr>

                <tr>
                    <td>订单状态</td>
                    <td><font class='text-green'>
                                @if($detail['payState'] == 1)
                                    未支付
                                @elseif($detail['payState'] == 2)
                                    已支付
                                @elseif($detail['payState'] == 3)
                                    已发货
                                @elseif($detail['payState'] == 4)
                                    已完成
                                @elseif($detail['payState'] == 5)
                                    退货中
                                @elseif($detail['payState'] == 6)
                                    已退货
                                @endif</font></td>
                    <td>订单总价</td>
                    <td><font class='text-yellow'>{{$detail['totalPrice']}}</font></td>
                    <td>支付方式</td>
                    <td><span class='text-red text-bold'>
                                @if($detail['payment'] == 1)
                                   支付宝
                                @elseif($detail['payment'] == 2)
                                    微信
                                @elseif($detail['payment'] == 3)
                                    银联
                                @endif
                            </span>
                    </td>
                    <td>备注</td>
                    <td><font class='text-yellow'>{{$detail['remark']}}</font></td>
                </tr>
            </table>
            <h4 style="border-bottom: 1px solid #CCCCCC; padding: 10px 2px; font-weight: bold">商品信息</h4>
            <table class="table table-condensed table-hover table-bordered rounded">
                <tr>
                    <th>名称</th>
                    <th>数量</th>
                    <th>售价</th>
                    <th>总价</th>
                </tr>

               @foreach ($detail['detail'] as $k => $v)
                <tr>
                    <td><font class='text-yellow'><?php echo $v['name']; ?></font></td>
                    <td><font class='text-yellow'><?php echo $v['number']; ?></font></td>
                    <td><font class='text-yellow'><?php echo $v['price']; ?></font></td>
                    <td><font class='text-red'><?php echo floatval($v['price']) * intval($v['number']) ?></font></td>
                </tr>
                @endforeach

            </table>
             <h4 style="border-bottom: 1px solid #CCCCCC; padding: 10px 2px; font-weight: bold">收货信息</h4>
                         <table class="table table-condensed table-hover table-bordered rounded">
                <tr>
                    <th>收件人</th>
                    <th>电话</th>
                    <th>地址</th>
                </tr>
                <tr>
                    <td><font class='text-yellow'>{{$detail['receiver']}}</font></td>
                    <td><font class='text-yellow'>{{$detail['mobile']}}</font></td>
                    <td><font class='text-yellow'>{{$detail['provinceName'].$detail['cityName'].$detail['districtName'].$detail['address']}}</font></td>
                </tr>

            </table>
            <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
            @if($detail['payState']==2)
            <a href="javascript:;" data-id="{{$detail['id']}}" data-state="3" class="btn btn-primary payState">已发货</a>
            @endif
            @if($detail['payState']==5)
            <a href="javascript:;" data-id="{{$detail['id']}}" data-state="6" class="btn btn-danger payState">已退款</a>
            @endif
        </form>
    </div>
    <div class="box-footer">

    </div>
</div>
    <script>
        /**
         * 更改订单状态
         */
        $('.payState').on('click',function()
        {
            var m=confirm('确定要更改订单状态吗？');
            if (!m) return false;
            $('.payState').attr('disabled', '');;
            var payState = $(this).attr('data-state');
            var orderId = $(this).attr('data-id');
            $.get('/backstage/order/update-paystate', {'orderId':orderId,'payState':payState}, function (res){
                res =JSON.parse(res);
                if(res['status'] == 'success') {
                    window.location.reload();
                } else {
                    alert(res['msg']);
                }

            });

        });
    </script>


@endsection