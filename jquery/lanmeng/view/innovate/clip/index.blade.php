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
              @endforeach
          @endif
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
          @if(count($advList)>0)
              @foreach($advList as $key => $item)
                  <div class="item @if($key == 0) active @endif">
                      <a href="{{$item['link']?$item['link']:'#'}}" target="_self"><img src="{{$item['path']}}" alt="..."></a>
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
<div class="innovate-main clip">
<div class="container">
    {{-- ul加上 mouse-over-tab 即可变成鼠标经过 --}}
    <ul class="nav nav-tabs innovate" role="tablist" >
      <li role="presentation"><a href="/innovate" target="_self">创意设计</a></li>
      <li role="presentation" class="active"><a href="/innovate/clip" target="_self">共享素材</a></li>
      <li role="presentation"><a href="/innovate/example" target="_self">执行案例</a></li>
    </ul>
    <div class="myclear"></div>
    <div class="tab-content dropSelect">
      <!-- 官方素材 -->
      <div role="tabpanel" class="tab-pane active" id="clip">
          <ul class="lem-drop clear">
            <li class="dropdown Zindex9999">
              <a class="btn" data-toggle="dropdown"><img src="/img/sc_ic_fl.png">分类</a>
              <ul class="dropdown-menu fenlei" classic="fenlei">
              </ul>
              {{-- 分类 --}}
            </li>
            <li class="dropdown Zindex999">
              <a class="btn" data-toggle="dropdown"><img src="/img/ck_ic_pp.png">品牌</a>
                <!-- 品牌载入DOM结构 -->
                <ul class="dropdown-menu" classic="brand">
                    {{-- 热门品牌 --}}
                    <li class="re hot">
                        <a href="javascript:void(0);" class="sub-dropdown">热门</a>
                        <div class="sub-box">
                            <ul class="brand-tab clear"></ul>
                            <div class="myclear"></div>
                            <div class="brand-content clear">
                            </div>
                        </div>
                    </li>
                    {{-- 其他品牌 --}}
                    <li class="re other">
                        <a href="javascript:void(0);" class="sub-dropdown">其他</a>
                        <div class="sub-box">
                            <ul class="brand-tab clear"></ul>
                            <div class="myclear"></div>
                            <div class="brand-content clear">
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- 品牌载入DOM结构 -->
                {{-- 品牌 --}}
            </li>
            <li class="dropdown">
              <a class="btn" data-toggle="dropdown"><img src="/img/sc_ic_cx.png">车型</a>
              <ul class="dropdown-menu" classic="car-type">
              </ul>
              {{-- 车型 --}}
            </li>
            <li class="input-group"><input type="text" maxlength="11" placeholder="关键字查找" id="searchCon"><a role="button" class="go"></a>{{-- 搜索按钮 --}}</li>
            <li>
              <a class="btn up-clip" href="/innovate/add-clip">上传素材</a>
            </li>
            <li>
              <div class="page-action white">
                  <a class="page-up" role="button">&lt;</a>
                  <span><span class="current">1</span><span class="no">/</span><span class="total">20</span></span>
                  <a class="page-down" role="button">&gt;</a>
              </div>
            </li>
          </ul>
          {{-- 官方素材已选中结构 --}}
          <ul class="chosed-box clip clear">
              <li><span class="fenlei"></span><i></i></li>
              <li><span class="brand"></span><i></i></li>
              <li><span class="car-type"></span><i></i></li>
          </ul>
          <div class="myclear"></div>

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
