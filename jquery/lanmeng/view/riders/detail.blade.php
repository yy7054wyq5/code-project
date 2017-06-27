@extends('layouts.main')

@section('banner')
@endsection

@section('header-scripts')
<script type="text/javascript" src="/js/myfocus/myfocus-2.0.4.min.js"></script>
<script type="text/javascript" src="/js/jquery.jqzoom.js"></script>
<script type="text/javascript" src="/js/loongjoy.detail.js"></script>
<script type="text/javascript">
  //github：https://github.com/koen301/myfocus
  //幻灯片效果
  myFocus.set({
      id:'slide-box',//焦点图盒子ID
      auto: false,//不自动播放
      pattern:'mF_fscreen_tb',//风格应用的名称
      time:3,//切换时间间隔(秒)
      trigger:'click',//触发切换模式:'click'(点击)/'mouseover'(悬停)
      width:492,//设置图片区域宽度(像素)
      height:454,//设置图片区域高度(像素)
      txtHeight:0,//文字层高度设置(像素),'default'为默认高度，0为隐藏
      loadIMGTimeout:0//图片延迟载入的时间
  });
</script>
{!!HTML::script('common/follow.js') !!}
@endsection

@section('content')
<div class="riders-detail">
<div class="container detail-main">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/riders" target="_self" class="red-font">车友汇</a></li>
    <li class="arrow"></li>
    <li>车友俱乐部</li>
    <li class="arrow"></li>
    <li>{{ $info['name'] }}</li>
  </ol>
  <div class="detail-header clear">
  <div style="float: left;width: 492px; height: 454px;">
    <div id="slide-box"><!--焦点图盒子-->
      <div class="pic"><!--内容列表(li数目可随意增减)-->
        <ul>
            {{-- 此处有放大镜效果：jqimg为大图路径，img的src为小图路径，img内的属性未用的不能去掉 --}}
            @if(isset($image[0]))
            @foreach($image as $value)
            <li><div class="jqzoom"><img src="{{ $value }}" thumb="" alt="" text="" jqimg="{{ $value }}"/></div></li>
            @endforeach
            @endif
        </ul>
      </div>
    </div>
    </div>
    {{-- 创意设计详情窗 --}}
    <div class="detail-box">
    <form>
        <h1>{{ $info['commodityName'] }}</h1>
        <span class="small-title red-font">{{ $info['commodityTitle'] }}</span>
        <p class="s-time"><span><!-- 上海出发<span style="margin-left:5px;margin-right:5px;">|</span>大巴往返 -->{{ $info['strokeMode'] }}</span><span style="margin-left:20px;">行程天数：{{ $info['travelDays'] }}天</span></p>
        <ul class="status-bar clear">
            <li class="price">
                <p>商品原价：<span class="delete-font">￥@if(isset($specs[0]['sourcePrice']) && !empty($specs[0]['sourcePrice'])){{ $specs[0]['sourcePrice'] }}@else 0 @endif </span><span style="margin-left:30px;">赠送积分：<span class="giftPoint" data-score="{{ $info['integral'] }}" > @if(isset($info['integral']) && !empty($info['integral']) ) {{ $info['integral'] }} @else 0 @endif </span>积分</span></p>
                <p>促销价格：<span class="red-font-bold" id="cost">￥@if(isset($specs[0]['price']) && !empty($specs[0]['price'] )){{ $specs[0]['price'] }}@else 0 @endif</span><span class="ls2w">&nbsp;</span><span style="color:#999999;">积分可抵<span class="toMoney">@if(isset($specs[0]['maxCredits'] ) && !empty($specs[0]['maxCredits'] )){{ $specs[0]['maxCredits'] / 50 }} @else 0 @endif </span></span></p>
                <p class="go-time">出发日期：</p>
                <ul class="lem-drop lem-drop-input" style="top:65px;">
                  <li class="dropdown" style="z-index:12;"><a class="btn" data-toggle="dropdown"><div id="goTime" class="input-result"> @if(isset($departureDate) && count($departureDate)>0) {{$departureDate[0]}} @else 暂无 @endif</div><i></i></a>
                  <ul class="dropdown-menu">
                      @if(isset($departureDate) && count($departureDate)>0)
                        @foreach($departureDate as $key => $item)
                          <li><a>{{$item}}</a></li>
                        @endforeach
                      @endif
                  </ul></li>
                </ul>
                {{-- <span class="go-date">{{  $info['departureDate'] }}</span>--}}
            </li>
            <li class="sell">已卖出<span class="red-font big">{{ $salenum }}</span>件
            </li>
            <li class="line"></li>
            <li class="conmment">累计评价<span class="blue-font-detail big">{{ $commentcount }}</span></li>
        </ul>
        <input type="hidden" id="defaultCost">
        {{-- 用来存当前规格单价的 --}}
        <div class="myclear"></div>
        <div class="size-box clear">
          <span class="rice"><span class="ls2w">套</span>餐：</span>
          <div><!-- 阻隔默认样式 -->
          <ul class="lem-drop lem-drop-input">
            <li class="dropdown" style="z-index:0;"><a class="btn" data-toggle="dropdown"><div data-spec="{{ isset($specs[0]) ? $specs[0]['specId'] : '---' }}" id="specs" class="input-result">{{ isset($specs[0]) ? $specs[0]['specValue'] : 0 }}</div><i></i></a>
            <ul class="dropdown-menu">
            @if(isset($specs))
            @foreach($specs as $value)
            <li><a sizecost="{{ $value['price'] }}" data-spec="{{ $value['specId'] }}" oldcost="{{ $value['sourcePrice'] }}" max-score="{{ $value['maxCredits'] }}">{{ $value['specValue'] }}</a></li>
            @endforeach
            @endif
            </ul></li>
          </ul>
          </div>
        </div>
        <div class="myclear"></div>
        <div class="buy-box">
            <a class="detail-btn buy" onclick="gobuy({{ $info['id'] }})">立刻预订</a>
            <a class="detail-btn addshop" onclick="addshop({{ $info['id'] }})">加入购物车</a>
        </div>
        <div class="clear-box"></div>
        </form>
    </div>
    <div class="PM-recon">
        <div class="img-shade"></div>
        <img src="/img/pm.jpg" /><!-- 产品经理的头像或者图片 -->
        <div class="PM-speak">
            <h3>产品经理推荐</h3>
            <?php echo $info['productManager']; ?>
        </div>
        <a class="btn down"></a>
    </div>
    <div class="plus-box clear">
        <span>商品编号：{{ $info['code'] }}</span>
        <a class="att @if($follow > 0) active @endif" role="button">关注商品</a>
        <div class="share clear"><span>分享</span>{!!HTML::script('common/bshare.js') !!}</div>
    </div>
    <div class="clear-box"></div>
  </div>
  <div class="myclear"></div>
  {{-- 延展套餐HTML结构 --}}
  <div class="extension-box">
      <div class="tit">延展套餐选择</div>
      <div class="con">
          <div id="slide-box2"><!--焦点图盒子-->
            <div class="pic"><!--内容列表(li数目可随意增减)-->
              <ul class="clear">
                  {{-- 单个产品 --}}
                  @if(isset($packageDetails) && count($packageDetails)>0)
                      <?php $loop = count($packageDetails) >= 4 ? 4 : count($packageDetails) ?>
                      @for($i=0; $i<$loop; $i++)
                          <li>
                              <a href="/riders/detail/{{$packageDetails[$i]['id']}}" target="_blank"><img src="{{$packageDetails[$i]['imageurl']}}" thumb="" alt="" text=""/></a>
                              <div class="txt-box">
                                  <span class="txt"><a href="/riders/detail/{{$packageDetails[$i]['id']}}" target="_blank">{{$packageDetails[$i]['name']}}</a></span>

                                  <div class="check" data-cart="{{$packageDetails[$i]['pCart']}}"></div>
                                  <span class="num">￥{{$packageDetails[$i]['price']}}</span>
                              </div>
                              <div class="myclear"></div>
                          </li>
                      @endfor
                  @endif
              </ul>
              <div class="myclear"></div>
            </div>
            <div class="go-buy">
                  <p class="txt">套餐价</p>
                  <p class="total">=<span class="red-font" id="totalPoint"></span><span class="jf">积分</span><span class="plus">+</span><span class="red-font money">￥</span><span class="red-font" id="totalPrice"></span></p>
                  <a class="btn" data-id="{{ $info['id'] }}">立即购买</a>
                  <input type="hidden" id="boxPoint">
                  <input type="hidden" id="boxPrice">
            </div>
          </div>
          <div class="prev"></div>
          <div class="next"></div>
      </div>
  </div>
  {{-- 延展套餐HTML结构结束 --}}

  <div class="page-left">
    <div class="side-bar duoduo">
        <h2>推荐线路</h2>
        <ul>
            @if(isset($recom[0]))
            @foreach($recom as $value)
              <li><a href="/commodity/detail/{{ $value['id'] }}" target="_self" title="{{ $value['name'] }}">
                <img src="{{ $value['imageurl'] }}"/>
                <p class="side-font">{{ $value['name'] }}</p>
              </a>
              <span>￥{{ $value['minPrice'] }}</span></li>
            @endforeach
            @endif
        </ul>
    </div>
  </div>

  <div class="page-right">
      <a class="ready-btn" onclick="gobuy({{ $info['id'] }})" role="button">立即预订</a>
      <div class="ab">{{-- 绝对定位 --}}
        <ul class="nav nav-tabs" role="tablist" >
          <li role="presentation" class="active"><a href="#car1" aria-controls="car1" role="tab" data-toggle="tab">产品特色</a></li>
          <li role="presentation"><a href="#car2" aria-controls="car2" role="tab" data-toggle="tab">行程介绍</a></li>
          <li role="presentation"><a href="#car3" aria-controls="car3" role="tab" data-toggle="tab">费用说明</a></li>
          <li role="presentation"><a href="#car4" aria-controls="car4" role="tab" data-toggle="tab">预订须知</a></li>
          <li role="presentation"><a href="#car5" aria-controls="car5" role="tab" data-toggle="tab">用户点评</a></li>
        </ul>
      </div>
      <div class="myclear"></div>
      <div class="tab-content">
        <!-- 产品特色 -->
        <div role="tabpanel" class="tab-pane active article" id="car1">
          <?php echo $info['describe'] ?>
        </div>
        <!-- 行程介绍 -->
        <div role="tabpanel" class="tab-pane article" id="car2">
          <?php echo $info['travelIntroduction'] ?>
        </div>
        <!-- 费用说明 -->
        <div role="tabpanel" class="tab-pane article" id="car3">
          <?php echo $info['costDescription'] ?>
        </div>
        <!-- 预订须知 -->
        <div role="tabpanel" class="tab-pane article" id="car4">
          <?php echo $info['reservationInfo'] ?>
				</div>
        <!-- 用户点评 -->
        <div role="tabpanel" class="tab-pane article" id="car5">
            <div class="comment-box clear">
               <input type="hidden" name="_token" id="token" value="">
              {{--  {{ csrf_token() }} --}}
               <input type="hidden" name="type"  value="{{ \App\Model\Comment::$typeRider }}">
               <input type="hidden" name="cid"  value="{{ $info['id'] }}">
               {{-- {{ $articleLists->infoId }} --}}
              <h4>全部评论<small>已有{{ $commentcount }}名用户发表了评论</small></h4>
              <ul class="all-conmment">
                {{-- 用户评论 --}}
                @if(isset($comment[0]))
                @foreach($comment as $value)
                <li>
                  <div class="img-round"></div>
                  <img src="/image/get/{{$value['cover']}}" alt="">
                  <a>@if($value['anonymous'] == 1) 匿名用户 @else {{$value['username']}} @endif</a>
                  <span>发表时间：{{ date('Y-m-d H:i', $value['ocreated']) }}</span>
                  <p>{{ $value['comment'] }}</p>
                </li>
                @endforeach
                @endif
                {{-- 用户评论 --}}
              </ul>
              <!-- 翻页 -->
              <div class="page-action white clear">
                  {!!$pager!!}
              </div>
            </div>
        </div>
      </div>
  </div>

</div>
</div>
{!!HTML::script('common/carts.js') !!}
<script type="text/javascript">
var spec = $('#specs').attr('data-spec');
function gobuy(id) {
  if($('.detail-btn.buy').hasClass('disabled')) return false;
  else if(Cookies.get('lAmE_simple_auth')==undefined){
      location.href = '/login?reurl='+homeUrl;
      return false;
  }
  //var num = $('#count').val();
  var goTime = $('#goTime').text();
  
  //carts(2, 2, id, spec, 1);
  var param = {
      "type" : 2,
      "subtype" : 2,
      "goodsid" : id,
      "spec" : spec,
      "num" : 1
  };
  load($.post('/user/api/setcarts', param)).done(function (res) {
    if (res.status===0) window.location.href = '/cart';
    else littleTips(res['tips']);
  });
}

function addshop(id) {
    if($('.detail-btn.addshop').hasClass('disabled')) return false;
    else if(Cookies.get('lAmE_simple_auth')==undefined){
        location.href = '/login?reurl='+homeUrl;
        return false;
    }
    carts(2, 2, id, spec, 1);
}

function reload()
{
  window.location.href = '/cart';
}

//套餐购买
$('.go-buy .btn').on('click', function(){
    var data= {};
    var id = $(this).attr('data-id');
    if(Cookies.get('lAmE_simple_auth')==undefined){
        location.href = '/login?reurl='+homeUrl;
        return false;
    }
    else{
        data[0] = [2,2,id,spec,1];
        $('.check.active').each(function (index) {
            data[index+1] = $(this).data('cart');
        });
    }
    load($.post('/user/api/batchcarts', {cartMap:JSON.stringify(data)}))
    .done(function (msg) {
        if (msg.status === 0) {
            location.href = '/cart';
        } else {
            littleTips(msg['tips']);
        }
    })
    .fail(function (error) {
          return "加入购物车失败";
    });
});

function comment(page) {
    $.get('/store/comment', {'page': page,'type':$('input[name="type"]').val(), 'commodityId': $('input[name="cid"]').val()}, function (data) {//接口为真
        if (data.status == 0) {
            $('#conmment-box .page-action').html(data.content.page);
            if (data.content.comments) {
                var html = '';
                for(var i=0; i<data.content.comments.length; i++){
                    html += '<li>'+
                    '<div class="img-round"></div>'+
                    '<img src="/image/get/'+data.content.comments[i]['userInfo']['cover']+'" alt="">'+
                    '<a>'+data.content.comments[i]['userInfo']['username']+'</a>'+
                    '<span>发表时间：'+ data.content.comments[i]['createStr']+'</span>'+
                    '<p>'+ data.content.comments[i]['comment']+'</p>'+
                    '</li>'
                }

                $('.all-conmment').html(html);
            } else {
                littleTips(data.tips);
            }
        }
    });
}
</script>
@endsection