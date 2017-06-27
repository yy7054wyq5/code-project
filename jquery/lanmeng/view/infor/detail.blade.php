@extends('layouts.main')

{{-- 关闭banner --}}
@section('banner')
@endsection
@section('content')
<div class="infor-detail-main">
<div class="container">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/infor" class="red-font" target="_self">资讯</a></li>
    <li class="arrow"></li>
    <li><a href="/infor/list/{{$articleLists->typeId}}" class="red-font" target="_self">{{ $typename }}</a></li>
    <li class="arrow"></li>
    <li class="current">{{$articleLists->infoTitle}}</li>
  </ol>
  <!-- 资讯详情左边 -->
  <div class="infor-detail-left">
    <div class="article">
      <h1>{{$articleLists->infoTitle}}</h1>
      <div class="article-infor"><span>来源：{{$articleLists->infoSource}}</span><span> {!! date('Y年m月d日 H:i',$articleLists->created)  !!}</span><span>浏览次数：{{$articleLists->point}}</span></div>
        {!!$articleLists->infoContent!!}
    </div>
    <div class="share clear"><span>分享到：</span>{!!HTML::script('common/bshare.js') !!}</div>
    <div class="myclear"></div>
    <div class="news-box">
        <h2>相关新闻<div class="h2-line"></div></h2>
        <ul>
            @if(count($categoryNews)>0)
                @foreach($categoryNews as $key => $item)
                   <li><a href="/infor/detail/{{$item['infoId']}}" target="_self" title="{{$item->infoDesc}}">{{$item->infoTitle}}</a></li>
                @endforeach
           @endif
        </ul>
    </div>
    <div class="comment-box">
      <h3>我有话说</h3>
        <form class="form-horizontal" id="form" onsubmit="return false;" >
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="cid"  value="{{ $articleLists->infoId }}">
            <input type="hidden" name="commentType"  value="{{\App\Model\Comment::$typeArticle}}}"/>
              <textarea class="conmment-field" name="comment" id="conmment">亲，内容是否喜欢？快说点什么吧！</textarea>
              <a class="btn"  role="button">发表评论</a>
        </form>
      <div class="clear"></div>
      <h4>全部评论<small>已有{{$userNumber}}名用户发表了评论</small></h4>
      <ul class="all-conmment">
        {{-- 用户评论 --}}
          @foreach($commentLists as $item)
        <li>
          <div class="img-round"></div>
          <img src="{{ $item['cover'] }}" alt="">
          <a>{{$item->username}}</a>
          <span>发表时间：{{ date('Y-m-d H:i', $item->created) }}</span>
          <p> {{$item->comment}}</p>
        </li>
          @endforeach
        {{-- 用户评论 --}}
      </ul>
      <!-- 翻页 -->
      <div class="page-action white clear">
          {!! $page !!}
      </div>
    </div>
  </div>
  <!-- 资讯详情右边 -->
  <div class="infor-detail-right">
    <div class="side-bar rank">
        <h2>新闻排行</h2>
        <ul>
            @if(count($newsSort)>0)
            @foreach($newsSort as $key => $item)
             <li><a href="/infor/detail/{{$item['infoId']}}" target="_self" title="{{$item['infoDesc']}}}"><span>{{$key+1}}&nbsp; </span>{{$item['infoTitle']}}</a></li>
            @endforeach
           @endif
        </ul>
    </div>
    <h2>热销宝贝</h2>
    <div class="side-bar duoduo">
        <ul>

            @if(isset($rightAds) && count($rightAds)>0)
                @foreach($rightAds as $rightAd)
                    <li><a href="@if($rightAd['link']){{starts_with($rightAd['link'], 'http://')?$rightAd['link']:'http://'.$rightAd['link']}}@else{{''}}@endif" target="_self" title="{{$rightAd['title']}}">
                            <img src="{{$rightAd['path']}}" data-original="{{$rightAd['path']}}" class="lazy" />
                            <p class="side-font">{{$rightAd['title']}}</p>
                        </a>
                        <span>￥{{$rightAd['presentPrice']}}</span>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="side-bar duoduo">
        <h2>多多推荐<small>Best buy</small></h2>
        <ul>
            @if(isset($recommends) && count($recommends) > 0)
                @foreach($recommends as $recommend)
                    <li><a href="/commodity/detail/{{$recommend['id']}}" target="_self" title="{{$recommend['name']}}">
                            <img src="/image/get/{{$recommend['cover']}}">
                            <p class="side-font">{{$recommend['name']}}</p>
                        </a>
                        <span>￥{{$recommend['minPrice']}}</span></li>
                @endforeach
            @endif
        </ul>
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
                        alertTips(data.tips);
                    }
                }
            });
        }
    </script>
@endsection
