@extends('layouts.main')
{{-- 关闭banner --}}
@section('banner')
@endsection
{{-- 资讯首页内容 --}}
@section('content')
<div class="infor-main">
  <div class="container">
      <div class="infor-left">
      <div id="carousel-infor" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @if(isset($carouselList) && count($carouselList)>0)
                @foreach($carouselList as $key => $item)
                     <li data-target="#carousel-infor" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif "></li>
                @endforeach
            @endif
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @if(isset($carouselList) && count($carouselList)>0)
                @foreach($carouselList as $key => $item)
                  <div class="item {{$key == 0 ? 'active':''}} ">
                    <a href="{{$item->link ? $item->link : "#"}}"><img src="@if(empty($item->path) || !file_exists(realpath('./'.ltrim($item->path,'/')))) /img/temp-img.png @else  {{$item->path}} @endif" alt="..."></a>
                    <div class="carousel-caption">
                        <h3><a href="{{$item->link? $item->link :"#"}}" target="_self">{{$item->title}}</a></h3>
                    </div>
                  </div>
                @endforeach
             @endif
        </div>
        <!-- Controls -->
          @if(isset($carouselList) && count($carouselList)>1)
             <a class="left carousel-control" href="#carousel-infor" role="button" data-slide="prev"></a>
             <a class="right carousel-control" href="#carousel-infor" role="button" data-slide="next"></a>
           @endif
      </div>
      <div class="infor-item import">
          <h1>要闻推荐</h1>
          <ul>
              @if(isset($recommend) && count($recommend)>0)
                  @foreach($recommend as $item)
                      <li><a href="/infor/detail/{{$item->infoId}}">{{$item->infoTitle}}</a></li>
                  @endforeach
              @else
                  <li>&nbsp;</li>
              @endif
          </ul>
      </div>
      <div class="infor-item">
          <h1> {{$title4}}<a href="/infor/list/4">更多</a></h1>
          <ul>
              @if(isset($marketInfo) && count($marketInfo)>0)
                      @foreach($marketInfo  as $item)
                    <li><a href="/infor/detail/{{$item->infoId}}">{{$item->infoTitle}}</a></li>
                      @endforeach
                  @else
                      <li>&nbsp;</li>
                  @endif
          </ul>
      </div>
      <div class="infor-item ml40">
          <h1>{{$title2}}<a href="/infor/list/2">更多</a></h1>
          <ul>
              @if( isset($industryObservation) && count($industryObservation)>0)
                      @foreach($industryObservation  as $item)
                    <li><a href="/infor/detail/{{$item->infoId}}">{{$item->infoTitle}}</a></li>
                      @endforeach
              @endif
          </ul>
      </div>
          <!--  /////////////// 中间广告  ////////////////////-->
          @if(isset($centerAdvList)>0 && count($centerAdvList)>0)
              <a class="img-adv" href="{{$centerAdvList->link}}" ><img src='@if(empty($centerAdvList->path) || !file_exists(realpath('./'.ltrim($centerAdvList->path,'/'))) ) /img/temp-img.png @else {{$centerAdvList->path}} @endif '/></a>
          @else
              <a class="img-adv"><img src='/img/temp-img.png'/></a>
          @endif
      <div class="infor-item">
          <h1>{{$title1}}<a href="/infor/list/1">更多</a></h1>
          <ul>
              @if(isset($policyAnnouncement) && count($policyAnnouncement)>0)
                  @foreach($policyAnnouncement  as $item)
                      <li><a href="/infor/detail/{{$item->infoId}}">{{$item->infoTitle}}</a></li>
                  @endforeach
              @else
                  <li>&nbsp;</li>
              @endif
          </ul>
      </div>
      <div class="infor-item ml40">
          <h1>{{$title3}}<a href="/infor/list/3">更多</a></h1>
          <ul>
              @if(isset($carEntertainment) && count($carEntertainment)>0)
                  @foreach($carEntertainment  as $item)
                      <li><a href="/infor/detail/{{$item->infoId}}">{{$item->infoTitle}}</a></li>
                  @endforeach
               @else
                  <li>&nbsp;</li>
              @endif
          </ul>
      </div>
      </div>
      <div class="infor-right">
          <!--  /////////////// 广告位  ////////////////////-->
        <div class="side-bar">
            <h2>经典案例<a href="/innovate/example">更多</a></h2>
            <ul>
                @if(isset($caseUpList) && count($caseUpList)>0)
                    @foreach($caseUpList as $key => $item)
                        <li><a href="{{$item->link ? $item->link : "#"}}"><img src="@if(empty($item->path) && !file_exists(realpath('./'.ltrim($centerAdvList->path,'/')))) /img/temp-img.png @else {{$item->path}} @endif"><p>{{$item->title}}</p></a></li>
                    @endforeach
                @endif
            </ul>
        </div>
          <!--  /////////////// 广告位  ////////////////////-->
        <div class="side-adv">
            @if(isset($leftDownList) && count($leftDownList)>0)
              <a href="{{$leftDownList->link ? $leftDownList->link : "#"}}"><img src="@if(empty($leftDownList->path) || !file_exists(realpath('./'.ltrim($leftDownList->path,'/')))) /img/temp-img.png  @else  {{$leftDownList->path}} @endif"/></a>
           @else
                <a href="#"><img src="/img/temp-img.png"/></a>
           @endif
        </div>
      </div>
  </div>
</div>
@endsection

