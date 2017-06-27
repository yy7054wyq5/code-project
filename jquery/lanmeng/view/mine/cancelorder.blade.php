@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-corder">
  <div class="uc-corder-header">
    <div class="title">已取消订单</div>
  </div>
  <div class="uc-corder-body">
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
      <tr>
        <td class="u-pic"><img src="//placehold.it/1000" alt=""></td>
        <td class="u-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis, dolor.</td>
        <td>&yen;191.00</td>
        <td>1</td>
        <td>&yen;191.00</td>
      </tr>
    </table>
    <p class="urow">订单编号：12312312312312</p>
    <p class="urow">收货地址：李四，12-12121212，湖北省 武汉市 哈子区哈子路12号哈子大厦23-23，000000</p>
    <p class="urow">优惠券抵扣：0.00</p>
    <p class="urow">积分抵扣：0.00</p>
    <p class="urow">下单时间：1212012012 12:12:12</p>
    <p class="urow">取消时间：1212012012 12:12:12</p>
    <div class="title">发票信息</div>
    <div class="urow"><div class="llabel">发票类型</div>增值税发票－明细</div>
    <div class="title">结算信息</div>
    <div class="urow"><div class="llabel">商品金额</div>&yen;191.00-抵扣：&yen;0.00+运费：&yen;0.00=<em>&yen;191.00</em></div>
  </div>
</div>
@include('mine.fragment.focus-lg')
@endsection
