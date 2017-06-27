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
      width:365,//设置图片区域宽度(像素)
      height:450,//设置图片区域高度(像素)
      txtHeight:0,//文字层高度设置(像素),'default'为默认高度，0为隐藏
      loadIMGTimeout:0//图片延迟载入的时间
  });
</script>
{!!HTML::script('common/follow.js') !!}
@endsection

@section('content')
<div class="gather-detail">
<div class="container detail-main">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/ju" target="_self" class="red-font">聚惠</a></li>
    <li class="arrow"></li>
    <li><a href="/ju/list" target="_self" class="red-font">火爆团购</a></li>
    <li class="arrow"></li>
    <li href="/ju/list/" class="red-font">{{ $titletype }}</li>
    <li class="arrow"></li>
    <li>{{ $info['name'] }}</li>
  </ol>
  <div class="detail-header clear">
  <div style="float: left;width: 365px; height: 450px;">
    <div id="slide-box"><!--焦点图盒子-->
      <div class="pic"><!--内容列表(li数目可随意增减)-->
        <ul>
            {{-- 此处有放大镜效果：jqimg为大图路径，img的src为小图路径，img内的属性未用的不能去掉 --}}
            @if($imagearr)
            @foreach($imagearr as $value)
            <li><div class="jqzoom"><img src="{{ $value }}" thumb="" alt="" text="" jqimg="{{ $value }}"/></div></li>
            @endforeach
            @endif
        </ul>
      </div>
    </div>
    </div>
    {{-- 详情窗 --}}
    <form>
    <div class="detail-box">
        <h1>{{ $info['name'] }}</h1>
        <span class="small-title red-font">{{ $info['title'] }}</span>
        <ul class="status-bar clear">
            <li class="price">
                <p>商品原价：<span class="delete-font">￥{{ isset($specs[0]) ? $specs[0]['sourcePrice'] : 0 }}</span></p>
                <p>促销价格：<span class="red-font-bold" id="cost">￥{{ isset($specs[0]) ?  $specs[0]['price'] : 0 }}</span>&nbsp;&nbsp;积分可抵<span class="toMoney">{{ isset($specs[0]) ? $specs[0]['maxCredits'] / 50 : 0 }}元</span></p>
                {{-- 直接在id="cost"内传入产品积分或者价格，积分格式：100积分;价格格式：￥100 ，有规格的默认为最低价--}}
            </li>
            <li class="other">
                <p>可获得积分：<span data-score="{{ floor($info['integral']) }}" class="giftPoint">{{ isset($specs[0]) ? floor($specs[0]['price']) : 0 }}</span>积分</p>
                <p style="margin-top:20px;"><span class="ls2w">运</span>费：{{ $info['dispatch'] }}</p>
            </li>
            <li class="sell">已卖出<span class="red-font big">{{ $info['saleNumber'] }}</span>件
            </li>
            <li class="line"></li>
            <li class="conmment">累计评价<span class="blue-font-detail big"><!-- {{ $info['commentNumber'] }} -->{{ $count }}</span>
            </li>
        </ul>
        <div class="myclear"></div>
        <input type="hidden" name="cid" value="{{ $info['id'] }}" />
        <input type="hidden" name="minNumber" value="{{ $info['minNumber'] }}" />
        <input type="hidden" name="maxNumber" value="{{ $info['maxNumber'] }}" />
        <div class="size-box clear">
          @if($specs)
          <span><span class="ls2w">规</span>格：</span>
          <ul>
            @foreach($specs as $key => $value)
            <li class="@if($key == 0) active @endif"><a role="button" sizecost="{{ $value['price'] }}" data-spec="{{ $value['specId'] }}" oldcost="{{ $value['sourcePrice'] }}" max-score="{{ $value['maxCredits'] }}" sizecount="{{ $value['inventory'] }}">{{ $value['specValue'] }}</a></li>
            @endforeach
             {{-- 规格不同价格不同,sizecost为当前规格的金额或者积分,默认为最低价,oldcost为原价,sizecount为当前规格最大数量,max-score为当前规格产品最多拿来抵用现金的积分 --}}
          </ul>
          @endif
          <input type="hidden" id="defaultCost">
          {{-- defaultCost为当前规格的单价 --}}
        </div>
        <div class="count-box clear">
          <span><span class="ls2w">数</span>量：</span>
          <ul>
            <li class="cutNum" role="button">-</li>
            <li class="cen"><input type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " value="1" id="count"></li>
            <li class="addNum" role="button">+</li>
            <li class="no-class">件（库存<span id="maxCount"></span>件）</li>
            {{-- id=maxCount的text需传入该商品的最大数量值 --}}
          </ul>
          <div class="myclear"></div>
        </div>
        <div class="myclear"></div>
        <div class="buy-box clear">
            <a class="detail-btn buy" onclick="gobuy({{ $info['id'] }})">立刻购买</a>
            <ul class="time clear">
                <li state="{{$info['state']}}">@if($info['state'] == 0)距离开始@else剩余时间@endif</li>
                <li class="day"><span>18</span><div class="shade"></div></li>
                <li>天</li>
                <li class="hour"><span>18</span><div class="shade"></div></li>
                <li>时</li>
                <li class="minute"><span>59</span><div class="shade"></div></li>
                <li>分</li>
                <li class="second"><span>59</span><div class="shade"></div></li>
                <li>秒</li>
            </ul>
            <input type="hidden" class="endTime" value="{{ $info['state'] == 0 ? $info['timeStart'] * 1000 : $info['timeEnd'] * 1000 }}">
            <input type="hidden" name="current" value="{{ time() * 1000 }}">
            <div class="myclear"></div>
        </div>
        <div class="plus-box clear">
            <span>商品编号：{{ $info['code'] }}</span>
            <a class="att @if($follow > 0) active @endif" role="button">关注商品</a>
            <div class="share clear"><span>分享</span>{!!HTML::script('common/bshare.js') !!}</div>
        </div>
        <div class="myclear"></div>
    </div>
    </form>
  </div>
  <div class="myclear"></div>
  <div class="page-left">
    <div class="side-bar duoduo">
        <h2>热门团购</h2>
        <ul>
            @if(isset($recom[0]))
            @foreach($recom as $value)
              <li><a href="/commodity/detail/{{ $value['id'] }}" target="_self" title="{{ $value['name'] }}">
                <img src="{{ $value['imageurl'] }}"/>
                <p class="side-font">{{ $value['name'] }}</p>
              </a>
              <span>￥{{ $value['price'] }}</span><span class="old-price">￥{{ $value['oldprice'] }}</span><span class="person">{{ $value['saleNumber'] }}</span>件已售出</li>
            @endforeach
            @endif
        </ul>
    </div>
  </div>
  {{-- 延展套餐HTML结构 --}}
  <div class="extension-box">
      <div class="tit">延展套餐选择</div>
      <div class="con">
          <div id="slide-box2"><!--焦点图盒子-->
            <div class="pic"><!--内容列表(li数目可随意增减)-->
              <ul class="clear">
                  {{-- 单个产品 --}}
                  @if(isset($packageDetails) && count($packageDetails)>0)
                      <?php $loop = count($packageDetails) >= 4 ? 4 : count($packageDetails)?>
                      @for($i=0; $i<$loop; $i++)
                          <li>
                              <a href="/commodity/detail/{{$packageDetails[$i]['id']}}" target="_blank"><img src="{{ $packageDetails[$i]['imageurl'] }}" thumb="" alt="" text=""/></a>
                              <div class="txt-box">
                                  <span class="txt"><a href="/commodity/detail/{{$packageDetails[$i]['id']}}" target="_blank">{{$packageDetails[$i]['name']}}</a></span>
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
  <div class="page-right">
      <ul class="nav nav-tabs " role="tablist" >
        <li role="presentation" class="active"><a href="#detail" aria-controls="design" role="tab" data-toggle="tab" >产品详情</a><div class="line"></div></li>
        <li role="presentation" class="last"><a href="#conmment-box" aria-controls="clip" role="tab" data-toggle="tab">产品评价（{{ $count }}）</a><div class="line"></div></li>
      </ul>
      <div class="myclear"></div>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="detail">
          <?php echo htmlspecialchars_decode($info['describe']) ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="conmment-box">
          <div class="comment-box">
             <input type="hidden" name="_token" id="token" value="">
            {{--  {{ csrf_token() }} --}}
            <h4>全部评论<small>累计发表了{{ $count }}条评论</small></h4>
            <ul class="all-conmment">
              {{-- 用户评论 --}}
              @if($comment)
              @foreach($comment as $value)
              <li>
                <div class="img-round"></div>
                <img src="{{ $value->cover ? $value->cover : '/img/auto-portrait-one.jpg' }}" alt="">
                <a>@if($value->anonymous == 1) 匿名用户 @else {{ $value->username }} @endif</a>
                <span>发表时间：{{ date('Y-m-d H:i', $value->created) }}</span>
                <p>{{ $value->comment }}</p>
              </li>
              @endforeach
              @endif
              {{-- 用户评论 --}}
            </ul>
            @if($comment)
            <!-- 翻页 -->
            <div class="page-action white clear">
                <a class="page-up nopage" href="/commodity/detail/{{ $info['id'] }}?page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
                @for($i = 1; $i <= $pagenum; $i++)
                <a role="button" href="/commodity/detail/{{ $info['id'] }}?page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
                @endfor
                <a class="page-down" href="/commodity/detail/{{ $info['id'] }}?page={{ $page + 1 >= $pagenum ? $pagenum : $page + 1 }}" role="button">下一页</a>
            </div>
            @endif
          </div>
          <div class="clear-box"></div>
        </div>
      </div>
  </div>
</div>
</div>
{!!HTML::script('common/carts.js') !!}
<script type="text/javascript">


function gobuy(id) {
  var num = $('#count').val();
  var mincount = $('input[name="minNumber"]').val();
  var spec = $('.size-box ul li.active>a').attr('data-spec');
  if($('.detail-btn.buy').hasClass('disabled')) return false;
  else if(Cookies.get('lAmE_simple_auth')==undefined){
      location.href = '/login?reurl='+homeUrl;
      return false;
  }
  else if(parseInt(num)<parseInt(mincount)&&parseInt(mincount)!==0){
      littleTips('购买量不能低于'+mincount);
      return false;
  }

  //carts(0, 1, id, spec, num);
  var param = {
      "type" : 0,
      "subtype" : 1,
      "goodsid" : id,
      "spec" : spec,
      "num" : num
  };
  load($.post('/user/api/setcarts', param)).done(function (res) {
    if (res.status===0) window.location.href = '/cart';
    else littleTips(res['tips']);
  });
  //reload();
  //setTimeout("reload()", 100);
}

$(function() {
// function reload()
// {
//   window.location.href = '/cart';
// }
  var mincount = $('input[name="minNumber"]').val();
  var spec = $('.size-box ul li.active>a').attr('data-spec');
  $('.go-buy .btn').on('click', function(){
      var num = $('#count').val();
      var data= {};
      var id = $(this).attr('data-id');
      if(Cookies.get('lAmE_simple_auth')==undefined){
          location.href = '/login?reurl='+homeUrl;
          return false;
      }
      //当前团购过期
      else if($('.detail-btn.buy').hasClass('disabled')){
          if($('.check.active').length===0){
              littleTips('请先选择延展套餐产品');
              return false;
          }
          $('.check.active').each(function (index) {
              data[index] = $(this).data('cart');
          });
      }
      else{
          if(parseInt(num)<parseInt(mincount)){
              littleTips('当前团购产品购买量不能低于'+mincount);
              return false;
          }
          data[0] = [0,1,id,spec,num];
          $('.check.active').each(function (index) {
              data[index+1] = $(this).data('cart');
          });
      }

      //console.log(data);

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

});
</script>
@endsection
