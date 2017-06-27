@extends('layouts.main')

@section('banner')
@endsection

@section('content')
<div class="invest-list-main">
<div class="container">
  <ol class="breadcrumb">
    <li><a href="/innovate" class="red-font" target="_self">创库</a></li><li class="arrow"></li><li>互动调研</li>
  </ol>
  <div class="page-left">
    <h1>互动调研</h1>
    <ul class="list">
        @if($questionList)
            @foreach($questionList as $key => $item)
                <li><a href="/innovate/invest-detail/{{$item['qid']}}" title="dadad" target="_self">{{$item['title']}}</a><span>{!! date('Y-m-d',$item['created']) !!}</span></li>
            @endforeach
        @endif
    </ul>
    <!-- 翻页 -->
    <div class="page-action white clear">
        <a class="page-up nopage" href="/innovate/invest-list?page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
        @for($i = 1; $i <= $count; $i++)
        <a role="button" href="/innovate/invest-list?page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
        @endfor
        <a class="page-down" href="/innovate/invest-list?page={{ $page + 1 >= $count ? $count : $page + 1 }}" role="button">下一页</a>
        <span style="margin-left:50px;">共{{ $count }}页</span>
        <span>到第</span>
        <input type="text" id="page">
        <span>页</span>
        <a role="button" class="btn">确定</a>
    </div>
  </div>
  <div class="page-right">
    <div class="side-bar-innovate">
        <div class="new-co">互动调研<a href="javascript:;">更多</a></div>
        <ul class="co-box">
            @if(count($rightQuestionList)>0)
                @foreach($rightQuestionList as $key => $item)
                    @if(count($rightQuestionList) > ($key+1))
                     <li><a href="/innovate/invest-detail/40" target="_self"><span>{{$item['title']}}</span></a></li>
                    @else
                     <li class="last"><a href="" target="_self"><span>{{$item['title']}}</span></a></li>
                    @endif
                @endforeach
            @endif
        </ul>
        <div class="new-co">资讯中心<a href="/infor/list/1" target="_blank">更多</a></div>
        <ul class="co-box">
            @if(count($rightInfoList)>0)
                @foreach($rightInfoList as $key => $item)
                    @if(count($rightInfoList) > ($key+1))
                        <li><a href="/infor/detail/2622" target="_self"><span>{{$item['infoTitle']}}</span></a></li>
                    @else
                        <li class="last"><a href="/infor/detail/2622" target="_self"><span>{{$item['infoTitle']}}</span></a></li>
                    @endif
                @endforeach
            @endif
        </ul>
        <div class="new-co">互动社区<a href="/bbs" target="_blank">更多</a></div>
        <ul class="co-box">
            @if(count($rightInteractList)>0)
                @foreach($rightInteractList as $key => $item)
                    @if(count($rightInteractList) > ($key+1))
                        <li><a href="/bbs" target="_self"><span>{{$item['title']}}</span></a></li>
                    @else
                        <li class="last"><a href="/bbs" target="_self"><span>{{$item['title']}}</span></a></li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
    $('.btn').click(function () {
        var page = $('#page').val() ? $('#page').val() : 1;
        window.location.href = '/innovate/invest-list?page='+page;
    });
</script>
@endsection
