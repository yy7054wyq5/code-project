@extends('layouts.main')

@section('header-scripts')
<script type="text/javascript" src="/js/loongjoy.select.js"></script>
@endsection

{{-- 交易首页banner热点 --}}
@section('banner-left')
  <div class="banner-hot">
    <h3>热门车型</h3>
    <div class="hot-cartype">
        @if($car)
        @foreach($car as $value)
        <a data-id="{{ $value->tid }}" title="{{ $value->name }}" role="button">{{ $value->name }}</a>
        @endforeach
        @endif
    </div>
    <h3>热门地区</h3>
    <div class="hot-parts">
        @if($city)
        @foreach($city as $value)
        <a data-id="{{ $value->tid }}" title="{{ $value->name }}" role="button">{{ $value->name }}</a>
        @endforeach
        @endif
    </div>
  </div>
@endsection
{{-- 交易首页幻灯片 --}}
@section('banner-carousel')
<!-- 幻灯片 -->
<div id="carousel-banner" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      @if(isset($advList) && count($advList)>0)
          @foreach($advList as $key => $item)
              <li data-target="#carousel-banner" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif "></li>
          @endforeach
      @endif
  </ol>
    <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
          @if(isset($advList) && count($advList)>0)
              @foreach($advList as $key => $item)
                <div @if($key == 0)  class="item active"  @else class="item" @endif >
                    <a href="{{$item['link'] ? $item['link'] : "#"}}"><img src="{{$item['path']}}" alt="..."></a>
                </div>
                @endforeach
           @else
            <div class="item">
              <a href="#"><img src="img/test/yellow.png" alt="..."></a>
            </div>
           @endif
  </div>
  <!-- Controls -->
    @if(count($advList)>1)
       <a class="left carousel-control" href="#carousel-banner" role="button" data-slide="prev"></a>
       <a class="right carousel-control" href="#carousel-banner" role="button" data-slide="next"></a>
     @endif
</div>
@endsection

{{-- 交易首页内容 --}}
@section('content')
<div class="deal-main">
  <div class="container">
  <h1>配件置换区</h1>
  <!-- Single button -->
  <div class="dropSelect">
  <div class="tab-pane" id="deal">
      <ul class="lem-drop clear nav-bar">
        <li class="dropdown"><a class="btn" data-toggle="dropdown"><img src="/img/pt_ic_lx.png">类型</a>
        <ul class="dropdown-menu" classic="type">
          <li><a data-id="-1">不限</a></li>
          <li><a data-id="1">出售</a></li>
          <li><a data-id="0">求购</a></li>
        </ul></li>
        <input type="hidden" id="typeID" value="-1">
        <li class="dropdown Zindex99999"><a class="btn" data-toggle="dropdown"><img src="/img/ck_ic_pp.png">品牌</a>
            <ul class="dropdown-menu" classic="brand">
                <li class="re hot">
                    <a href="javascript:void(0);" class="sub-dropdown">热门</a>
                    <div class="sub-box">
                        <ul class="brand-tab clear"></ul>
                        <div class="myclear"></div>
                        <div class="brand-content clear">
                        </div>
                    </div>
                </li>
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
          </li>
          <input type="hidden" id="brandID" value="0">
        <li class="dropdown"><a class="btn" data-toggle="dropdown"><img src="/img/sc_ic_cx.png">车型</a>
        <ul class="dropdown-menu" classic="car-type"></ul></li>
        <li class="dropdown" id="j_cityBtn"><a class="btn" data-toggle="dropdown"><img src="/img/pt_ic_dq.png">地区</a>
          <div class="citySelector" data-maxlevel="2">
            <div class="citySelector-close">&times;</div>
            <div class="citySelector-tabs">
              <div class="citySelector-tab active">请选择</div>
            </div>
            <div class="citySelector-cont active">
              <ul class="citySelector-list">
                @foreach($province as $item)
                <li><a href="javascript:;" data-level="1" data-id="{{$item['id']}}">{{$item['name']}}</a></li>
                @endforeach
              </ul>
            </div>
            <div class="citySelector-cont">
              <span class="citySelector-tip">加载中,请稍后...</span>
            </div>
            <div class="citySelector-cont">
              <span class="citySelector-tip">加载中,请稍后...</span>
            </div>
          </div>
        </li>

        <li class="dropdown"><a class="btn" data-toggle="dropdown"><img src="/img/pt_ic_zt.png">状态</a>
        <ul class="dropdown-menu" classic="status" >
          <li><a data-id="-1">不限</a></li>
          <li><a data-id="0">进行中</a></li>
          <li><a data-id="1">已结束</a></li>
        </ul></li>
        
        <li class="deal-search"><input type="text" placeholder="请输入关键字" id="keyword"><i></i></li>
        <li><a class="deal-btn sell" role="button" href="/deal/business" target="_self">出售汽配</a></li>
        <li><a class="deal-btn buy" role="button" href="/deal/business" target="_self">求购汽配</a></li>
        <li>
          <div class="page-action white">
              <a class="page-up" role="button">&lt;</a>
              <span><span class="current">1</span><span>/</span><span class="total">20</span></span>
              <a class="page-down" role="button">&gt;</a>
          </div>
      </li>
      </ul>
  </div>
  </div>

  {{-- 已选中结构 --}}
  <ul class="chosed-box deal clear">
      <li><span class="type"></span><i></i></li>
      <li><span class="brand"></span><i></i></li>
      <li><span class="car-type"></span><i></i></li>
      <li><span class="part"></span><i></i></li>
      <li><span class="status"></span><i></i></li>
  </ul>

  <div class="deal-list clear">
      <div class="list-title clear">
          <span class="deal-info">物品</span>
          <span>单价</span>
          <span>数量</span>
          <span id="brand">品牌</span>
          <span>类型</span>
          <span>公司</span>
          <span>地区</span>
          <span>成色</span>
          <span class="com-date">最后回复</span>
      </div>
      <div class="loading"></div>
      <div class="noContent">没有相关的资源</div>
      <div id="linkBody">
         {{-- ajax请求数据显示区 --}}
      </div>
  </div>
  <div class="deal-list-bottom dropSelect">
      <div class="pull-right clear">
        <p>总共{{ $count }}条记录，按照</p>
        <ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex1"><a class="btn three-words" data-toggle="dropdown"><div class="input-result">发布时间</div><i></i></a>
          <ul class="dropdown-menu" classic="subtype">
                <li><a data-id="1">发布时间</a></li>
                <li><a data-id="0">物品成色</a></li>
          </ul></li>
          
        </ul>
        <p>以</p>
        <ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex1"><a class="btn" data-toggle="dropdown"><div class="input-result">降序</div><i></i></a>
          <ul class="dropdown-menu" classic="rank">
            <li><a data-id="0">降序</a></li>
            <li><a data-id="1">升序</a></li>
          </ul></li>
          
        </ul>
        <p>排列，显示</p>
        <ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex1"><a class="btn six-words" data-toggle="dropdown"><div class="input-result">所有主题</div><i></i></a>
          <ul class="dropdown-menu" classic="time">
            <li><a data-id="0">所有主题</a></li>
            <li><a data-id="1">今天的主题</a></li>
            <li><a data-id="2">3天以内的主题</a></li>
            <li><a data-id="3">7天以内的主题</a></li>
            <li><a data-id="4">30天以内的主题</a></li>
          </ul></li>
          
        </ul>
        <!-- <a class="go-btn" role="button">GO</a> -->
      </div>
      <div class="clear"></div>
      <div class="myclear"></div>
      <div class="page-action white pull-right"></div>
      <div class="myclear"></div>
      
      <input type="hidden" id="totalPage">
  </div>
  </div>
</div>
@endsection
@section('footer-scripts')
@parent
<script>
/**
 * 省市区选择面板
 * @return {[type]} [description]
 */
(function () {
  $('.citySelector')
    //关闭事件
    .on('_close', function () {
      var $wrap = $(this);
      $wrap.removeClass('citySelector-show');
      $wrap.find('.citySelector-tab').eq(0).addClass('active').attr('data-id', '').text('请选择').nextAll().remove();
      $wrap.find('.citySelector-cont').eq(0).addClass('active')
        .nextAll('.citySelector-cont').removeClass('active').html('<span class="citySelector-tip">加载中,请稍后...</span>');
    })
    // 关闭按钮
    .on('click', '.citySelector-close', function () {
      $(this).parents('.citySelector').trigger('_close');
    })
    // tab点击事件
    .on('click', '.citySelector-tab', function () {
      $(this).addClass('active').siblings().removeClass('active');
      $(this).parents('.citySelector').find('.citySelector-cont').removeClass('active')
        .eq($(this).index()).addClass('active');
    })
    .on('click', '.citySelector-list a[data-level="1"]', function () {
      var id = $(this).attr('data-id');
      $('.chosed-box.deal').show();
      $('.chosed-box.deal>li>span.part').text($(this).text()).addClass('spanTag').parent('li').css('visibility','visible');
      handleURL.jump('province',id);
    })
    // 选择地区
    .on('_click', '.citySelector-list a[data-level="1"]', function () {
      var id = $(this).attr('data-id');
      $('#proID').val(id);
      
      //if (!id) return;

      $('.chosed-box.deal').show();
      $('.chosed-box.deal>li>span.part').text($(this).text()).addClass('spanTag').parent('li').css('visibility','visible');

      var $wrap = $(this).parents('.citySelector');
      var $cont = $wrap.find('.citySelector-cont');
      var $tab = $wrap.find('.citySelector-tab.active');
      var maxLevel = +$wrap.attr('data-maxlevel');
      var level = +$(this).attr('data-level');

      $tab.text($(this).text()).attr('title', $(this).text()).attr('data-id', $(this).attr('data-id'));

      if (level >= maxLevel) return;
      $tab.removeClass('active').nextAll().remove();
      $tab.after('<div class="citySelector-tab active">请选择</div>');
      $cont.removeClass('active').eq(level).html('<span class="citySelector-tip">加载中,请稍后...</span>').addClass('active');
      $.post('/user/api/city', {id: id}).success(function (res) {
        var tmp = '';
        window.city = res;
        $.each(res, function () {
          tmp += '<li><a href="javascript:;" title="'+this.name+'" data-level="'+(level+1)+'" data-id="'+this.id+'">'+this.name+'</a></li>';
        });
        $cont.eq(level).html('<ul class="citySelector-list">'+ tmp +'</ul>');
      });

      // handleURL.jump('province',id);
    });


    $('.citySelector-list a[data-id="'+ handleURL.markValue('province') +'"]').trigger('_click');

})();


(function () {
  /**
   * 地区hover显示城市选择
   */
  $('#j_cityBtn').on('mouseenter', function () {
    $(this).find('.citySelector').addClass('citySelector-show');
  });

  $('#j_cityBtn').on('mouseleave', function () {
    $(this).find('.citySelector').removeClass('citySelector-show');
  });
  /**
   * 城市点击事件
   */
  $('#j_cityBtn').on('click', '.citySelector-list a[data-level="2"]', function () {
    var name = $(this).text();
    var partName;
    // alert('id: ' + id + ', name: ' + name);
    //去重
    if($('.citySelector-tab')[0].innerHTML==name){
        partName = name;
    }
    else{
        partName = $('.citySelector-tab')[0].innerHTML + name;
    }
    $('.chosed-box.deal').show();
    $('.chosed-box.deal>li>span.part').text(partName).addClass('spanTag').parent('li').css('visibility','visible');
    $(this).parents('.citySelector').trigger('_close');

    handleURL.jump('city',$(this).attr('data-id'));

  });

})();

</script>
@endsection

