@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-coupon">
    <div class="uc-coupon-header">
      <div class="title">我的优惠券</div>
    </div>
    <div class="uc-coupon-body">
      <div class="filter">
        <a class="@if($url == '/mine/coupon?') active @endif" href="/mine/coupon">未使用({{ $useno }})</a>
        <a class="@if($url == '/mine/coupon?type=1&') active @endif" href="/mine/coupon?type=1">已使用({{ $useok }})</a>
        <a class="@if($url == '/mine/coupon?type=4&') active @endif" href="/mine/coupon?type=4">已过期({{ $overdue }})</a>
        <a class="@if($url == '/mine/coupon?type=3&') active @endif" href="/mine/coupon?type=3">已冻结({{ $freezeok }})</a>
      </div>
      <div class="coupons">
        @if(isset($lists[0]))
        @foreach($lists as $value)
        <div class="item item-{{ $value['type'] == 0 ? 1 : 2 }} @if($status == 1) item-used @elseif($status == 3) item-freeze @elseif($status == 4) item-over @endif">
          <div class="card">
            <div class="price">&yen;{{ $value['value'] }}</div>
            <p class="meta">@if($value['type'] == 0) 【直接抵扣】 @else 【消费满{{$value['orderprice']}}元可用】 @endif</p>
            <div class="date">有效时间：{{ date('Y-m-d', $value['begintime']) }}-{{ date('Y-m-d', $value['endtime']) }}</div>
          </div>
          <div class="info">
            <p><span class="llabel">券&emsp;&ensp;编&emsp;&ensp;号：</span>{{ $value['code'] }}</p>
            <p><span class="llabel">品类限制：</span>{{ $value['class'] }}</p>
            <p><span class="llabel">限品分类：</span>@if(empty($value['classdetail'])) 全品类 @elseif(mb_strlen($value['classdetail']) > 100) {{ mb_substr($value['classdetail'], 0, 100, 'utf-8').'...' }} @else {{ $value['classdetail'] }} @endif</p>
          </div>
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </div>
  <div class="uc-score-footer">
    <div class="page-action white clear">
        <a class="page-up nopage" href="{{ $url }}page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
        @for($i = 1; $i <= $count; $i++)
        <a role="button" href="{{ $url }}page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
        @endfor
        <a class="page-down" href="{{ $url }}page={{ $page + 1 >= $count ? $count : $page + 1 }}" role="button">下一页</a>
    </div>
  </div>
  @include('mine.fragment.focus')
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
