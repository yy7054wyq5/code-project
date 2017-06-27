@extends('layouts.main')

@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
@endsection
@section('banner-left')
  <ul class="notice">
    <li class="title">蓝网公告</li>
      @if(isset($notices) && count($notices) > 0)
          @foreach($notices as $notice)
              <li><a href="/store/notice/{{$notice['id']}}" title="{{$notice['title']}}" target="_self" role="button">{{$notice['title']}}</a></li>
          @endforeach
      @endif
  </ul>
@endsection
@section('banner-carousel')
<!-- 幻灯片 -->
<div id="carousel-banner" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      @if(isset($topAds) && count($topAds)>0 )
          @for($i=0;$i<count($topAds);$i++)
              @if($i == 0)
                  <li data-target="#carousel-banner" data-slide-to="{{$i}}" class="active"></li>
              @else
                  <li data-target="#carousel-banner" data-slide-to="{{$i}}"></li>
              @endif
          @endfor
      @endif
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
      @if(isset($topAds) && count($topAds) >0)
          @foreach($topAds as $k=>$topAd)
              <div class="item @if($k == 0) active @endif">
                  <a href="{{ $topAd['link']?$topAd['link']:'#' }}"><img src="{{$topAd['path']}}" alt="..."></a>
              </div>
          @endforeach
      @endif
  </div>
  <!-- Controls -->
    <a class="left carousel-control" href="#carousel-banner" role="button" data-slide="prev"></a>
    <a class="right carousel-control" href="#carousel-banner" role="button" data-slide="next"></a>
</div>
@endsection
@section('content')
<div class="store-main">
  <div class="container index-main">
    <div class="store-left">
      <!-- 1L -->
      <h1 class="floor-1">特价促销<small>Special promotion</small></h1>
      <div class="adv-box clear">
         @if(isset($specialPriceAds) && count($specialPriceAds)>0 )
              @foreach($specialPriceAds as $specialPriceAd)
                  <div class="small-adv">
                      <a href="{{$specialPriceAd['link']?$specialPriceAd['link']:'#'}}" target="_self"><img src="/img/temp-img.png" class="lazy" data-original="{{$specialPriceAd['path']}}" title="{{$specialPriceAd['title']}}" /></a>
                      <h5><a href="{{$specialPriceAd['link']?$specialPriceAd['link']:'#'}}" target="_self" title="{{$specialPriceAd['title']}}">{{$specialPriceAd['title']}}</a></h5>
                      <p>￥{{$specialPriceAd['presentPrice']}}</p>
                  </div>
              @endforeach
         @endif
        <div class="myclear"></div><!-- IE7清除浮动 -->
      </div>
        @if(isset($afterSpecialPriceAd) && count($afterSpecialPriceAd)>0)
             <a role="button" href="{{$afterSpecialPriceAd->link?$afterSpecialPriceAd->link:'#'}}" target="_self" title="{{$afterSpecialPriceAd->title}}"><img src="{{$afterSpecialPriceAd->path}}" class="img-adv"></a>
        @else
             <a role="button" href="#" target="_self" title=""><img src="#" class="img-adv"></a>
       @endif
      <!-- 2L -->
        @if(isset($materielCategory) && $materielCategory)
      <h1 class="floor-2">展厅物料<small>Exhibition hall material</small>
        <span class="sub">
            @if(array_get($materielCategory, 'children'))
                @foreach(array_get($materielCategory, 'children') as $key=>$child)
                    <a role="button" href="/store/list?categoryId={{$child['id']}}" title="" target="_self" @if($key == 0) class="noleft" @endif>{{$child['name']}}</a>
                @endforeach
            @endif
            <a role="button" href="/store/list?categoryId={{ $materielCategory['id'] }}" title="" target="_self">更多物料</a>
        </span>
      </h1>
      <div class="adv-box clear">
          @if(isset($materielAds) && count($materielAds)>0)
              @foreach($materielAds as $materielAd)
                  <div class="small-adv">
                      <a href="{{$materielAd['link']?$materielAd['link']:'#'}}" target="_self"><img src="/img/temp-img.png" class="lazy" data-original="{{$materielAd['path']}}" title="{{$materielAd['title']}}" /></a>
                      <h5><a href="{{$materielAd['link']?$materielAd['link']:'#'}}" target="_self" title="{{$materielAd['title']}}">{{$materielAd['title']}}</a></h5>
                      <p>￥{{$materielAd['presentPrice']}}</p>
                  </div>
              @endforeach
         @endif
        <div class="myclear"></div><!-- IE7清除浮动 -->
      </div>
        @endif
      <!-- 3L -->
    @if(isset($giftCategory) && $giftCategory)
      <h1 class="floor-3">礼品定制<small>Gift customization</small>
        <span class="sub">
             @if(array_get($giftCategory, 'children'))
                @foreach(array_get($giftCategory, 'children') as $key=>$child)
                    <a role="button" href="/store/list?categoryId={{$child['id']}}" title="" target="_self" @if($key == 0) class="noleft" @endif>{{$child['name']}}</a>
                @endforeach
            @endif
                 <a role="button" href="/store/list?categoryId={{$giftCategory['id']}}" title="" target="_self">更多礼品</a>
        </span>
      </h1>
      <div class="adv-box clear">
          @if(isset($giftAds) && count($giftAds)>0)
              @foreach($giftAds as $giftAd)
                  <div class="small-adv">
                      <a href="{{$giftAd['link']?$giftAd['link']:'#'}}" target="_self"><img src="/img/temp-img.png" class="lazy" data-original="{{$giftAd['path']}}" title="{{$giftAd['title']}}" /></a>
                      <h5><a href="{{$giftAd['link']?$giftAd['link']:'#'}}" target="_self" title="{{$giftAd['title']}}">{{$giftAd['title']}}</a></h5>
                      <p>￥{{$giftAd['presentPrice']}}</p>
                  </div>
              @endforeach
          @endif
        <div class="myclear"></div><!-- IE7清除浮动 -->
      </div>
    @endif
        @if(isset($afterGiftAd) && count($afterGiftAd)>0 )
            <a role="button" href="{{$afterGiftAd->link?$afterGiftAd->link:'#'}}" target="_self" title="{{$afterGiftAd->title}}"><img src="{{$afterGiftAd->path}}" class="img-adv"></a>
        @else
            <a role="button" href="#" target="_self" title=""><img src="#" class="img-adv"></a>
        @endif
                <!-- 4L -->
    @if(isset($outExpandCategory) && count($outExpandCategory)>0)
      <h1 class="floor-4">外拓展具<small>Exhibition hall furniture</small>
        <span class="sub">
            @if(array_get($outExpandCategory, 'children'))
                @foreach(array_get($outExpandCategory, 'children') as $key=>$child)
                    <a role="button" href="/store/list?categoryId={{$child['id']}}" title="" target="_self" @if($key == 0) class="noleft" @endif>{{$child['name']}}</a>
                @endforeach
            @endif
            <a role="button" href="/store/list?categoryId={{$outExpandCategory['id']}}" title="" target="_self">更多外拓</a>
        </span>
      </h1>
      <div class="adv-box clear">
        @if(isset($outExpandAds) && count($outExpandAds)>0)
              @foreach($outExpandAds as $outExpandAd)
                  <div class="small-adv">
                      <a href="{{$outExpandAd['link']?$outExpandAd['link']:'#'}}" target="_self"><img src="/img/temp-img.png" class="lazy" data-original="{{$outExpandAd['path']}}" title="{{$outExpandAd['title']}}" /></a>
                      <h5><a href="{{$outExpandAd['link']?$outExpandAd['link']:'#'}}" target="_self" title="{{$outExpandAd['title']}}">{{$outExpandAd['title']}}</a></h5>
                      <p>￥{{$outExpandAd['presentPrice']}}</p>
                  </div>
              @endforeach
         @endif
        <div class="myclear"></div><!-- IE7清除浮动 -->
      </div>
    @endif
      <!-- 5L -->
    @if(isset($furnitureCategory) && count($furnitureCategory)>0)
      <h1 class="floor-5">展厅家具<small>Exhibition hall furniture</small>
        <span class="sub">
             @if(array_get($furnitureCategory, 'children'))
                @foreach(array_get($furnitureCategory, 'children') as $key=>$child)
                    <a role="button" href="/store/list?categoryId={{$child['id']}}" title="" target="_self" @if($key == 0) class="noleft" @endif>{{$child['name']}}</a>
                @endforeach
            @endif
            <a role="button" href="/store/list?categoryId={{$furnitureCategory['id']}}" title="" target="_self">更多家具</a>
      </span>
      </h1>
      <div class="adv-box clear">
         @if(isset($furnitureAds) && count($furnitureAds)>0)
          @foreach($furnitureAds as $furnitureAd)
              <div class="small-adv">
                  <a href="{{$furnitureAd['link']?$furnitureAd['link']:'#'}}" target="_self"><img src="/img/temp-img.png" class="lazy" data-original="{{$furnitureAd['path']}}" title="{{$furnitureAd['title']}}" /></a>
                  <h5><a href="{{$furnitureAd['link']?$furnitureAd['link']:'#'}}" target="_self" title="{{$furnitureAd['title']}}">{{$furnitureAd['title']}}</a></h5>
                  <p>￥{{$furnitureAd['presentPrice']}}</p>
              </div>
          @endforeach
      @endif
        <div class="myclear"></div><!-- IE7清除浮动 -->
      </div>
    @endif
    </div>
    <div class="store-right">
      <h2>热销宝贝</h2>
      <div class="side-bar duoduo">
          <ul>
              @if(isset($rightAds) && count($rightAds)>0)
                  @foreach($rightAds as $rightAd)
                      <li><a href="{{$rightAd['link']?$rightAd['link']:'#'}}" target="_self" title="{{$rightAd['title']}}">
                              <img src="{{$rightAd['path']}}"/>
                              <p class="side-font">{{$rightAd['title']}}</p>
                          </a>
                          <span>￥{{$rightAd['presentPrice']}}</span>
                      </li>
                  @endforeach
              @endif
          </ul>
      </div>
    </div>
    <div class="myclear"></div>
  </div>
</div>
@endsection



