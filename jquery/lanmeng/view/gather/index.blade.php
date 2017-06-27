@extends('layouts.main')

@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
@endsection

@section('banner')
  <div class="banner">
    <div class="container">
    <div class="banner-right no-left">
    @section('banner-carousel')
    <!-- 幻灯片 -->
    <div id="carousel-banner" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
          @if(count($carouselList))
              @foreach($carouselList as $key => $item)
                <li data-target="#carousel-banner" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif"></li>
              @endforeach
          @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
          @if(count($carouselList))
              @foreach($carouselList as $key => $item)
                <div class="item @if($key == 0) active @endif">
                  <a href="{{$item['link'] ? $item['link'] : "#"}}"><img src="{{$item['path']}}" alt="{{$item['title']}}"></a>
                </div>
              @endforeach
          @endif
      </div>
      <!-- Controls -->
        <a class="left carousel-control" href="#carousel-banner" role="button" data-slide="prev"></a>
        <a class="right carousel-control" href="#carousel-banner" role="button" data-slide="next"></a>
    </div>
    @show
    </div>
    </div>
  </div>
@endsection
@section('content')
<div class="gather-main">
<div class="container">
    <h1>
        火爆团购
        <small>
            @if(isset($gatherType[0]))
            @foreach($gatherType as $value)
            <a href="ju/list?categoryId={{ $value['id'] }}" target="_self">{{ $value['name'] }}</a>|
            @endforeach
            @endif
            <a href="/ju/list" target="_self">更多团购</a>
        </small>
    </h1>
    <div class="hot-con">
 {{-- 单个团购 --}}
 @if(isset($gatherLists[0]))
 @foreach($gatherLists as $value)
 <div class="item">
     <a href="/commodity/detail/{{ $value['id'] }}" target="_self"><img src="/img/temp-img.png" data-original="{{ $value['imageurl'] }}" class="lazy"></a>
     <div class="info">
         <h3>{{ $value['name'] }}</h3>
         <h4>{{ $value['title'] }}</h4>
         <span class="price">￥{{ $value['price'] }}</span>
         <span class="old-price">￥{{ $value['oldprice'] }}</span>
         <p>@if($value['state'] == 0) 距离开始 @else 剩余时间 @endif</p>
         <ul class="time">
             <li class="day"><span>18</span><div class="shade"></div></li>
             <li>天</li>
             <li class="hour"><span>18</span><div class="shade"></div></li>
             <li>时</li>
             <li class="minute"><span>59</span><div class="shade"></div></li>
             <li>分</li>
             <li class="second"><span>59</span><div class="shade"></div></li>
             <li>秒</li>
         </ul>
         <input type="hidden" class="endTime" value="{{ $value['state'] == 0 ? $value['timeStart'] * 1000 : $value['timeEnd'] * 1000 }}">
         {{-- 将团购结束时间放入endTime的value内 --}}
         <a class="btn" href="/commodity/detail/{{ $value['id'] }}" target="_self">立即抢购</a>
     </div>
     <div class="clear-box"></div>
 </div>
 @endforeach
 @endif
 {{-- 单个团购结束 --}}
    </div>
     <input type="hidden" name="current" value="{{ time() * 1000 }}">
    <div class="clear-box"></div>
    <h2>
        热门预购
        <small>
            @if(isset($preorderCategories) && count($preorderCategories)>0)
                @foreach($preorderCategories as $preorderCategory)
                <a href="/ju/readylist?categoryId={{$preorderCategory['id']}}" target="_self">{{$preorderCategory['name']}}</a>|
                @endforeach
            @endif
            <a href="/ju/readylist" target="_self">更多预购</a>
        </small>
    </h2>
    <div class="con">
        @if(isset($preorderCommodities) && count($preorderCommodities) >0)
            @foreach($preorderCommodities as $preorderCommodity)
            <div class="item">
                <a href="/commodity/detail/{{$preorderCommodity['id']}}" target="_self"><img src="/img/temp-img.png" data-original="/image/get/{{$preorderCommodity['cover']}}" class="lazy"></a>
                <div class="info">
                    <h3>【{{$preorderCommodity['name']}}】</h3>
                    <h4>{{$preorderCommodity['title']}}</h4>
                    <span class="price">￥{{$preorderCommodity['prepayPrice']}}</span>
                    <span class="old-price"></span>
                    <p>@if($preorderCommodity['state'] == 0) 距离开始 @else 剩余时间 @endif</p>
                    <ul class="time">
                        <li class="day"><span>18</span><div class="shade"></div></li>
                        <li>天</li>
                        <li class="hour"><span>{{$preorderCommodity['delayHour']}}</span><div class="shade"></div></li>
                        <li>时</li>
                        <li class="minute"><span>{{$preorderCommodity['delayMinute']}}</span><div class="shade"></div></li>
                        <li>分</li>
                        <li class="second"><span>{{$preorderCommodity['delaySecond']}}</span><div class="shade"></div></li>
                        <li>秒</li>
                    </ul>
                    <input type="hidden" class="endTime" value="{{$preorderCommodity['timeEnd'] * 1000}}">
                    <a class="btn" href="/commodity/detail/{{$preorderCommodity['id']}}" target="_self">立即抢购</a>
                </div>
                <div class="clear-box"></div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="clear-box"></div>
</div>
</div>
@endsection
