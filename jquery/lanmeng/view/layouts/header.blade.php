<div class="header">
  <!-- fixed top -->
  <div class="fixed">
    <div class="container">
        <div class="pull-left collect"><img src="/img/collect.png"><a role="button">收藏本站</a></div>
        <ul class="header-top">
         @if(is_null($user))
         <li class="front-out"><a href="/login?reurl=http://<?php echo $_SERVER['HTTP_HOST']; ?>/" class="red-font">亲，请登录</a></li>
         <li class="front-out"><a href="/reg">注册</a></li>
         <li class="front-in cookiename"><a href="javascript:;"></a></li>
         <li class="front-in" role="button"><a onclick="loginOut()">退出</a></li>
         @else
         <li><a href="javascript:;" class="username">{{ Session::get('user.username') }}</a></li>
         <li><a onclick="loginOut()" role="button">退出</a></li>
         @endif
         <li><a href="/mine">我的蓝网</a></li>
         <li><a href="/mine/order/11">我的订单</a></li>
         <li><a href="/cart">我的购物车(<b id="car_num">{{ isset($cartsnum) ? $cartsnum : 0 }}</b>)</a></li>
        </ul>
     </div>
     <div class="line clear"></div>
    </div>
    <!-- logo AND search -->
   <div class="container">
       <div class="header-center clear">
          <a class="logo" href="/" target="_top"><img src="/img/lemauto.png"></a>
          @section('header-search')
              {{-- ********************************搜索框******************************** --}}
              <div class="header-search">
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="@if($searchurl == '/store/list') active @endif"><a href="#good" aria-controls="good" role="tab" data-toggle="tab" >商品</a></li>
                  <li role="presentation" class="@if($searchurl == '/innovate/example-list') active @endif"><a href="#case" aria-controls="case" role="tab" data-toggle="tab">案例</a></li>
                  @if(Session::get('bbs_auth') === 0)
                  <li role="presentation"><a href="#community" aria-controls="community" role="tab" data-toggle="tab">社区</a></li>
                  @endif
                  <li role="presentation" class="@if($searchurl == '/infor/list') active @endif"><a href="#message" aria-controls="message" role="tab" data-toggle="tab">资讯</a></li>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane @if($searchurl == '/store/list') active @endif" id="good">
                          <div class="input-group">
                            <i></i>
                            <input type="text" class="form-control" value="{{ Input::get('keyword') }}" placeholder="商品">
                            <span class="input-group-btn">
                              <div class="btn btn-default" type="button">搜索</div>
                            </span>
                          </div>
                  </div>
                  <div role="tabpanel" class="tab-pane @if($searchurl == '/innovate/example-list') active @endif" id="case">
                          <div class="input-group">
                            <input type="text" name="keyword" value="{{ Input::get('keyword') }}" class="form-control" placeholder="案例">
                            <span class="input-group-btn">
                              <div class="btn btn-default" type="button">搜索</div>
                            </span>
                          </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="community">
                        <div class="input-group">
                          <input type="text" class="form-control" id="discuz" placeholder="社区">
                          <span class="input-group-btn">
                            <div class="btn btn-default" type="button" onclick="bbsSearch(document.getElementById('discuz').value);">搜索</div>
                          </span>
                        </div>
                  </div>
                  <div role="tabpanel" class="tab-pane @if($searchurl == '/infor/list') active @endif" id="message">
                        <div class="input-group">
                          <input type="text" name="keyword" value="{{ Input::get('keyword') }}" class="form-control" placeholder="资讯">
                          <span class="input-group-btn">
                            <div class="btn btn-default" type="button" >搜索</div>
                          </span>
                        </div>
                  </div>
                </div>
              </div>
              @show
      </div>
  </div>
  <!-- menu -->
  @section('menu')
    <div class="header-bottom clear">
          <div class="container">
            <ul class="nav nav-pills">
              <li role="presentation dropdown" class="dropdown" id='homedrop'><a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >全部商品分类</a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        @foreach($commondityCategoryLists  as $key => $item)
                        <li>
                          <a  href="/store/list?categoryId={{ $item['id'] }}" target="_self">{{ $item['name'] }}<span></span></a>
                          <div class="sub-menu">
                            <div class="loading"><img src="/img/loading.gif"></div>
                            <div class="sub-menu-line clear"></div>
                            <a class="hotImg" href="@if(!empty($item['sub']['link'])){{$item['sub']['link']}} @else # @endif "><img src="@if(!isset($item['sub']['path']) || !file_exists(realpath('./'.$item['sub']['path']))) /img/temp-img.png  @else {{$item['sub']['path']}} @endif " alt="{{$item['sub']['title']}}"></a>
                          </div>
                        </li>
                        @endforeach
                    </ul>
              </li>
              <li role="presentation"><a href="/" id="menu1">首页</a></li>
              <li role="presentation"><a href="/store" id="menu2">商城</a></li>
              <li role="presentation"><a href="/innovate" id="menu3">创库</a></li>
              <li role="presentation"><a href="/riders" id="menu4">车友汇</a></li>
              <li role="presentation"><a href="/ju" id="menu5">聚惠</a></li>
              <li role="presentation"><a href="/infor" id="menu6">资讯</a></li>
              <li role="presentation"><a href="/deal" id="menu7">交易平台</a></li>
              @if(Session::get('bbs_auth') === 0)
              <li role="presentation"><a href="/bbs" id="menu8">社区</a></li>
              @endif
          </ul>
        </div>
  </div>
@show

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
        <li data-target="#carousel-banner" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-banner" data-slide-to="1"></li>
        <li data-target="#carousel-banner" data-slide-to="2"></li>
        <li data-target="#carousel-banner" data-slide-to="3"></li>
        <li data-target="#carousel-banner" data-slide-to="4"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <a href=""><img src="/img/test/gray.png" alt="..."></a>
        </div>
        <div class="item">
          <a href=""><img src="/img/test/black.png" alt="..."></a>
        </div>
        <div class="item">
          <a href=""><img src="/img/test/gray.png" alt="..."></a>
        </div>
         <div class="item">
          <a href=""><img src="/img/test/black.png" alt="..."></a>
        </div>
         <div class="item">
          <a href=""><img src="/img/test/gray.png" alt="..."></a>
        </div>
      </div>
      <!-- Controls -->
        <a class="left carousel-control" href="#carousel-banner" role="button" data-slide="prev"></a>
        <a class="right carousel-control" href="#carousel-banner" role="button" data-slide="next"></a>
    </div>
    @show
    </div>
    </div>
  </div>
  @show
  </div>
{!!HTML::script('common/discuzsearch.js') !!}
