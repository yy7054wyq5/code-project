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
        @if(count($carouselList)>0)
          @foreach($carouselList as $key => $item)
            <li data-target="#carousel-banner" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif "></li>
          @endforeach
        @else
          <li data-target="#carousel-banner" data-slide-to="0" class="  active  "></li>
        @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        @if($carouselList)
          @foreach($carouselList as $key => $item )
          <div class="item @if($key == 0) active @endif ">
            <a href="{{$item['link'] ? $item['link'] : '#'}}"><img src="{{$item['path']}}" alt="{{$item['title']}}"></a>
          </div>
          @endforeach
        @else
          <div class="item">
            <a href="#" target="_self"><img src="/img/temp-img.png" alt="..."></a>
          </div>
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
<div class="riders-main">
<div class="container index-main">
  <!-- 1L -->
  <h1 class="floor-1">最新线路<a class="more" role="button" href="/riders-list" target="_self">更多线路</a></h1>
  <div class="floor-left">
    <div class="big-adv">
      <a href="{{$latestLineBig['link']}}" target="_self"><img src="/img/temp-img.png" data-original="{{$latestLineBig['path']}}" class="lazy" title="{{$latestLineBig['title']}}" /></a>
      <div class="word-bg">
        <h3><a href="/riders/detail" target="_self" title="{{$latestLineBig['title']}}">{{$latestLineBig['title']}}</a></h3>
        <p><span>￥</span>{{$latestLineBig['presentPrice']}}</p>
      </div>
    </div>
  </div>
  <div class="floor-center">
    @if(count($latestLineSmall)>0)
      @foreach($latestLineSmall as $key => $item)
      <div class="small-adv">
      <div class="shadow">
         <a href="{{$item['link'] ? $item['link'] : "#"}}" target="_self"><img src="/img/temp-img.png" data-original="{{$item['path']}}" class="lazy" title="{{$item['title']}}" /></a>
         <h5><a href="{{$item['link'] ? $item['link'] : "#"}}" target="_self" title="{{$item['title']}}">{{$item['title']}}</a></h5>
         <p><span>￥</span>{{$item['presentPrice']}}</p>
       </div>
      </div>
      @endforeach
    @endif
  </div>
  <div class="floor-right">
    <!-- 幻灯片细线 -->
    <div id="carousel-riders-fl1" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @if(count($carouselLatestLineList)>0)
          @foreach($carouselLatestLineList as $key => $item)
                <li data-target="#carousel-riders-fl1" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif"></li>
          @endforeach
        @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        @if(count($carouselLatestLineList)>0)
          @foreach($carouselLatestLineList as $key => $item)
        <div class=" {!! $key == 0 ?'active ':''  !!} item">
          <a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self"><img src="{{$item['path']}}" alt="{{$item['title']}}"></a>
        </div>
          @endforeach
        @endif
      </div>
    </div>
    <!-- 幻灯片细线 -->
  </div>
  <!-- 2L -->
  <h1 class="floor-2">主题游<a class="more" role="button" href="/riders-list" target="_self">更多线路</a></h1>
  <div class="floor-left">
      @if($subjectBig)
        <div class="big-adv">
          <a href="{{$subjectBig['link'] ? $subjectBig['link'] : "#"}}" target="_self"><img src="/img/temp-img.png" data-original="{{$subjectBig['path']}}" class="lazy" title="{{$subjectBig['title']}}" /></a>
          <div class="word-bg">
            <h3><a href="{{$subjectBig['link'] ? $subjectBig['link'] : "#"}}" target="_self" title="{{$subjectBig['title']}}">{{$subjectBig['title']}}</a></h3>
            <p><span>￥</span>{{$subjectBig['presentPrice']}}</p>
          </div>
        </div>
      @endif
  </div>
  <div class="floor-center">
    @if(count($subjectSmall)>0)
      @foreach($subjectSmall as $key => $item)
      <div class="small-adv">
        <div class="shadow">
          <a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self"><img src="/img/temp-img.png" data-original="{{$item['path']}}" class="lazy" title="{{$item['title']}}}" /></a>
          <h5><a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self" title="{{$item['title']}}">{{$item['title']}}</a></h5>
          <p><span>￥</span>{{$item['presentPrice']}}</p>
        </div>
      </div>
      @endforeach
      @else
     @for ($i = 0; $i < 4; $i++)
    <div class="small-adv">
    <div class="shadow">
     <a href="#" target="_self"><img src="/img/temp-img.png" data-original="" class="lazy" title="我是冒泡2啊" /></a>
     <h5><a href="#" target="_self" title="我是冒泡2啊">单兵作战展具 火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中</a></h5>
     <p><span>￥</span>2580.00</p>
    </div>
    </div>
    @endfor
      @endif
  </div>
  <div class="floor-right">
    <!-- 幻灯片细线 -->
    <div id="carousel-riders-fl2" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @if(count($carouseSubjectlList)>0)
          @foreach($carouseSubjectlList as $key => $item)
            <li data-target="#carousel-riders-fl2" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif "></li>
          @endforeach
          @else
          <li data-target="#carousel-riders-fl2" data-slide-to="0" class="active"></li>
        @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        @if(count($carouseSubjectlList)>0)
          @foreach($carouseSubjectlList as $key => $item)
            <div class=" {!! $key == 0 ?'active ':''  !!} item">
              <a href="{{$item['link'] ? $item['link'] : "#"}}" target="_self"><img src="{{$item['path']}}" alt="{{$item['title']}}"></a>
            </div>
          @endforeach
        @else
          <div class="item active ">
            <a href="#" target="_self"><img src="/img/temp-img.png" alt="..."></a>
          </div>
        @endif
      </div>
    </div>
    <!-- 幻灯片细线 -->
  </div>
  <!-- 3L -->
  <h1 class="floor-3">说走就走<a class="more" role="button" href="/riders-list" target="_self">更多线路</a></h1>
  <div class="floor-left">
    @if(!$sayGoBig)
      <div class="big-adv">
        <a href="#" target="_self"><img  src="/img/temp-img.png" title="我是冒泡2啊" /></a>
        <div class="word-bg">
          <h3><a href="#" target="_self" title="大手牵小手一起探索'汽车的诞生'汽车主题亲子1日游卡卡大家快来打电话啦活动拉开回答回答了快哭了等哈看了很多啦">大手牵小手一起探索"汽车的诞生"  汽车主题亲子1日游卡卡大家快来打电话啦活动拉开回答回答了快哭了等哈看了很多啦</a></h3>
          <p><span>￥</span>508.00</p>
        </div>
      </div>
    @else
      @if($sayGoBig)
        <div class="big-adv">
          <a href="{{$sayGoBig['link'] ? $sayGoBig['link'] :"#"}}" target="_self"><img src="/img/temp-img.png" data-original="{{$sayGoBig['path']}}" title="{{$sayGoBig['title']}}" class="lazy" /></a>
          <div class="word-bg">
            <h3><a href="{{$sayGoBig['link'] ? $sayGoBig['link'] :"#"}}" target="_self" title="{{$sayGoBig['title']}}">{{$sayGoBig['title']}}</a></h3>
            <p><span>￥</span>{{$sayGoBig['presentPrice']}}</p>
          </div>
        </div>
      @endif
    @endif
  </div>
  <div class="floor-center">
    @if(count($sayGoSmall)>0)
      @foreach($sayGoSmall as $key => $item)
        <div class="small-adv">
          <div class="shadow">
            <a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self"><img src="/img/temp-img.png" data-original="{{$item['path']}}" class="lazy" title="{{$item['title']}}}" /></a>
            <h5><a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self" title="{{$item['title']}}">{{$item['title']}}</a></h5>
            <p><span>￥</span>{{$item['presentPrice']}}</p>
          </div>
        </div>
      @endforeach
    @else
      @for ($i = 0; $i < 4; $i++)
        <div class="small-adv">
          <div class="shadow">
            <a href="#" target="_self"><img src="/img/temp-img.png" data-original="" class="lazy" title="我是冒泡2啊" /></a>
            <h5><a href="#" target="_self" title="我是冒泡2啊">单兵作战展具 火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中火热发售中</a></h5>
            <p><span>￥</span>2580.00</p>
          </div>
        </div>
      @endfor
    @endif
  </div>
  <div class="floor-right">
    <!-- 幻灯片细线 -->
    <div id="carousel-riders-fl3" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @if(count($carouseSayGolList)>0)
          @foreach($carouseSayGolList as $key => $item)
            <li data-target="#carousel-riders-fl2" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif "></li>
          @endforeach
        @else
          <li data-target="#carousel-riders-fl2" data-slide-to="0" class="active"></li>
        @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        @if(count($carouseSayGolList)>0)
          @foreach($carouseSayGolList as $key => $item)
            <div class=" {!! $key == 0 ?'active ':''  !!}  item   ">
              <a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self"><img src="{{$item['path']}}" alt="{{$item['title']}}"></a>
            </div>
          @endforeach
        @else
          <div class="item active ">
            <a href="#" target="_self"><img src="/img/temp-img.png" alt="..."></a>
          </div>
        @endif
      </div>
    </div>
    <!-- 幻灯片细线 -->
  </div>
  <!-- 4L -->
  <h1 class="floor-4">车友产品<a class="more" role="button" href="/store/list?categoryId=92">更多产品</a></h1>
  <div class="riders-floor">
    <div class="floor-left">
      @if(count($ridersSmall)>0)
        @foreach($ridersSmall as $key => $item)
            @if(!empty($item))
          <div class="small-adv">
            <a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self"><img src="/img/temp-img.png" data-original="{{$item['path']}}" class="lazy" title="/image/get/{{$item['title']}}" /></a>
            <h5><a href="{{$item['link'] ? $item['link'] :"#" }}" target="_self" title="{{$item['title']}}">{{$item['title']}}</a></h5>
            <p><span>￥</span>{{$item['presentPrice']}}</p>
          </div>
            @endif
        @endforeach
        @endif
    </div>
    <div class="floor-right">
    <!-- 幻灯片细线 -->
    <div id="carousel-riders-fl4" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @if(count($carouseRidersList)>0)
              @foreach($carouseRidersList as $key => $item)
                  @if(!empty($item))
                     <li data-target="#carousel-riders-fl4" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif "></li>
                  @endif
                 @endforeach
        @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        @if(count($carouseRidersList)>0)
          @foreach($carouseRidersList as $key => $item)
        <div class="item {!! $key == 0 ? ' active':'' !!} ">
          <a href="{{$item['link'] ? $item['link'] :"#"}}" target="_self"><img src="{{$item['path']}}" alt="{{$item['title']}}"></a>
        </div>
          @endforeach
       @else
        <div class="item active ">
          <a href="#" target="_self"><img src="/img/temp-img.png" alt="..."></a>
        </div>
       @endif
      </div>
    </div>
    <!-- 幻灯片细线 -->
    </div>
  </div>
</div>
</div>
<!-- 车友汇底部 -->
<div class="riders-bottom">
  <ul class="container">
    <li class="bottom1">
      <i class="icon1"></i>
      <h2>值得信赖</h2>
      <p>100%如实描述</p>
    </li>
    <li class="bottom2">
      <i class="icon2"></i>
      <h2>特色服务</h2>
      <p>让您的旅途更加舒适</p>
    </li>
    <li class="bottom3">
      <i class="icon3"></i>
      <h2>实力保障</h2>
      <p>品牌的力量</p>
    </li>
    <li class="no-line bottom4">
      <i class="icon4"></i>
      <h2>更加实惠</h2>
      <p>更大选择的空间，更优的价格</p>
    </li>
  </ul>
  </div>
</div>
@endsection

