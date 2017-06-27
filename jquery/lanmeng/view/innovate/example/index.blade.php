@extends('layouts.main')

@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="/js/blocksit.min.js"></script>
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
          @if(count($advList)>0)
              @foreach($advList as $key => $item)
                  <li data-target="#carousel-banner" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif "></li>
              @endforeach
          @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
          @if(count($advList)>0)
              @foreach($advList as $key => $item)
                  <div class="item @if($key == 0) active @endif">
                      <a href="{{$item['link']?$item['link']:'#'}}"  target="_self"><img src="/image/get/{{$item['imageId']}}" alt="..."></a>
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
<div class="innovate-main example">
<div class="container">
    {{-- ul加上 mouse-over-tab 即可变成鼠标经过 --}}
    <ul class="nav nav-tabs innovate" role="tablist" >
      <li role="presentation"><a href="/innovate" target="_self">创意设计</a></li>
      <li role="presentation"><a href="/innovate/clip" target="_self">共享素材</a></li>
      <li role="presentation" class="active"><a href="/innovate/example" target="_self">执行案例</a></li>
    </ul>
    <div class="myclear"></div>
    <div class="tab-content dropSelect">
      <!-- 执行案例 -->
      <div role="tabpanel" class="tab-pane active" id="example">
        <div class="page-left">
            <ul class="nav nav-tabs mouse-over-tab example" role="tablist" >
              <li role="presentation" class="active"><a href="#top-ex1" aria-controls="new-example" role="tab" data-toggle="tab" data-id="1">最新案例</a></li>
              <li role="presentation"><a href="#top-ex2" aria-controls="hot-example" role="tab" data-toggle="tab" data-id="2">热门案例</a></li>
              <li class="last input-group">
                  <input type="text" class="form-control" placeholder="输入案例名称">
                  <span class="input-group-btn">
                    <div class="btn btn-default" type="button">搜索</div>
                  </span>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="top-ex1"></div>
              <div role="tabpanel" class="tab-pane" id="top-ex2"></div>
            </div>
            @if(count($advCenterList)>0)
               <a class="img-adv" href="{{$advCenterList['link']}}" role="button"><img src="/image/get/{{$advCenterList['imageId']}}"></a>
            @else
              <a class="img-adv" href="#" role="button"><img src="#"></a>
            @endif
            <div  class="clear-box"></div><!-- 清浮动用-->
            <ul class="nav nav-tabs mouse-over-tab more-example" role="tablist" >
                @if(count($exampleType)>0)
                    @foreach($exampleType as $key => $item)
                       <li role="presentation" class=" @if($key == 1) active @endif "><a href="#ex{{$key}}" data-id="{{$key}}" aria-controls="ex{{$key}}" role="tab" data-toggle="tab">{{$item}}</a></li>
                    @endforeach
                @endif
              <li class="last"><a class="notab" role="button" href="/innovate/example-list">更多</a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="ex1"></div>
              <div role="tabpanel" class="tab-pane" id="ex2"></div>
              <div role="tabpanel" class="tab-pane" id="ex3"></div>
              <div role="tabpanel" class="tab-pane" id="ex4"></div>
              <div role="tabpanel" class="tab-pane" id="ex5"></div>
              <div role="tabpanel" class="tab-pane" id="ex6"></div>
              <div role="tabpanel" class="tab-pane" id="ex7"></div>
            </div>
        </div>
        <div class="page-right">
            <a class="btn up-example" href="/innovate/add-example" target="_self">上传案例</a>
            <a class="btn manage-example" href="/mine/case" target="_self">管理案例</a>
            <div class="myclear"></div>
            <div class="side-bar-innovate">
                <div>最新上传</div>
                <ul>
                    {{-- 只有第一个LI才有图片后面的都没有 --}}
                    @if(count($newUpload)>0)
                        @foreach($newUpload as $key => $item)
                            @if($key == 0)
                               <li class="first clear"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self" title="{{$item['caseName']}}"><img src="/image/get/{{$item['coverId']}}"/><span>{{$item['caseName']}}</span></a></li>
                            @elseif(count($newUpload) == $key+1)
                                <li class="last"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self" title="{{$item['caseName']}}"><span>{{$item['caseName']}}</span></a></li>
                            @else
                                <li><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self" title="{{$item['caseName']}}"><span>{{$item['caseName']}}</span></a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <div>更多下载</div>
                <ul>
                    {{-- 只有第一个LI才有图片后面的都没有 --}}
                    @if(count($moreDownload)>0)
                        @foreach($moreDownload as $key => $item)
                            @if($key == 0)
                                <li class="first clear"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self" title="{{$item['caseName']}}"><img src="/image/get/{{$item['coverId']}}"/><span>{{$item['caseName']}}</span></a></li>
                            @elseif(count($moreDownload) == $key+1)
                                <li class="last"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self" title="{{$item['caseName']}}"><span>{{$item['caseName']}}</span></a></li>
                            @else
                                <li><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self" title="{{$item['caseName']}}"><span>{{$item['caseName']}}</span></a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <div class="survey">互动调研<a class="more" href="/innovate/invest-list" target="_self">更多</a></div>
                <ul class="survey-box">
                    @if(count($rightQuestionList)>0)
                        @foreach($rightQuestionList as $item)
                            <li><a href="/innovate/invest-detail/22" target="_self" title="{{$item['title']}}"><span>{{$item['title']}}</span></a></li>
                            @endforeach
                        @endif
                </ul>
            </div>
        </div>
      </div>
    </div>
</div>
</div>
@endsection
