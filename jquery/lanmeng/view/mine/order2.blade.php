@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-order uc-order2" id="j_uc_order2">
  <table class="w-tb">
    <colgroup span="1" width="12.5%"></colgroup>
    <colgroup span="1" width="25%"></colgroup>
    <colgroup span="5" width="12.5%"></colgroup>
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
        <th>总计</th>
        <th>
          <div class="w-drop">
            <a href="#" class="w-drop-toggle">全部状态</a>
            <div class="w-drop-menu">
              <a href="#" class="w-drop-item">等待付款</a>
              <a href="#" class="w-drop-item">等待发货</a>
              <a href="#" class="w-drop-item">等待收货</a>
              <a href="#" class="w-drop-item">已完成</a>
              <a href="#" class="w-drop-item">已取消</a>
            </div>
          </div>
        </th>
        <th>操作</th>
      </tr>
      <tr class="w-tb-gt">
        <td colspan="7"></td>
      </tr>
    </thead>
    @if(isset($lists[0]))
    @foreach($lists as $value)
    <tbody data-id="1">
      <tr class="uc-order-header">
        <td colspan="8">
          <div class="date">{{ date('Y-m-d H:i:s', $value['created']) }}</div>
          <div class="orderId">订单号：{{ $value['ordersn'] }}</div>
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
              <div class="price">{{ intval($v['price']) }} 积分 </div>
              <div class="num">&times;{{ $v['num'] }}</div>
            </div>
          </div>
          @endforeach
        </td>
        <td class="u-payment">{{ $value['pay'] }}</td>
       <!-- <td class="u-consignee">{{--isset($value['receive']['consignee']) ? $value['receive']['consignee'] : "---" --}}</td> -->
          <!-- <td class="u-consignee">{{$totalprice}}积分</td> -->
        <td class="u-amount">
          <div class="price">{{ $value['integral'] }}积分</div>
          <!-- <p class="meta">积分抵扣{{ $value['integral'] / 50 }}元</p>
          <p class="meta">优惠券抵扣{{ $value['coupons'] }}元</p> -->
        </td>
        <td class="u-status">
          <span class="status disabled">{{ $value['paystatus'] }}</span>
          <a class="detail" href="/order2?id={{ $value['ordersn'] }}">订单详情</a>
          @if(in_array($value['status'], [0, 1]))
          <a class="cancel" hidden href="/user/api/cancelorder/{{ $value['ordersn'] }}">取消订单</a>
          @endif
        </td>
        <td class="u-operate">
          @if($value['status'] == 3 && $value['comment'] == 0)
          <a href="/mine/orderreply/{{ $value['ordersn'] }}" class="ubtn">去评论</a>
          @elseif($value['status'] == 3 && $value['comment'] == 1)
          <a href="javascript:;" class="ubtn">已评论</a>
          @elseif($value['status'] == 2)
          <a href="/user/api/receipt/{{ $value['ordersn'] }}" class="ubtn ubtn-blue">确认收货</a>
          @endif
          <!-- <span class="meta">已评</span> -->
        </td>
      </tr>
      <tr class="w-tb-gt">
        <td colspan="8"></td>
      </tr>
    </tbody>
    @endforeach
    @endif
  </table>
  <div class="page-action white clear">
      <a class="page-up nopage" href="/mine/order2?page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
      @for($i = 1; $i <= $count; $i++)
      <a role="button" href="/mine/order2?page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
      @endfor
      <a class="page-down" href="/mine/order2?page={{ $page + 1 >= $count ? $count : $page + 1 }}" role="button">下一页</a>
  </div>
</div>
@include('mine.fragment.focus-lg')
@endsection
