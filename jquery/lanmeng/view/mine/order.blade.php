@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-order" id="j_uc_order">
  <div class="w-tab uc-order-filter">
    <div class="w-tab-item @if($url == '/mine/order/11') active @endif"><a href="/mine/order/11">全部订单</a></div>
    <div class="w-tab-item @if($url == '/mine/order/0') active @endif"><a href="/mine/order/0">待付款<b>{{ $payment }}</b></a></div>
    <div class="w-tab-item @if($url == '/mine/order/1') active @endif"><a href="/mine/order/1">待发货<b>{{ $delivery }}</b></a></div>
    <div class="w-tab-item @if($url == '/mine/order/2') active @endif"><a href="/mine/order/2">待收货<b>{{ $take }}</b></a></div>
  </div>
  <table class="w-tb">
    <colgroup span="1" width="11.1111%"></colgroup>
    <colgroup span="1" width="22.2222%"></colgroup>
    <colgroup span="6" width="11.1111%"></colgroup>
    <thead>
      <tr>
        <th>订单信息</th>
        <th>
          <div class="w-drop">
            <a href="#" class="w-drop-toggle">全部订单</a>
            <div class="w-drop-menu">
              <a href="#" class="w-drop-item">最近三个月</a>
            </div>
          </div>
        </th>
        <th>单价</th>
        <th>支付方式</th>
        <th>收货人</th>
        <th>总计</th>
        <th>全部状态</th>
        <th>操作</th>
      </tr>
      <tr class="w-tb-gt">
        <td colspan="8"></td>
      </tr>
    </thead>
    @if(isset($lists[0]))
    @foreach($lists as $value)
    <tbody data-id="1">
      <tr class="uc-order-header">
        <td colspan="8">
          <div class="date">{{ date('Y-m-d H:i:s', $value['created']) }}</div>
          <div class="orderId">订单号：<span>{{ $value['ordersn'] }}</span></div>
          <a class="del" href="/user/api/deleteorder/{{ $value['ordersn'] }}">删除订单</a>
        </td>
      </tr>
      <tr class="uc-order-body">
        <td colspan="3">
          @foreach($value['orderdetail'] as $v)
          <div class="u-goods">
            <a href="/commodity/detail/{{ $v['goodsid'] }}" class="u-pic"><img src="{{ $v['imageurl'] }}" alt=""></a>
            <div class="u-info">
              <a class="title" href="/commodity/detail/{{ $v['goodsid'] }}">{{ $v['goodsname'] }}</a>
              <div class="meta">规格尺寸: {{ $v['specs'] }}</div>
            </div>
            <div class="u-price">
              <div class="price">&yen;{{ $v['price'] }}</div>
              <div class="num">&times;{{ $v['num'] }}</div>
            </div>
          </div>
          @endforeach
        </td>
        <td class="u-payment">{{ $value['pay'] }}</td>
        <td class="u-consignee">{{ isset($value['receive']['consignee']) ? $value['receive']['consignee'] : '---' }}</td>
        <td class="u-amount">
          <div class="price">&yen;{{ sprintf("%.2f", $value['orderprice'] + $value['freight']) }}</div>
          <p class="meta">运费{{ $value['freight'] }}元</p>
          <p class="meta">积分抵扣{{ $value['integral'] / 50 }}元</p>
          <p class="meta">优惠券抵扣{{ $value['coupons'] + $value['vipcode'] }}元</p>
        </td>
        <td class="u-status">
          <span class="status disabled">{{ $value['paystatus'] }}</span>
          <a class="detail" href="/order?id={{ $value['ordersn'] }}">订单详情</a>
            <!-- 是集团用户 -->
          <!-- @if(in_array($value['grouppay'], [1,2,3]))
              @if(in_array($value['groupStatus'], [1,3]))
                <a class="cancel" hidden href="/user/api/cancelorder/{{ $value['ordersn'] }}">取消订单</a>
              @endif
          @else
              @if(in_array($value['status'], [0, 1]))
               <a class="cancel" hidden href="/user/api/cancelorder/{{ $value['ordersn'] }}">取消订单</a>
              @endif
          @endif -->
          @if(in_array($value['status'], [0, 1]))
          <a class="cancel" hidden href="/user/api/cancelorder/{{ $value['ordersn'] }}">取消订单</a>
          @endif
        </td>

          @if(in_array($value['grouppay'], [2,3]))
              <td class="u-operate">
                  @if( $value['status'] == 0 && $value['paycode'] == 0
                  && $value['grouppay'] != \App\Model\Order::$DealerGroupApprovalPayment
                  && $value['groupStatus'] != \App\Model\Order::$pendingAuditGroupStatus
                  && $value['groupStatus'] != \App\Model\Order::$cancelOrderGroupStatus )
                      <a href="/user/api/pay/{{ $value['ordersn'] }}" class="ubtn ubtn-orange">去付款</a>
                  @elseif( $value['status'] == 3 && $value['comment'] == 0)
                      <a href="/mine/orderreply/{{ $value['ordersn'] }}" class="ubtn">去评论</a>
                  @elseif( $value['status'] == 3 && $value['comment'] == 1))
                      <a href="javascript:;" class="ubtn">已评论</a>
                  @elseif( $value['status'] == 2 )
                      <a href="/user/api/receipt/{{ $value['ordersn'] }}" class="ubtn ubtn-blue">确认收货</a>
                  @endif
                  @if($value['groupStatus'] == \App\Model\Order::$pendingAuditGroupStatus || $value['groupStatus'] == 0  )
                      <a class="ubtn" id="reminder">催单</a>
                  @endif
              </td>
         @else
            <td class="u-operate">
              @if($value['status'] == 0 && $value['paycode'] == 0)
                  <a href="/user/api/pay/{{ $value['ordersn'] }}" class="ubtn ubtn-orange">去付款</a>
              @elseif($value['status'] == 5 && $value['type'] == 4)
              @foreach($value['orderdetail'] as $v)
              @if($v['status'] == 0 && $v['finalpay'] && $value['paycode'] == 0 && $v['timeEnd'] < time() && ($v['timeEnd'] + 15 * 86400) >= time())
              {{ $v['goodsname'] }}<a href="/user/api/payfinal/{{ $v['id'] }}" class="ubtn ubtn-orange">支付尾款</a>
              @elseif($v['status'] == 0 && $v['finalpay'] && $value['paycode'] != 0 && $v['timeEnd'] < time() && ($v['timeEnd'] + 15 * 86400) >= time())
              {{ $v['goodsname'] }}<a href="javascript:;" class="ubtn ubtn-orange">尾款待转账</a>
              @endif
              @endforeach

              @elseif($value['status'] == 0 && $value['paycode'] != 0)
              <a href="javascript:;" class="ubtn ubtn-orange">等待转账</a>
              @elseif($value['status'] == 3 && $value['comment'] == 0 )
              <a href="/mine/orderreply/{{ $value['ordersn'] }}" class="ubtn">去评论</a>
              @elseif($value['status'] == 3 && $value['comment'] == 1)
              <a href="javascript:;" class="ubtn">已评论</a>
              @elseif($value['status'] == 2)
              <a href="/user/api/receipt/{{ $value['ordersn'] }}" class="ubtn ubtn-blue">确认收货</a>
              @endif
            </td>
        @endif

      </tr>
      <tr class="w-tb-gt">
        <td colspan="8"></td>
      </tr>
    </tbody>
    @endforeach
    @endif
  </table>
  <div class="page-action white clear">
      <a class="page-up nopage" href="/mine/order/{{ $type }}?page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
      @for($i = 1; $i <= $count; $i++)
      <a role="button" href="/mine/order/{{ $type }}?page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
      @endfor
      <a class="page-down" href="/mine/order/{{ $type }}?page={{ $page + 1 >= $count ? $count : $page + 1 }}" role="button">下一页</a>
  </div>
</div>
@include('mine.fragment.focus-lg')
@endsection

@section('footer-scripts')
  @parent
<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', '#reminder', function() {
        load($.get('/user/api/email-reminder-api/'+$('.orderId span').html()))
        .done(function (data) {
            littleTips(data.tips);
        })
        .fail(function () {
            littleTips('操作失败，请稍候再试');
        });
    });

});
</script>
@endsection


