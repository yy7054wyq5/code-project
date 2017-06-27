@extends('layouts.main')
@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
@endsection
@section('banner')
    <div class="banner">
        <div class="container">
            {{-- ********************************banner左边区域******************************** --}}
            <div class="banner-left">@yield('banner-left')</div>
            {{-- ********************************banner幻灯片******************************** --}}
            <div class="banner-right">
                @section('banner-carousel')
                        <!-- 幻灯片 -->
                <div id="carousel-banner" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @if(isset($carouselList) && count($carouselList)>0)
                            @foreach($carouselList as $key => $item)
                                <li data-target="#carousel-banner" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif"></li>
                            @endforeach
                        @endif
{{--                         <li data-target="#carousel-banner" data-slide-to="4"></li> --}}
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @if(isset($carouselList) && count($carouselList)>0)
                            @foreach($carouselList as $key => $item)
                            <div class="item {!! $key==0 ? 'active':''  !!} ">
                                <a href="{!!$item->link ? $item->link : '#'!!}"><img src="{{$item->path}}" alt="..."></a>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- Controls -->
                    @if(count($carouselList)>1)
                    <a class="left carousel-control" href="#carousel-banner" role="button" data-slide="prev"></a>
                    <a class="right carousel-control" href="#carousel-banner" role="button" data-slide="next"></a>
                     @endif
                </div>
                @show
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="home-main">
  <div class="container index-main">
    <!-- ************1L************ -->
    <h1 class="floor-1">热销产品<small>Hot sale</small></h1>
      <div class="floor-left">
        <!-- 幻灯片 -->
        <div id="carousel-main-fl1" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
                  @if($hotSaleLeftList)
                    @foreach($hotSaleLeftList as $key => $item)
                     <li data-target="#carousel-main-fl1" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif"></li>
                    @endforeach
                  @endif
          </ol>
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
              @foreach($hotSaleLeftList as $key => $item)
            <div class="item  {!!$key==0 ? 'active':''  !!}">
              <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="{{$item->path}}" alt="{{$item->title}}"></a>
              <div class="carousel-caption">
                  <h3><a href="{!!$item->link ? $item->link : '#'!!}" target="_self">{{$item->title}}</a></h3>
                  <p>￥{{$item->presentPrice}}</p>
                </div>
            </div>
              @endforeach
          </div>
        </div>
      </div>
    <div class="floor-right">
        <div class="big-adv">
          <a href="{!! $hotSaleBigCenterList['link'] ? $hotSaleBigCenterList['link']:'#' !!}" target="_self"><img  src="/img/temp-img.png"  data-original="{{$hotSaleBigCenterList['path']}}" class="lazy" title="{{$hotSaleBigCenterList['title']}}" /></a>
          <h3><a href="{!! $hotSaleBigCenterList['link'] ? $hotSaleBigCenterList['link']:'#' !!}" target="_self">{{$hotSaleBigCenterList['title']}}</a></h3>
          <p>￥{{$hotSaleBigCenterList['presentPrice']}}</p>
        </div>

        @foreach($hotSaleSmallRightList as $key => $item)
            <div class="small-adv {!! $key >2 ? 'mtop6' : '' !!} ">
             <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="/img/temp-img.png" data-original="{{$item->path}}" class="lazy" title="{{$item->title}}" /></a>
             <h5><a href="{!!$item->link ? $item->link : '#'!!}" target="_self" title="{{$item->title}}">{{$item->title}}</a></h5>
             <p>￥{{$item->presentPrice}}</p>
            </div>
        @endforeach
    </div>
    <!-- ************2L************ -->
    <h1 class="floor-2">素材库<small>Material library</small></h1>
    <div class="floor-left">
      <!-- 幻灯片 -->
      <div id="carousel-main-fl2" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @if($SourceMaterialLeftList)
            @foreach($SourceMaterialLeftList as $key =>$item)
              <li data-target="#carousel-main-fl2" data-slide-to="{{$key}}" class=" @if($key == 0)) active  @endif"></li>
            @endforeach
           @endif
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach($SourceMaterialLeftList as $key =>$item)
              <div class="item {!!$key==0 ? 'active':''  !!}">
                <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="{{$item->path}}" alt="{{$item->title}}"></a>
                <div class="carousel-caption">
                    <h3><a href="{!!$item->link ? $item->link : '#'!!}" target="_self" title="{{$item->title}}">{{$item->title}}</a></h3>
                    <p>{{$item->presentPrice ? "￥".$item->presentPrice :"￥0.0" }}</p>
                  </div>
              </div>
            @endforeach
        </div>
      </div>
    </div>
    <div class="floor-right">
        @if(count($SourceMaterialBigCenterList)>0)
        <div class="big-adv">
            <a href="{{$SourceMaterialBigCenterList['link'] ? $SourceMaterialBigCenterList['link'] :'#'  }}" target="_self"><img src="/img/temp-img.png" data-original="{{$SourceMaterialBigCenterList->path}}" class="lazy" title="{{$SourceMaterialBigCenterList->title}}" /></a>
            <h3><a href="{{$SourceMaterialBigCenterList['link'] ? $SourceMaterialBigCenterList['link'] :'#' }}" target="_self" title="{{$SourceMaterialBigCenterList->title}}">{{$SourceMaterialBigCenterList->title}}</a></h3>
            <p>{{$SourceMaterialBigCenterList->presentPrice ? "￥".$SourceMaterialBigCenterList->presentPrice :"￥0.0" }}</p>
        </div>
        @endif

        @foreach($SourceMaterialSmallRightList as $key => $item)
            <div class="small-adv  {!!$key>2 ? 'mtop6':''  !!} ">
                <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="/img/temp-img.png" data-original="{{$item->path}}" class="lazy"  title="{{$item->title}}"/></a>
                <h5><a href="{!!$item->link ? $item->link : '#'!!}" target="_self" title="{{$item->title}}">{{$item->title}}</a></h5>
                <p>{{$item->presentPrice ? "￥".$item->presentPrice :"￥0.0" }}</p>
            </div>
        @endforeach
    </div>
    <!-- ************3L************ -->
    <h1 class="floor-3">多多推荐<small>Best buy</small></h1>
    <div class="floor-left">
      <!-- 幻灯片 -->
      <div id="carousel-main-fl3" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @if($DuoDuoLeftList)
            @foreach($DuoDuoLeftList as $key => $item)
                 <li data-target="#carousel-main-fl3" data-slide-to="{{$key}}" class=" @if($key == 0) active  @endif"></li>
            @endforeach
            @endif
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach($DuoDuoLeftList as $key => $item)
              <div class="item {!!$key==0 ? 'active':''  !!}">
                <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="{{$item->path}}" alt="{{$item->title}}"></a>
                <div class="carousel-caption">
                    <h3><a href="{!!$item->link ? $item->link : '#'!!}" arget="_self" title="{{$item->title}}">{{$item->title}}</a></h3>
                    <p>{{$item->presentPrice ? "￥".$item->presentPrice :"￥0.0" }}</p>
                  </div>
              </div>
           @endforeach
        </div>
      </div>
    </div>
    <div class="floor-right">
        <div class="fl3-box clear">
        @foreach($DuoDuoSmallCenterList as $key => $item)
            <div class="small-adv  {!! $key >2 ? 'mtop6' : '' !!} ">
                <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="/img/temp-img.png" data-original="{{$item->path}}" class="lazy"  /></a>
                <h5><a href="{!!$item->link ? $item->link : '#'!!}" target="_self" title="{{$item->title}}">{{$item->title}}</a></h5>
                <p>{{$item->presentPrice ? "￥".$item->presentPrice :"￥0.0" }}</p>
            </div>
        @endforeach
        </div>

        @if(isset($DuoDuoList) && count($DuoDuoList)>0)
            @foreach($DuoDuoList as $key => $item)
               <a class="img-adv" href="{!! $item->link? $item->link : '#' !!}" target="_self"><img src="{{$item->path}}" title="{{$item->title}}" /></a>
            @endforeach
        @else
            <a class="img-adv" href="#" target="_self"><img src="#" title="" /></a>
        @endif
    </div>
    <div class="h16"></div>
      @if($centerList)
        <a href="@if($centerList->link) {{$centerList->link}} @else # @endif " ><img src="/img/temp-img.png" data-original="{{$centerList->path}}" class="lazy" width="1130"  height="227" /></a>
      @endif
    <!-- ************4L************ -->
    <h1 class="floor-4">车友汇<small>Riders club </small></h1>
    <div class="floor-left">
      <!-- 幻灯片 -->
      <div id="carousel-main-fl4" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @if($ridersLeftList)
                @foreach($ridersLeftList as $key =>$item)
                     <li data-target="#carousel-main-fl4" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif"></li>
                @endforeach
           @endif
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
                @foreach($ridersLeftList as $key =>$item)
                    <div class="item {!!$key==0 ? 'active':''  !!}">
                        <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="{{$item->path}}" alt="{{$item->title}}"></a>
                        <div class="carousel-caption">
                            <h3><a href="{!!$item->link ? $item->link : '#'!!}" target="_self" title="{{$item->title}}">{{$item->title}}</a></h3>
                            <p>{{$item->presentPrice ? "￥".$item->presentPrice :"￥0.0" }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
      </div>
    </div>
    <div class="floor-right">
      <div class="fl4-box clear">
          @foreach($ridersSmallRightList as $key => $item)
              <div class="small-adv  {!! $key >2 ? 'mtop6' : '' !!} ">
                  <a href="{!!$item->link ? $item->link : '#'!!}" target="_self"><img src="/img/temp-img.png" data-original="{{$item->path}}" class="lazy" title="{{$item->description}}" /></a>
                  <h5><a href="{!!$item->link ? $item->link : '#'!!}" target="_self" title="{{$item->title}}">{{$item->title}}</a></h5>
                  <p>{{$item->presentPrice ? "￥".$item->presentPrice :"￥0.0" }}</p>
              </div>
          @endforeach
        </div>
        <div class="img-adv" style="height: 396px; width: 352px;">
            <h2>最新团购<small><a href="/ju" target="_self">更多</a></small></h2>
            <a href="@if(isset($ridersNewCenterList['link'])){{$ridersNewCenterList['link']}}@else # @endif" target="_self"><img src="{{$ridersNewCenterList['path']}}" class="h132"></a>
            <ul class="nav nav-tabs mouse-over-tab" role="tablist" >
              <li role="presentation" class="active"><a href="#inspect" aria-controls="inspect" role="tab" data-toggle="tab" >互动调研</a></li>
              <li role="presentation"><a href="#infor" aria-controls="infor" role="tab" data-toggle="tab">行业资讯</a></li>
              <li role="presentation"><a href="#brand" aria-controls="brand" role="tab" data-toggle="tab">品牌社区</a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="inspect">
                  @if(count($question))
                      @foreach($question as $key => $item )
                        <a  href="/innovate/invest-detail/{{$item['qid']}}" target="_self" class=" @if($key == 0) line-ellipsis @endif " >{{$item['title']}}</a>
                      @endforeach
                  @endif
                <div style="text-align:right; padding-right:20px;"><a href="/innovate/invest-list" target="_self" class="more">更多</a></div>
              </div>
              <div role="tabpanel" class="tab-pane" id="infor">
                  @if($info)
                      @foreach($info as $key => $item )
                        <a  href="/infor/detail/{{$item['infoId']}}" target="_self" class=" @if($key == 0) line-ellipsis @endif ">{{$item['infoTitle']}}</a>
                      @endforeach
                  @endif
                <div style="text-align:right; padding-right:20px;"><a href="/infor" target="_self" class="more">更多</a></div>
              </div>
              <div role="tabpanel" class="tab-pane" id="brand">
                  @if(count($innv)>0)
                      @foreach($innv as $key => $item)
                          <a  href="{{$item['url']}}" target="_self" class=" @if($key == 0)  line-ellipsis @endif  ">{{$item['title']}}</a>
                      @endforeach
                  @endif
                  <div style="text-align:right; padding-right:20px;"><a href="/bbs" target="_self" class="more">更多</a></div>
              </div>
            </div>
        </div>
    </div>
    <div class="h16"></div>
      @if(!empty($downList))
        <a href="{!!$downList->link ? $downList->link :'#' !!}" class="mtop16 clear"><img src="{{$downList->path}}" width="1130"  height="227" /></a>
     @endif
  </div>
</div>
@endsection
