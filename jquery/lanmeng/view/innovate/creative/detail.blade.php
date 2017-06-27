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
<div class="innovate-creative-detail">
<div class="container detail-main">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/innovate" target="_self" class="red-font">创库</a></li>
    <li class="arrow"></li>
    <li><a href="/innovate" target="_self" class="red-font">创意设计</a></li>
    <li class="arrow"></li>
    <li>车型元素</li>
    <li class="arrow"></li>
    <li>{{$lists->name}}</li>
  </ol>
  <div class="detail-header clear">
  <div style="float: left;width: 365px; height: 450px;">
    <div id="slide-box"><!--焦点图盒子-->
      <div class="pic"><!--内容列表(li数目可随意增减)-->
        <ul>
            {{-- 此处有放大镜效果：jqimg为大图路径，img的src为小图路径，img内的属性未用的不能去掉 --}}
            @if(count($photo)>0)
              @foreach($photo as $value)
                 <li><div class="jqzoom"><img src="@if(!file_exists(realpath('./'.$value))) /img/temp-img.png   @else {{ $value }} @endif  " thumb="" alt="" text="" jqimg="@if(!file_exists(realpath('./'.$value))) /img/temp-img.png   @else {{ $value }} @endif  "/></div></li>
              @endforeach
            @endif
        </ul>
      </div>
    </div>
    </div>
    {{-- 创意设计详情窗 --}}
    <form>
    <input type="hidden" name="cid"  value="{{$lists['id']}}">
    <div class="detail-box">
        <h1>{{$lists->name}}</h1>
        <span class="small-title red-font">{{$lists->title}}</span>
        <ul class="status-bar clear">
            <li class="point">
                <p>商品原价：<span class="delete-font">{{ isset($specificationSize[0]) ? intval($specificationSize[0]['sourcePrice']) :intval($lists->sourcePrice) }}积分</span></p>
                <p>促销价格：<span class="red-font-bold clipPoints" id="cost">{{ isset($specificationSize[0]) ? intval($specificationSize[0]['price']) : intval($lists->price) }}积分</span>（价值<span class="red-font RMBprice">￥{{ isset($specificationSize[0]) ? $specificationSize[0]['sourcePrice'] / 50 : $lists->sourcePrice / 50 }}</span>）<span class="red-font">（此单支付时须用积分全额抵扣）</span></p>
            </li>
            <li class="sell">已卖出<span class="red-font big">{{ $salenum }}</span>件
            </li>
            <li class="line"></li>
            <li class="conmment">累计评价<span class="blue-font-detail big">{{$commentCount}}</span>
            </li>
        </ul>
        <div class="myclear"></div>
        <input type="hidden" id="score" value="{{ $score }}" />
        <div class="size-box clear">
          <span><span class="ls2w">规</span>格：</span>
          <ul>
              @if(count($specificationSize)>0)
                   @foreach($specificationSize as $key => $item)
                    <li class=" @if($key == 0) active @endif "><a role="button" sizecost="{{$item['price']}}" data-id="{{$item['specId']}}"  oldcost="{{$item['price']}}">{{$item['specValue']}}</a></li>
                  @endforeach
              @endif
          </ul>
        </div>
        <div class="myclear"></div>
        <div class="buy-box">
            <a onclick="immediatelyBuy()"  data-id="{{$lists['id']}}" class="detail-btn buy ">立刻购买</a>
            <a onclick="addCarts()"  data-id="{{$lists['id']}}"   data-type="3" data-commodityid="{{ $lists['id'] }}" class="detail-btn addshop">加入购物车</a>
        </div>
        <div class="plus-box clear">
            <span>商品编号：{{$lists->code}}</span>
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
        <h2>同类推荐</h2>
        <ul>
            @foreach($similarProducts as $key => $item)
              <li><a href="/commodity/detail/{{$item['id']}}" target="_self" title="{{$item['title']}}">
                <img src="@if(!file_exists(realpath('./'.$item['path']))) /img/temp-img.png @else {{$item['path']}}  @endif  ">
                <p class="side-font">{{$item['name']}}</p>
              </a>
              <span>{{intval($item['price'])}}</span><span class="red-font">积分</span></li>
            @endforeach
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
                  {{-- 此段为创意详情的延展代码，直接从商品详情拖过来的，需要phper修改一下 --}}
                  @if(isset($packageDetails) && count($packageDetails)>0)
                      <?php $loop = count($packageDetails)>=4 ? 4:count($packageDetails)?>
                      @for($i=0; $i<$loop; $i++)
                          <li>
                              <a href="/innovate/creative-detail/{{$packageDetails[$i]['id']}}" target="_blank"><img src="{{$packageDetails[$i]['imageurl']}}" thumb="" alt="" text=""/></a>
                              <div class="txt-box">
                                  <span class="txt"><a href="/innovate/creative-detail/{{$packageDetails[$i]['id']}}" target="_blank">{{$packageDetails[$i]['name']}}</a></span>
                                  <div class="check" data-cart="{{$packageDetails[$i]['pCart']}}" ></div>
                                  <span class="num">{{intval($packageDetails[$i]['price'])}}积分</span>
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
                  <a class="btn" data-id="{{$lists['id']}}">立即购买</a>
                  <input type="hidden" value="1" id="count" />
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
        <li role="presentation" class="last commentApi "><a href="#conmment-box" aria-controls="clip" role="tab" data-toggle="tab">产品评价（{{$commentCount}}）</a><div class="line"></div></li>
      </ul>
      <div class="myclear"></div>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="detail">
            {!!$lists->describe!!}
        </div>
          <!-- 评论 -->
        <div role="tabpanel" class="tab-pane" id="conmment-box">
          <div class="comment-box">
            <h4>全部评论<small>已有{{ $commentCount }}名用户发表了评论</small></h4>
            <ul class="all-conmment">
              {{-- 用户评论 --}}
                @if(count($commentList))
                    @foreach($commentList as $key => $item)
                      <li>
                        <div class="img-round"></div>
                        <img src="/image/get/{{$item['cover']}}" alt="{{--$item['subtitle']--}}">
                        <a>@if($item['anonymous'] == 1) 匿名用户 @else {{$item['username']}} @endif</a>
                        <span>发表时间：{!! date('Y-m-d H:i',$item['ocreated'])  !!}</span>
                        <p> {!! $item['comment']!!}</p>
                      </li>
                    @endforeach
                @endif
           </ul>
            <!-- 翻页 -->
            <div class="page-action white clear">
                {!! $page !!}
            </div>
          </div>
        </div>
          <!--  结束  -->
      </div>
  </div>
</div>
</div>

<input type="hidden" name="commentType">
@endsection
@section('footer-scripts')
{{-- 下载的前端验证在这里面 --}}
<script type="text/javascript" src="/js/loongjoy.clipdetail.js"></script>
{!!HTML::script('common/carts.js') !!}
<script type="text/javascript" >
        var spec = $('.size-box ul li.active>a').attr('data-id');
        function addCarts(){
            if(Cookies.get('lAmE_simple_auth')===undefined){
                location.href = '/login?reurl='+homeUrl;
                return false;
            }
            var spec = $('.size-box ul li.active>a').attr('data-id');
            spec = spec ? spec :0;
            carts(3,4,'{{$lists->id}}', spec, 1);
          //console.log(spec);
        }
        
        function immediatelyBuy(){
            if(Cookies.get('lAmE_simple_auth')===undefined){
                location.href = '/login?reurl='+homeUrl;
                return false;
            }
            else if (parseInt($('#cost').text()) > $('#score').val()) {
                alertTips('你没有足够的积分，无法购买此商品!','/innovate/score','赚积分');
                return false;
            }
            
            spec = spec ? spec :0;
            //carts(3,4,'{{$lists->id}}', spec, 1);
            var param = {
                "type" : 3,
                "subtype" : 4,
                "goodsid" : '{{$lists->id}}',
                "spec" : spec,
                "num" : 1
            };
            load($.post('/user/api/setcarts', param)).done(function (res) {
              if (res.status===0) window.location.href = '/cart';
              else littleTips(res['tips']);
            });
        }

        function comment(page) {
            $.get('/store/comment', {'page': page,'type':$('input[name="commentType"]').val(), 'commodityId': $('input[name="cid"]').val()}, function (data) {//接口为真
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

        $('.go-buy .btn').on('click', function(){
            var data= {};
            var id = $(this).attr('data-id');
            if(Cookies.get('lAmE_simple_auth')==undefined){
                location.href = '/login?reurl='+homeUrl;
                return false;
            }
            else{
                data[0] = [3,4,id,spec,1];
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

</script>
@endsection





