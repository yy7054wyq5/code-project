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
      wrap:false,//是否保留边框
      auto: false,//不自动播放
      pattern:'mF_fscreen_tb',//风格应用的名称
      time:3,//切换时间间隔(秒)
      trigger:'click',//触发切换模式:'click'(点击)/'mouseover'(悬停)
      width:854,//设置图片区域宽度(像素)
      height:524,//设置图片区域高度(像素)
      txtHeight:0,//文字层高度设置(像素),'default'为默认高度，0为隐藏
      loadIMGTimeout:0//图片延迟载入的时间
  });
</script>
{!!HTML::script('common/follow.js') !!}
@endsection
@section('content')
<div class="innovate-example-detail">
<div class="container detail-main">
  <ol class="breadcrumb">
    <li><a href="/innovate" class="red-font" target="_self">创库</a></li>
    <li class="arrow"></li>
    <li><a href="/innovate/example" class="red-font" target="_self">执行案例</a></li>
    <li class="arrow"></li>
    <li>{{$caseTypeName}}</li>
    <li class="arrow"></li>
    <li>{{$lists['caseName']}}</li>
  </ol>
  <div class="page-left">
  <div class="article">
    <h1>{{$lists['caseName']}}</h1>
    <div class="article-infor">
      <span class="writer">{{$lists->realname}}</span>
      <span class="date"> {!!date( 'Y-m-d H:i:s',$lists->created) !!}</span>
      <span class="info"><span class="red-font">{{$lists->point}}</span>人气 / <span class="red-font">{{$commentCount}}</span>评论 /<span class="red-font">@if(!empty($lists->recommendCount)){{$lists->recommendCount}} @else 0 @endif </span>推荐</span>
    </div>
    <div id="slide-box"><!--焦点图盒子-->
      <div class="pic"><!--内容列表(li数目可随意增减)-->
        <ul>
            @if( isset($lists['imageId']) && count($lists['imageId'])>0 && is_array($lists['imageId']))
                @foreach($lists['imageId'] as $k => $item)
                   <li><img src="/image/get/{{$item}}" thumb="" alt="" text="" jqimg="/image/get/{{$item}}"/></li>
                @endforeach
            @endif
        </ul>
      </div>
    </div>
    <h2>案例描述</h2>
     {!! $lists['content'] !!}
      @if(!empty($lists['path']) && file_exists(realpath('./'.$lists['path'])))
       <a href="/innovate/exampleDownload/{{$lists['enclosure']}}" class="btn ex-down">下载资料</a>
      @endif
    <div class="share clear"><span>分享到：</span>{!!HTML::script('common/bshare.js') !!}</div>
    <div class="myclear"></div>
  </div>
  <div class="comment-box">
      <h3>我有话说</h3>
        <form class="form-horizontal" id="form" onsubmit="return false;" >
            <input type="hidden" name="_token" id="token" value=""/>
            <input type="hidden" name="cid"  value="{{$lists['caseProductId']}}"/>
            <input type="hidden" name="commentType"  value="{{\App\Model\Comment::$typeCase}}}"/>
              <textarea class="conmment-field" name="comment" id="conmment">亲，内容是否喜欢？快说点什么吧！</textarea>
              <a class="btn" role="button">发表评论</a>
        </form>
      <div class="myclear"></div>
      <h4>全部评论<small>已有{{ $commentCount }}名用户发表了评论</small></h4>
      <ul class="all-conmment">
          {{-- 用户评论 --}}
          @if(count($commentList))
              @foreach($commentList as $key => $item)
                  <li>
                      <div class="img-round"></div>
                      <img src="/image/get/{{$item['cover']}}" alt="{{$item['subtitle']}}">
                      <a>{{$item['username']}}</a>
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
    <div class="page-right">
      <a class="btn up-example" href="/innovate/add-example" target="_self">上传案例</a>
      <a class="btn manage-example" href="/mine/case" target="_self">管理案例</a>
        @if(count($advList)>0)
            @foreach($advList as $key => $item)
                <a class="img-adv" href="{{$item['link']}}" target="_blank"><img src="/image/get/{{$item['imageId']}}"></a>
            @endforeach
        @endif
      <div class="clear-box"></div>
      <div class="side-bar-innovate">
          <div class="new-ex">最新案例<a href="/innovate/example-list" target="_blank">更多</a></div>
          <ul>
              {{-- 只有第一个LI才有图片后面的都没有 --}}
              @if($newExampleList)
                  @foreach($newExampleList as $key => $item)
                      @if($key == 0)
                          <li class="first clear"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self"><img src="/image/get/{{$item['coverId']}}"/><span>{{$item['caseName']}}</span></a></li>
                     @elseif($key<count($newExampleList)-1)
                          <li><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self"><span>{{$item['caseName']}}</span></a></li>
                      @else
                          <li class="last"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self"><span>{{$item['caseName']}}</span></a></li>
                      @endif
                  @endforeach
              @endif
          </ul>
          <div class="hot">人气案例<a href="/innovate/example-list" target="_blank">更多</a></div>
          <ul>
              {{-- 只有第一个LI才有图片后面的都没有 --}}
              @if($recommendExampleList)
                  @foreach($recommendExampleList as $key => $item )
                      @if($key == 0)
                         <li class="first clear"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self"><img src="{{$item['path']}}"/><span>{{$item['caseName']}}</span></a></li>
                     @elseif($key<count($recommendExampleList)-1)
                          <li><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self"><span>{{$item['caseName']}}</span></a></li>
                      @else
                        {{-- 最后一个LI需要加last样式 --}}
                        <li class="last"><a href="/innovate/example-detail/{{$item['caseProductId']}}" target="_self"><span>{{$item['caseName']}}</span></a></li>
                      @endif
                  @endforeach
              @endif
          </ul>
        <!--  <div class="new-co">最新发帖<a href="" target="_blank">更多</a></div>
          <ul class="co-box">
              <li><a href="" target="_self"><span>青春不散场同学会海报设计psd素材大大大大</span></a></li>
              <li><a href="" target="_self"><span>哒哒哒青春不散场同学会海报设计psd素材</span></a></li>
              {{-- 最后一个LI需要加last样式 --}}
              <li class="last"><a href="" target="_self"><span>大大大大青春不散场同学会海报设计psd素材</span></a></li>
          </ul> -->
      </div>
    </div>
</div>
</div>
@endsection
@section('footer-scripts')
    {{-- 下载的前端验证在这里面 --}}
    <script type="text/javascript" src="/js/loongjoy.clipdetail.js"></script>
    {!!HTML::script('common/carts.js') !!}
<script>
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
</script>
@endsection
