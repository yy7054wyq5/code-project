@extends('mine.fragment.layout')
@section('uc-content')
<!-- user -->
<div class="uc-user" id="j_uc_user">
  <div class="u1">
    <img class="userIcon" src="{{ $info->imageurl ? $info->imageurl : '/img/auto-portrait-one.jpg' }}">
    <div class="nickName">{{ $info['username'] }}</div>
    <div class="meta">
      <img src="/img/mine/lv/me_home_grow_ic2_v{{ $info->level }}.png" alt="">
      <a href="/mine/grow">V{{ $info->level }}会员</a>
      <span>{{ $userrole }}</span>
    </div>
    <p class="tip">每日签到送10积分</p>
  </div>
  <div class="u2">
    <a href="/mine/order/0" class="item">
      <img src="/img/mine/me_home_ic_dfk.png" alt="">
      <div>待付款 <b>{{ $pay }}</b></div>
    </a>
    <a href="/mine/order/2" class="item">
      <img src="/img/mine/me_home_ic_dfk.png" alt="">
      <div>待收货 <b>{{ $loading }}</b></div>
    </a>
    <a href="/mine/order/1" class="item">
      <img src="/img/mine/me_home_ic_dfk.png" alt="">
      <div>待发货 <b>{{ $put }}</b></div>
    </a>
    <a href="/cart" class="item">
      <img src="/img/mine/me_home_ic_dfk.png" alt="">
      <div>购物车 <b>{{ $cart }}</b></div>
    </a>
  </div>
  <div class="u3">
    <div class="panel">
      <p>会员等级： VIP{{ $info->level }}</p>
      <p>我的成长值： {{ $info['growth'] }}</p>
      <p>我的积分： {{ $info['integral'] }}</p>
      <p>我的优惠券： <b>{{ $coupons }}</b></p>
      <a href="javascript:;" class="sign {{ $isSigned ? 'disabled' : '' }}">签到</a>
    </div>
  </div>
</div>
<!-- end user -->

<div class="uc-main-main">
  <!-- my order -->
  <div class="uc-order0 uc-order">
    <div class="uc-order0-header">
      <div class="title">我的订单</div>
      <div class="side"><a href="/mine/order/11">查看全部订单</a></div>
    </div>
    <table class="w-tb">
      <colgroup span="1" width="14.2857%"></colgroup>
      <colgroup span="1" width="28.5714%"></colgroup>
      <colgroup span="5" width="14.2857%"></colgroup>
      @if(isset($order[0]))
      @foreach($order as $value)
      <tbody>
        <tr class="uc-order-header">
          <td colspan="7">
            <div class="date">{{ date('Y-m-d H:i:s', $value['created']) }}</div>
            <div class="orderId">订单号：<span>{{ $value['ordersn'] }}</span></div>
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
            </div>
            @endforeach
          </td>
          <td class="u-payment">{{ $value['pay'] }}</td>
          <td class="u-amount">
            <div class="price">&yen;{{ sprintf("%.2f", $value['orderprice'] + $value['freight']) }}</div>
            <p class="meta">运费{{ $value['freight'] }}元</p>
            <p class="meta">积分抵扣{{ $value['integral'] / 50 }}元</p>
            <p class="meta">优惠券抵扣{{ $value['coupons'] }}元</p>
          </td>
          <td class="u-status">
            <span class="status disabled">{{ $value['paystatus'] }}</span>
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
                    @elseif($value['status'] == 3 && $value['comment'] < count($value['orderdetail']))
                        <a href="/mine/orderreply/{{ $value['ordersn'] }}" class="ubtn">去评论</a>
                    @elseif($value['status'] == 3 && $value['comment'] >= count($value['orderdetail']))
                        <a href="javascript:;" class="ubtn">已评论</a>
                    @elseif($value['status'] == 2)
                        <a href="/user/api/receipt/{{ $value['ordersn'] }}" class="ubtn ubtn-blue">确认收货</a>
                    @endif
                </td>
          @endif

        </tr>
        <tr class="w-tb-gt">
          <td colspan="7"></td>
        </tr>
      </tbody>
      @endforeach
      @endif
    </table>
  </div>
  <!-- end my order -->
  @include('mine.fragment.focus')
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection

@section('footer-scripts')
  @parent
<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', '#reminder', function() {
        var orderId = $('#orderId span').html();
        load($.get('/user/api/email-reminder-api/'+orderId))
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
