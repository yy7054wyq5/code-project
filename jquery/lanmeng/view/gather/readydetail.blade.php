@extends('layouts.main')

@section('banner')
@endsection

@section('header-scripts')
<script type="text/javascript" src="/js/myfocus/myfocus-2.0.4.min.js"></script>
<script type="text/javascript" src="/js/jquery.jqzoom.js"></script>
<script src="/common/ueditor/ueditor.parse.min.js"></script>
<script type="text/javascript" src="/js/loongjoy.detail.js"></script>
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
<div class="gather-ready-detail">
<div class="container detail-main gather-detail">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/ju" target="_self" class="red-font">聚惠</a></li>
    <li class="arrow"></li>
    <li><a href="/ju/readylist?categoryId={{ $detail['categoryId'] }}" target="_self" class="red-font">{{ $category }}</a></li>
    <li class="arrow"></li>
    <li>{{ $detail['name'] }}</li>
  </ol>
  <div class="detail-header clear">
  <div style="float: left;width: 365px; height: 450px;">
    <div id="slide-box"><!--焦点图盒子-->
      <div class="pic"><!--内容列表(li数目可随意增减)-->
        <ul>
            {{-- 此处有放大镜效果：jqimg为大图路径，img的src为小图路径，img内的属性未用的不能去掉 --}}
            @if($specs)
            @foreach($specs as $value)
            <li>
            <div class="jqzoom"><img src="{{ $value['imageurl'] }}" thumb="" alt="" text="" jqimg="{{ $value['imageurl'] }}"/></div>
            </li>
            @endforeach
            @endif
        </ul>
      </div>
    </div>
    </div>
    {{-- 详情窗 --}}
    <form>
    <div class="detail-box">
        <h1>{{$detail['name']}}</h1>
        <span class="small-title red-font">{{$detail['title']}}</span>
        <ul class="status-bar clear">
            <li class="price">
                <p>商品原价：<span class="delete-font">￥{{$detail['sourcePrice']}}</span></p>
                <p><span class="ls2w">价</span>格：<span class="red-font-bold" id="cost">￥{{$detail['prepayPrice']}}</span>&nbsp;&nbsp;积分可抵<span class="toMoney">{{$detail['prepayPrice'] /50}}元</span></p>
                {{-- 直接在id="cost"内传入产品积分或者价格，积分格式：100积分;价格格式：￥100 ，有规格的默认为最低价--}}
            </li>
            <li class="other">
                <p>可获得积分：<span class="giftPoint" data-score="{{ $detail['integral'] }}">{{$detail['integral']}}</span>积分</p>
                <p style="margin-top:20px;"><span class="ls2w">运</span>费：{{ $detail['dispatch'] }}</p>
            </li>
            <li class="sell">已卖出<span class="red-font big">{{ $detail['saleNumber'] }}</span>件
            </li>
            <li class="line"></li>
            <li class="conmment">累计评价<span class="blue-font-detail big">{{ $commentCnt }}</span>
            </li>
        </ul>
        <div class="myclear"></div>
        <div class="size-box clear">
          <span><span class="ls2w">规</span>格：</span>
          <ul>
              @if(isset($specs) && count($specs)>0)
                  @foreach($specs as $k=>$spec)
                  <li @if($k == 0) class="active" @endif>  <a role="button" sizecost="{{$detail['prepayPrice']}}" oldcost="{{$detail['sourcePrice']}}" sizecount="{{$detail['maxNumber']}}" data-specid="{{ $spec['specId'] }}" max-score="{{$detail['maxCredits']}}">{{$spec['specValue']}}</a></li>
                  @endforeach
              @endif
             {{-- 规格不同价格不同,sizecost为当前规格的金额或者积分,默认为最低价,oldcost为原价,sizecount为当前规格最大数量 --}}
          </ul>
          <input type="hidden" id="defaultCost">
          {{-- defaultCost为当前规格的单价 --}}
        </div>
        <div class="count-box clear">
          <span><span class="ls2w">数</span>量：</span>
          <ul>
            <li class="cutNum" role="button">-</li>
            <li class="cen"><input type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " value="1" id="count"></li>
            <li class="addNum" role="button">+</li>
            <li class="no-class">件</li>
            {{-- id=maxCount的text需传入该商品的最大数量值 --}}
          </ul>
          <div class="complete-bar">
              <span>达成率</span>
              <div class="bar"><div class="going" data-rate={{ $detail['rate'] }} style="width:{{ $detail['rate'] * 214 }}px;"></div><div class="imgBox"><img src="/img/jh_ic_listar.png"><span>{{ $detail['rate'] * 100 }}%</span></div></div>
              {{-- going宽度为214px就是100% --}}
          </div>
          <div class="myclear"></div>
        </div>
        <div class="myclear"></div>
        <div class="stage-box clear" minicount="{{ $detail['minNumber'] }}" minicount="{{ $detail['maxNumber'] }}">
            <span><span class="ls2w">阶</span>段：</span>
            <ul class="clear">
                @if(isset($rangePrices) && count($rangePrices)>0)
                    @foreach($rangePrices as $rangePrice)
                        <li @if($detail['saleNumber'] >=$rangePrice['numberStart'] && $detail['saleNumber'] <=$rangePrice['numberEnd'])class="active" @endif><span>{{$rangePrice['numberStart']}}-{{$rangePrice['numberEnd']}}件<span class="red-font">￥{{$rangePrice['price']}}</span></span></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="buy-box clear">
            <a class="detail-btn buy @if($detail['state'] == 2) disabled @endif" data-commodityid={{ $detail['id'] }}>立刻预订</a>
            {{-- class里面加上disabled就是灰的了 --}}
            @if($detail['state'] != 2)
            <ul class="time clear">
                <li>@if($detail['state'] == 0) 距离开始 @else 剩余时间 @endif</li>
                <li class="day"><span>0</span><div class="shade"></div></li>
                <li>天</li>
                <li class="hour"><span>0</span><div class="shade"></div></li>
                <li>时</li>
                <li class="minute"><span>0</span><div class="shade"></div></li>
                <li>分</li>
                <li class="second"><span>0</span><div class="shade"></div></li>
                <li>秒</li>
            </ul>
            @endif
            <input type="hidden" class="endTime" value="@if($detail['state'] == 0) {{$detail['timeStart'] * 1000}} @else {{$detail['timeEnd'] * 1000}} @endif">
            <div class="myclear"></div>
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
        <h2>最新预购</h2>
        <ul>
            @if(isset($newestCommodities) && count($newestCommodities) > 0)
                @foreach($newestCommodities as $newestCommodity)
                    <li><a href="/commodity/detail/{{$newestCommodity['id']}}" target="_self" title="{{$newestCommodity['name']}}">
                            <img src="/image/get/{{$newestCommodity['cover']}}"/>
                            <p class="side-font">{{$newestCommodity['name']}}</p>
                        </a>
                        <span>￥{{$newestCommodity['showPrice']}}</span><span class="old-price"></span><span class="person">{{$newestCommodity['saleNumber']}}</span>件已售出</li>
                @endforeach
            @endif
        </ul>
    </div>
  </div>

  <div class="page-right">
      <ul class="nav nav-tabs " role="tablist" >
        <li role="presentation" class="active"><a href="#detail" aria-controls="design" role="tab" data-toggle="tab" >产品详情</a><div class="line"></div></li>
        <li role="presentation" class="last"><a href="#conmment-box" aria-controls="clip" role="tab" data-toggle="tab">产品评价（{{$commentCnt}}）</a><div class="line"></div></li>
      </ul>
      <div class="myclear"></div>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active uecontent" id="detail">
            <?php echo htmlspecialchars_decode($detail['describe']) ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="conmment-box">
          <div class="comment-box">
            <input type="hidden" name="_token" id="token" value="">
            <input type="hidden" name="cid"  value="{{ $detail['id'] }}">
            <input type="hidden" name="commentType"  value="8">
            <input type="hidden" name="current" value="{{time()}}">
            <h4>全部评论<small>累计发表了{{ $commentCnt }}条评论</small></h4>
            <ul class="all-conmment">
              {{-- 用户评论 --}}
                @if(isset($comments) && count($comments) >0)
                    @foreach($comments as $comment)
                        <li>
                            <div class="img-round"></div>
                            <img src="{{array_get($comment, 'userInfo') && array_get($comment['userInfo'], 'cover') ? '/image/get/'.$comment['userInfo']['cover'] : '/img/auto-portrait-one.jpg'}}" alt="">
                            <a>{{array_get($comment, 'userInfo') && $comment['anonymous'] != 1 ? $comment['userInfo']['username'] : '匿名用户'}}</a>
                            <span>发表时间：{{date('Y-m-d H:i:s', $comment['created'])}}</span>
                            <p>{{$comment['comment']}}</p>
                        </li>
                    @endforeach
                @endif
              {{-- 用户评论 --}}
            </ul>
            <!-- 翻页 -->
              <?php echo $page ?>
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
        $('.detail-btn.buy').on('click', function(){
            var minicount = $('.stage-box').attr('minicount');
            var maxcount = $('.size-box li.active>a').attr('sizecount');
            var count = $('#count').val();

            if ($(this).hasClass('disabled')) return false;
            else if(Cookies.get('lAmE_simple_auth')==undefined){
                location.href = '/login?reurl='+homeUrl;
                return false;
            }else if(parseInt(count)<parseInt(minicount)){
                littleTips('起订量不能低于'+minicount);
                return false;
            }else if(parseInt(count)>parseInt(maxcount)){
                littleTips('起订量不能大于'+maxcount);
                return false;
            }
            var commodityId = $(this).data('commodityid'), spec=$('.size-box.clear ul li.active a').data('specid'), nums=$('#count').val();
            var param = {
                "type" : 4,
                "subtype" : 3,
                "goodsid" : commodityId,
                "spec" : spec,
                "num" : nums
            };
            load($.post('/user/api/setcarts', param)).done(function (res) {
              if (res.status===0) window.location.href = '/cart';
              else littleTips(res['tips']);
            });

        });


        function comment(page) {
            $.get('/store/comment', {'page': page, 'type':$('input[name="commentType"]').val(), 'commodityId': $('input[name="cid"]').val()}, function (data) {//接口为真
                if (data.status == 0) {
                    $('#conmment-box .page-action').html(data.content.page);
                    if (data.content.comments) {
                        var imageUrl = content.comments[i]['userInfo']['cover'] && content.comments[i]['userInfo']['cover'] && content.comments[i]['userInfo']['cover'] != null ? '/image/get/' + content.comments[i]['userInfo']['cover'] : '/img/mine/me_home_hp_nor.jpg';
                        var html = '';
                        for(var i=0; i<data.content.comments.length; i++){
                            html += '<li>'+
                            '<div class="img-round"></div>'+
                            '<img src="'+imageUrl+'" alt="">'+
                            '<a href="">'+data.content.comments[i]['userInfo']['username']+'</a>'+
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


