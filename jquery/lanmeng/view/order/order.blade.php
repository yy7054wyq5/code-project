@extends('layouts.main')

@section('banner')
@endsection

@section('content')
  <style>
.logistics{
  background: #fff;
  /*padding: 10px;*/
  font-size: 12px;
  color: #666;
  list-style-type: square;
  border: 1px solid #ececec;
}
.logistics li {
  padding: 8px 10px 8px 140px;
}
.logistics li:nth-child(even) {
  background: #f2f2f2;
}
.logistics .date{
  display: inline-block;
  width: 130px;
  margin-left: -130px;
  /*font-weight: bold;*/
}
.logistics .info{
  display: inline;
}
  </style>
  <div class="container">
    <ul class="w-crumb">
      <li><a href="/mine">我的蓝网</a></li>
      <li><a href="/order">我的订单</a></li>
      <li class="disabled"><a href="javascript:;">订单号：{{ $ordersn }}</a></li>
    </ul>
    <div class="order-status-bar">
      <ul class="status">
        <li class="item on">提交订单<span>{{ date('Y-m-d H:i:s', $detail->created) }}</span></li>
        @if($detail->pay == 0)
        <li class="item @if($detail->status == 1) on arrow @elseif($detail->status > 1) on @endif">付款成功<span><!-- 1212-12-12 12:12:12 --></span></li>
        @endif
        <li class="item @if($detail->status == 2) on arrow @elseif($detail->status > 2) on @endif">商品发货<span></span></li>
        <li class="item @if($detail->status == 3) on arrow @endif">订单完成<span></span></li>
      </ul>
    </div>
   @if(in_array($detail->grouppay,[1,2,3]))
    @if($detail->pay == 0 && $detail->status == 0)
    <!-- step1 -->
    <div class="order-status-intro">
      <h3>当前订单状态：等待付款</h3>
      <p>1. 亲，商品已经拍下，请尽快付款，我们将安排为您发货&ensp;&ensp;&ensp;&ensp;点击<a href="/user/api/pay/{{ $ordersn }}" class="ubtn">去付款</a></p>
      <p>2. 如果您不想购买了，也可以<a class="link-orange" href="/user/api/cancelorder/{{ $ordersn }}">取消订单</a></p>
    </div>
    @endif
    @if($detail->pay == 0 && $detail->status == 1)
    <!-- step2 -->
    <div class="order-status-intro">
      <h3>当前订单状态：付款成功</h3>
      <p>1. 您已成功付款，我们会尽快安排发货，您可以通过电话或QQ联系我们确认发货时间；对于客服人员没有履行承诺的情况，如需投诉，您可以<a href="#" class="link-blue">投诉维权</a></p>
      <p>2. 如果您不想要此商品，您可以联系客服进行退款事宜，服务热线<a href="javascript:;" class="link-orange">400-030-8555</a></p>
    </div>
    @endif
    @if($detail->status == 2)
    <!-- step3 -->
    <div class="order-status-intro">
      <h3>当前订单状态：商品已发货</h3>
      <p>1. 您的商品我们已经发货，如果您已收到货，且对商品满意，您可以<a href="/user/api/receipt/{{ $ordersn }}" class="ubtn blue">立即收货</a></p>
      <p>2. 如果您长时间还未收到商品，请联系我们。服务热线<a href="javascript:;" class="link-orange">400-030-8555</a></p>
      <div style="margin-top: 25px;">物流公司：{{ $detail->ologcom ? $detail->ologcom : '暂无数据' }}，物流单号：{{ $detail->logistics ? $detail->logistics : '暂无数据' }}</div>
      <ul class="logistics">
        @if($logisticsdetail)
        @foreach($logisticsdetail as $value)
        <li>
          <div class="date">{{ $value->datetime }}</div>
          <div class="info">{{ $value->remark }}</div>
        </li>
        @endforeach
        @else
        <li>
          <div class="info">对不起，没有查到物流信息！</div>
        </li>
        @endif
      </ul>
    </div>
    @endif
    @if($detail->status == 3)
    <!-- step4 -->
    <div class="order-status-intro">
      <h3>当前订单状态：交易已完成</h3>
      <p>1. 订单已经完成，感谢您在蓝网购物，欢迎您对本地交易及所购商品发表评价<a href="/mine/orderreply/{{ $ordersn }}" class="link-blue">发表评价</a></p>
      <p>2. 如果没有收到货，或收到货后出现问题，您可以联系我们协商解决。服务热线<a href="javascript:;" class="link-blue">400-030-8555</a></p>
      <div style="margin-top: 25px;">物流公司：{{ $detail->ologcom ? $detail->ologcom : '暂无数据' }}，物流单号：{{ $detail->logistics ? $detail->logistics : '暂无数据' }}</div>
      <ul class="logistics">
        @if($logisticsdetail)
        @foreach($logisticsdetail as $value)
        <li>
          <div class="date">{{ $value->datetime }}</div>
          <div class="info">{{ $value->remark }}</div>
        </li>
        @endforeach
        @else
        <li>
          <div class="info">对不起，没有查到物流信息！</div>
        </li>
        @endif
      </ul>
    </div>
    @endif
@endif
    <div class="order-status-desc">
      <div class="hd">订单信息</div>
      <div class="bd">
        <ul>
          <li><b>订单编号：</b>{{ $ordersn }}</li>
          <li><b>收货地址：</b>{{ $detail->receive->consignee }}，{{ $detail->receive->mobile }}，{{ $detail->receive->province }} {{ $detail->receive->city }} {{ $detail->receive->address }}，{{ $detail->receive->zipcode }}
          </li>
          <li><b>优惠券抵扣：</b>&yen;{{ $detail->coupons }}</li>
          <li><b>抵金券抵扣：</b>&yen;{{ $detail->vipcode }}</li>
          <li><b>积分抵扣：</b>&yen;{{ $detail->integral / 50 }}</li>
          <li><b>下单时间：</b>{{ date('Y-m-d H:i:s', $detail->created) }}</li>
        </ul>
        <table>
          <col width="14.2857%">
          <col width="42.8571%">
          <col width="14.2857%">
          <col width="14.2857%">
          <col width="14.2857%">
          <tr>
            <th>商品图片</th>
            <th>商品名称</th>
            <th>单价</th>
            <th>数量</th>
            <th>总价</th>
          </tr>
          @if($list)
          @foreach($list as $value)
          <tr>
            <td><img src="{{ $value['imageurl'] }}" alt=""></td>
            <td class="title">{{ $value['goodsname'] }}</td>
            <td>&yen;{{ $value['price'] }}</td>
            <td>{{ $value['num'] }}</td>
            <td>&yen;{{ $value['num'] * $value['price'] }}</td>
          </tr>
          @endforeach
          @endif
        </table>
        <div class="amount">
          <a target="_blank" href="/orderpdf/{{ $ordersn }}" class="ubtn">报价单</a>
          <div class="price"><b>订单总金额：</b><span class="orange">&yen;{{ $detail->order_price }}</span></div>
        </div>
      </div>
      <div class="ft">
        <p>订单总金额：&yen;{{ $detail->order_price }}</p>
        <p>- 抵扣：&yen;{{ $detail->integral / 50 + $detail->coupons + $detail->vipcode }}</p>
        <p>+ 运费：&yen;{{ $detail->freight }}</p>
        @if($detail->type == 4)
        <p>定金：&yen;{{ $detail->price }}</p>
        @endif
        <p class="count">实付款：<strong>&yen;{{ $detail->type == 4 ? $detail->order_price : sprintf("%.2f", ($detail->price + $detail->freight + $detail->install)) }}</strong></p>
      </div>
    </div>
  </div>
@endsection
