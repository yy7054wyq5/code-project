@extends('layouts.main')
@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="/js/blocksit.min.js"></script>
<script type="text/javascript" src="/js/loongjoy.select.js"></script>
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
                  {{-- data-slide-to的值得跟着赋值，不能都为0，参考如上 --}}
              @endforeach
          @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
          @if(count($advList)>0)
              @foreach($advList as $key => $item)
                  <div class="item @if($key == 0) active @endif">
                      <a href="{{$item['link']?$item['link'] : '#'}}"  target="_self"><img src="{{$item['path']}}" alt="..."></a>
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
<div class="innovate-main creative">
<div class="container">
    {{-- ul加上 mouse-over-tab 即可变成鼠标经过 --}}
    <ul class="nav nav-tabs innovate" role="tablist" >
      <li role="presentation" class="active"><a href="/innovate/creative" target="_self">创意设计</a></li>
      <li role="presentation"><a href="/innovate/clip" target="_self">共享素材</a></li>
      <li role="presentation"><a href="/innovate/example" target="_self">执行案例</a></li>
    </ul>
    <div class="myclear"></div>
    <div class="tab-content dropSelect">
      <!-- 创意设计 -->
      <div role="tabpanel" class="tab-pane active" id="design">

      <ul class="lem-drop clear">
        <li class="dropdown Zindex99999">
          <a class="btn" data-toggle="dropdown"><img src="/img/ck_ic_pp.png">品牌</a>
          {{-- 品牌 --}}
          <ul class="dropdown-menu brand">
              {{-- 热门品牌 --}}
              <li class="re hot">
                  <a href="javascript:void(0);" class="sub-dropdown">热门</a>
                  <div class="sub-box">
                      <ul class="brand-tab clear">
                      </ul>
                      <div class="myclear"></div>
                      <div class="brand-content clear">
                      </div>
                  </div>
              </li>
              {{-- 其他品牌 --}}
              <li class="re other">
                  <a href="javascript:void(0);" class="sub-dropdown">其他</a>
                  <div class="sub-box">
                      <ul class="brand-tab clear">
                      </ul>
                      <div class="myclear"></div>
                      <div class="brand-content clear">
                      </div>
                  </div>
              </li>
          </ul>
        </li>
        <li class="dropdown Zindex9999">
          <a class="btn" data-toggle="dropdown"><img src="/img/ck_ic_zt.png">主题</a>
          <ul class="dropdown-menu theme" classic="theme"></ul>
        </li>
        {{-- 主题 --}}
        <li class="dropdown Zindex999">
          <a class="btn" data-toggle="dropdown"><img src="/img/ck_ic_jf.png">积分</a>
          <ul class="dropdown-menu" classic="point">
              @if(isset($integrals) && count($integrals)>0)
                  @foreach($integrals as $key => $item)
                      <li><a href="javascript:void(0)" data-id="{{$key}}">{{$item}}</a></li>
                  @endforeach
              @endif
          </ul>
        </li>
        {{-- 积分 --}}
        <li class="dropdown Zindex99">
          <a class="btn" data-toggle="dropdown"><img src="/img/ck_ic_px.png">排序</a>
          <ul class="dropdown-menu" classic="rank">
              @if(isset($sort) && count($sort)>0)
                  @foreach($sort as $key => $item)
                      <li><a href="javascript:void(0);" data-id="{{$key}}" >{{$item}}</a></li>
                  @endforeach
              @endif
          </ul>
        </li> 
        {{-- 排序 --}}
        <li class="dropdown Zindex9">
          <a class="btn" data-toggle="dropdown"><img src="/img/ck_ic_ss.png">时间</a>
          <ul class="dropdown-menu" classic="time">
              @if(isset($time) && count($time)>0)
                  @foreach($time as $key => $item)
                      <li><a href="javascript:void(0);" data-id="{{$key}}" >{{$item}}</a></li>
                  @endforeach
              @endif
          </ul>
        </li>
        {{-- 时间 --}}
        <li class="input-group">
            <input type="text" maxlength="11" id="searchCon"><a role="button" class="go"></a>{{-- 搜索按钮 --}}
        </li>
        <li>
          <div class="page-action white">
              <a class="page-up" role="button">&lt;</a>
              <span><span class="current">1</span><span class="no">/</span><span class="total">20</span></span>
              <a class="page-down" role="button">&gt;</a>
          </div>
        </li>
      </ul>
      {{-- 创意设计已选中结构 --}}
      <ul class="chosed-box design clear">
          <li><span class="brand"></span><i></i></li>
          <li><span class="theme"></span><i></i></li>
          <li><span class="point"></span><i></i></li>
          <li><span class="rank"></span><i></i></li>
          <li><span class="time"></span><i></i></li>
      </ul>

      <div class="myclear"></div>
      <!--瀑布流-->
      <div id="pinterest"></div>
      <div class="myclear"></div>
      <div class="loading"></div>
      <div class="noContent">没有找到相关的资源</div>
      <div class="page-action white clear"></div>
      {{-- 当前页码 --}}
      <input type="hidden" id="totalPage">
      {{-- 总页码 --}}
      </div>
    </div>
</div>
</div>
@endsection
