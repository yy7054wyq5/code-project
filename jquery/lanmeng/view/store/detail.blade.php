@extends('layouts.main')

@section('banner')
@endsection

@section('header-scripts')
<script type="text/javascript" src="/js/myfocus/myfocus-2.0.4.min.js"></script>
<script type="text/javascript" src="/js/jquery.jqzoom.js"></script>
<script type="text/javascript" src="/js/loongjoy.detail.js"></script>
<script src="/common/ueditor/ueditor.parse.min.js"></script>
<script>
    uParse('.uecontent', {
        rootPath: '/public/common/ueditor'
    });</script>
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
{!!HTML::script('common/carts.js') !!}
@endsection

@section('content')

<div class="store-detail">
<div class="container detail-main">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/store" target="_self" class="red-font">商城</a></li>
    <li class="arrow"></li>
    <li><a href="/store/list?categoryId={{ isset($type['master']['id']) ? $type['master']['id'] : '0' }}" target="_self" class="red-font">{{ isset($type['master']['title']) ? $type['master']['title'] : '---' }}</a></li>
    <li class="arrow"></li>
    <li>{{ isset($type['sub']['title']) ? $type['sub']['title'] : '---' }}</li>
  </ol>
  <div class="detail-header clear">
  <div style="float: left;width: 365px; height: 450px;">
    <div id="slide-box"><!--焦点图盒子-->
      <div class="pic"><!--内容列表(li数目可随意增减)-->
        <ul>
            {{-- 此处有放大镜效果：jqimg为大图路径，img的src为小图路径，img内的属性未用的不能去掉 --}}
            @if(isset($imagearr) && count($imagearr) > 0)
                @foreach($imagearr as $value)
                    <li><div class="jqzoom"><img src="{{ $value }}" thumb="" alt="" text="" jqimg="{{ $value }}"/></div></li>
                @endforeach
            @endif
        </ul>
      </div>
    </div>
    </div>
    {{--详情窗 --}}
    <form>
    <div class="detail-box">
        <h1>{{ $detail['name'] }}</h1>
        <span class="small-title red-font">{{ $detail['title'] }}</span>
        <ul class="status-bar clear">
            <li class="price">
                <p>商品原价：<span class="delete-font">￥{{ $specs[0]['sourcePrice'] }}</span></p>
                <p>促销价格：<span class="red-font-bold" id="cost">￥{{ $specs[0]['price'] }}</span><span class="tag">推荐</span>&nbsp;&nbsp;积分可抵<span class="toMoney">{{ $specs[0]['maxCredits'] / 50 }}元</span></p>
                {{-- 直接在id="cost"内传入产品积分或者价格，积分格式：100积分;价格格式：￥100 ，有规格的默认为最低价--}}
            </li>
            <li class="other">
                <p>可获得积分：<span class="giftPoint" data-score="{{ $detail['integral'] }}">{{$detail['integral']}}</span>积分</p>
                <p style="margin-top:20px;"><span class="ls2w">运</span>费：{{ $detail['dispatch'] }}</p>
            </li>
            <li class="sell">已卖出<span class="red-font big">{{$detail['saleNumber']}}</span>件
            </li>
            <li class="line"></li>
            <li class="conmment">累计评价<span class="blue-font-detail big">{{ count($comments) }}</span>
            </li>
        </ul>
        <div class="myclear"></div>
        <div class="size-box clear">
          <span><span class="ls2w">规</span>格：</span>
          <ul>
              @if(isset($specs) && count($specs) > 0)
                  @foreach($specs as $key => $value)
                      <li @if($key == 0) class="active" @endif><a role="button" data-specid="{{ $value['specId'] }}" sizecost="{{ $value['price'] }}" oldcost="{{ $value['sourcePrice'] }}" sizecount="{{ $value['inventory'] }}" max-score="{{ $value['maxCredits'] }}">{{ $value['specValue'] }}</a></li>
                  @endforeach
              @endif
            {{-- 规格不同价格不同,sizecost为当前规格的金额或者积分,默认为最低价,oldcost为原价,sizecount为当前规格最大数量 --}}
          </ul>
          <input type="hidden" id="defaultCost">
          {{-- defaultCost为当前规格的单价 --}}
        </div>
        <div class="count-box">
          <span><span class="ls2w">数</span>量：</span>
          <ul>
            <li class="cutNum" role="button">-</li>
            <li class="cen"><input type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " value="1" id="count"></li>
            <li class="addNum" role="button">+</li>
            <li class="no-class">件（库存<span id="maxCount"></span>件）</li>
            {{-- id=maxCount的text需传入该商品的最大数量值 --}}
          </ul>
        </div>
        <div class="myclear"></div>
        <div class="buy-box">
            <a class="detail-btn buy @if($detail['status'] == 0) disabled @endif" onclick="buyNow()">立刻购买</a>
            <a class="detail-btn addshop @if($detail['status'] == 0) disabled @endif" data-type="{{ $paytype }}" data-commodityid="{{ $detail['id'] }}">加入购物车</a>
        </div>
        <div class="plus-box clear">
            <span>商品编号：{{$detail['code']}}</span>
            <a class="att @if($follow) active @endif" role="button">关注商品</a>
            <div class="share clear"><span>分享</span>{!!HTML::script('common/bshare.js') !!}</div>
        </div>
        <div class="myclear"></div>
    </div>
    </form>
  </div>
  <div class="myclear"></div>
  <div class="page-left">
    <div class="side-bar duoduo">
        <h2>同类商品</h2>
        <ul>
            @if(isset($top) && count($top))
                @foreach($top as $value)
                    <li><a href="/commodity/detail/{{ $value['id'] }}" target="_self" title="{{ $value['title']}} ">
                            <img src="{{ $value['cover'] }}"/>
                            <p class="side-font">{{ $value['name'] }}</p>
                        </a>
                        <span>￥{{ $value['minPrice'] }}</span></li>
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
                      <?php $loop = count($packageDetails)>=4 ? 4:count($packageDetails)?>
                      @for($i=0; $i<$loop; $i++)
                      @if($packageDetails[$i]['id'])
                      <li>
                      <a href="/commodity/detail/{{$packageDetails[$i]['id']}}" target="_blank">
                        <img src="{{$packageDetails[$i]['imageurl']}}" thumb="" alt="" text=""/>
                      </a>
                      <div class="txt-box">
                        <span class="txt">
                          <a href="/commodity/detail/{{$packageDetails[$i]['id']}}" target="_blank">{{$packageDetails[$i]['name']}}</a>
                        </span>
                        <div class="check" data-cart="{{$packageDetails[$i]['pCart']}}"></div>
                        <span class="num">￥{{$packageDetails[$i]['price']}}</span>
                      </div>
                      <div class="myclear"></div>
                      </li>
                      @endif
                      @endfor
                  @endif
              </ul>
              <div class="myclear"></div>
            </div>
            <div class="go-buy">
                  <p class="txt">套餐价</p>
                  <p class="total">=<span class="red-font" id="totalPoint"></span><span class="jf">积分</span><span class="plus">+</span><span class="red-font money">￥</span><span class="red-font" id="totalPrice"></span></p>
                  <a class="btn">立即购买</a>
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
        <li role="presentation" class="last"><a href="#conmment-box" aria-controls="clip" role="tab" data-toggle="tab">产品评价（{{ count($comments) }}）</a><div class="line"></div></li>
      </ul>
      <div class="myclear"></div>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active uecontent" id="detail">
            <?php echo  htmlspecialchars_decode($detail['describe'])?>
        </div>
        <div role="tabpanel" class="tab-pane" id="conmment-box">
          <div class="comment-box">
            <input type="hidden" name="_token" id="token" value="">
            <input type="hidden" name="cid"  value="{{ $detail['id'] }}">
            <input type="hidden" name="commentType"  value="1">
            <h4>全部评论<small>已有{{ count($comments) }}名用户发表了评论</small></h4>
            <ul class="all-conmment">
              {{-- 用户评论 --}}
                @if(isset($comments) && count($comments) >0)
                    @foreach($comments as $comment)
                    <li>
                        <div class="img-round"></div>
                        <img src="{{ $comment['imageUrl'] ? $comment['imageUrl'] : '/img/auto-portrait-one.jpg' }}" alt="">
                        <a>{{$comment['username'] && $comment['anonymous'] != 1 ? $comment['username'] : '匿名用户'}}</a>
                        <span>发表时间：{{date('Y-m-d H:i:s', $comment['created'])}}</span>
                        <p>{{$comment['comment']}}</p>
                    </li>
                    @endforeach
                @endif
              {{-- 用户评论 --}}
            </ul>
            <!-- 翻页 -->
            {{--<div class="page-action white clear">--}}
            {{--</div>--}}
              <?php //echo $page ?>
          </div>
        </div>
      </div>
  </div>
</div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        function buyNow()
        {
            if($('.detail-btn.buy').hasClass('disabled')) return false;
            else if(Cookies.get('lAmE_simple_auth')==undefined){
                location.href = '/login?reurl='+homeUrl;
                return false;
            }

            // 加入购物车
            var $addshop = $('.detail-btn.addshop');
            var type = $addshop.data('type'), subtype= 0, commodityId = $addshop.data('commodityid'), spec=$('.size-box.clear ul li.active a').attr('data-specid'), nums=$('#count').val();
            var param = {
                "type" : type,
                "subtype" : subtype,
                "goodsid" : commodityId,
                "spec" : spec,
                "num" : nums
            };
            load($.post('/user/api/setcarts', param)).done(function (res) {
              if (res.status==0) window.location.href = '/cart';
              else littleTips(res['tips']);
            });
        }

        $('.detail-btn.addshop').on('click', function(){

            if($(this).hasClass('disabled')) return false;
            else if(Cookies.get('lAmE_simple_auth')==undefined){
                location.href = '/login?reurl='+homeUrl;
                return false;
            }
            var type = $(this).data('type'), subtype= 0, commodityId = $(this).data('commodityid'), spec=$('.size-box.clear ul li.active a').attr('data-specid'), nums=$('#count').val();
            return carts(type, subtype, commodityId, spec, nums);

        });

        $('.go-buy .btn').on('click', function(){
            var data= {};
            if($('.detail-btn.buy').hasClass('disabled')) return false;
            else if(Cookies.get('lAmE_simple_auth')==undefined){
                location.href = '/login?reurl='+homeUrl;
                return false;
            }
            //当前产品库存若为0的处理
            else if($('.detail-btn.buy').hasClass('disabled')){
                $('.check.active').each(function (index) {
                    data[index] = $(this).data('cart');
                });
            }
            else{
                data[0] = [$('.detail-btn.addshop').data('type'), 0, $('.detail-btn.addshop').data('commodityid'), $('.size-box.clear ul li.active a').attr('data-specid'),$('#count').val()];
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
            $.get('/store/comment', {'page': page,'type':$('input[name="commentType"]').val(), 'commodityId': $('input[name="cid"]').val()}, function (data) {//接口为真
                if (data.status == 0) {
                    $('#conmment-box .page-action').html(data.content.page);
                    if (data.content.comments) {
                        var html = '';
                        for(var i=0; i<data.content.comments.length; i++){
                            var imageUrl = content.comments[i]['userInfo']['cover'] && content.comments[i]['userInfo']['cover'] && content.comments[i]['userInfo']['cover'] != null ? '/image/get/' + content.comments[i]['userInfo']['cover'] : '/img/mine/me_home_hp_nor.jpg'
                            html += '<li>'+
                            '<div class="img-round"></div>'+
                            '<img src="'+imageUrl+'" alt="">'+
                            '<a>'+data.content.comments[i]['userInfo']['username']+'</a>'+
                            '<span>发表时间：'+ data.content.comments[i]['createStr']+'</span>'+
                            '<p>'+ data.content.comments[i]['comment']+'</p>'+
                            '</li>'
                        }
                        $('#conmment-box .all-conmment').html(html);
                    } else {
                        littleTips(data.tips);
                    }

                }
            });
        }


    </script>
@endsection


