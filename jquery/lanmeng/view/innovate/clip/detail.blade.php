@extends('layouts.main')

@section('banner')
@endsection

@section('header-scripts')
    <script type="text/javascript" src="/js/myfocus/myfocus-2.0.4.min.js"></script>
    <script type="text/javascript" src="/js/jquery.jqzoom.js"></script>
    <script type="text/javascript" src="/js/loongjoy.detail.js"></script>
{!!HTML::script('common/follow.js') !!}
@endsection

@section('content')
<div class="innovate-clip-detail">
<div class="container detail-main">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/innovate" target="_self" class="red-font">创库</a></li>
    <li class="arrow"></li>
    <li><a href="/innovate/clip" target="_self" class="red-font">共享素材</a></li>
    <li class="arrow"></li>
    <li>{{$lists['materialName']}}</li>
  </ol>
  <div class="detail-header clear">
    <div class="clip-img">
      <img src="{{$lists['path']}}">
    </div>
    {{-- 创意设计详情窗 --}}
   <form>
    <div class="detail-box">
        <h1>{{$lists['materialName']}}</h1>
        <span class="small-title red-font">微信素材/微信素材/微信素材</span>
        <ul class="status-bar clear">
            <li class="point">
                <p>价格：<span class="red-font-bold clipPoints">{{$lists['integral']}}</span><span class="red-font">积分</span></p>
                <p><span class="red-font">（下载所用积分将全部支付给上传用户）</span></p>
            </li>
            <li class="down">下载次数<span class="red-font big">@if(empty($lists['uploadCount'])) 0 @else {{$lists['uploadCount']}} @endif </span>
            </li>
        </ul>
        <div class="myclear"></div>
        <table>
          <tr>
            <td width="230"><span class="ls2w">品</span>牌：<span class="clipClassic">{{$lists['brandName']}}</span></td>
            <td>上传时间：@if($lists['created']){{date("Y-m-d H:i",$lists['created'])}} @endif</td>
          </tr>
          <tr>
            <td><span class="ls2w">车</span>型：@if(isset($lists['carmodleId'])) {{$lists['carmodleId']}} @endif</td>
            <td>文件类型：@if(isset($fileType[$lists['type']]) && !empty($fileType[$lists['type']])){{$fileType[$lists['type']]}} @endif </td>
          </tr>
          <tr>
            <td><span class="ls3w">上</span><span class="ls3w">传</span><span class="ls3wp">人</span>：@if(isset($lists['username']) && !empty($lists['username'])){{$lists['username']}}@endif</td>
            <td>文件大小：@if($lists['size']){{ \App\Utils\Helpers::refineSize(($lists['size'])) }} @else 0B @endif </td>
          </tr>
        </table>
        <div class="buy-box">
            <a class="detail-btn buy" id="downBtn">立刻下载</a>
            <a class="att @if($follow > 0) active @endif" role="button">关注商品</a>
            <div class="share"><span>分享</span>{!!HTML::script('common/bshare.js') !!}</div>
        </div>
        <div class="myclear"></div>
    </div>
   </form>
  </div>
  <div class="myclear"></div>
  <div class="page-left">
        <div class="side-bar-innovate">
            <div>最新上传</div>
            <ul>
                {{-- 只有第一个LI才有图片后面的都没有 --}}
                @if(isset($newLists) && count($newLists)>0)
                    @foreach($newLists as $key => $item)
                        @if($key ==0)
                            <li class="first clear"><a href="/innovate/clip-detail/{{$item['materialId']}}" target="_self"><img src="{{$item['path']}}"/><span>{{$item['materialName']}}</span></a></li>
                        @elseif(count($newLists) == ($key+1))
                            <li><a href="/innovate/clip-detail/{{$item['materialId']}}" target="_self"><span>{{$item['materialName']}}</span></a></li>
                        @else
                            {{-- 最后一个LI需要加last样式 --}}
                            <li class="last"><a href="/innovate/clip-detail/{{$item['materialId']}}" target="_self"><span>{{$item['materialName']}}</span></a></li>
                        @endif
                    @endforeach
                @endif
            </ul>
            <div>更多下载</div>
            <ul>
                {{-- 只有第一个LI才有图片后面的都没有 --}}
                @if(isset($maxUploadLists) && count($maxUploadLists)>0)
                @foreach($maxUploadLists as $key => $item)
                    @if($key ==0)
                           <li class="first clear"><a href="/innovate/clip-detail/{{$item['materialId']}}" target="_self"><img src="{{$item['path']}}"/><span>{{$item['materialName']}}</span></a></li>
                    @elseif(count($newLists) == ($key+1))
                            <li><a href="/innovate/clip-detail/{{$item['materialId']}}" target="_self"><span>{{$item['materialName']}}</span></a></li>
                    @else
                   {{-- 最后一个LI需要加last样式 --}}
                   <li class="last"><a href="/innovate/clip-detail/{{$item['materialId']}}" target="_self"><span>{{$item['materialName']}}</span></a></li>
                 @endif
                @endforeach
                @endif
            </ul>
        </div>
  </div>
  <div class="page-right">
      <ul class="nav nav-tabs " role="tablist" >
        <li role="presentation" class="active"><a href="#detail" aria-controls="design" role="tab" data-toggle="tab" >描述</a><div class="line"></div></li>
      </ul>
      <div class="myclear"></div>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="detail">
            {!! $lists['describle'] !!}
        </div>
      </div>
      <div class="comment-box">
        <h3>我有话说</h3>
          <form class="form-horizontal" id="form" onsubmit="return false;" >
              <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
              <input type="hidden" name="cid"  value="{{$lists['materialId']}}">
              <input type="hidden" name="commentType" value="{{\App\Model\Comment::$typeMaterial}}}" >
                <textarea class="conmment-field" name="comment" id="conmment">亲，内容是否喜欢？快说点什么吧！</textarea>
                <a class="btn"   role="button">发表评论</a>
          </form>
        <div class="myclear"></div>
          <h4>全部评论<small>已有{!! $commentCount !!}名用户发表了评论</small></h4>
          <ul class="all-conmment">
              @if(count($commentList))
              @foreach($commentList as $key => $item)
                <li>
                    <div class="img-round"></div>
                    <img src="{{ $item->cover }}" alt="">
                    <a>{!! $item['username'] !!}</a>
                    <span>发表时间：{!! date('Y-m-d H:i',$item['ocreated'])  !!}</span>
                    <p> {!! $item['comment']!!}</p>
                </li>
              @endforeach
              @endif
          </ul>
        <!-- 翻页 -->
        <div class="page-action white clear">
           {!!$page!!}
        </div>
      </div>
  </div>
</div>
</div>

<input type="hidden" id="Integral" value="@if(isset($userInfo->integral)){{$userInfo->integral}} @endif ">{{-- 用户拥有的积分 --}}
<input type="hidden" id="userPower" value="{{$bid}}" >{{-- 用户所属品牌ID--}}
<input type="hidden" id="clipPower" value="{{$lists->brandId}}" >{{-- 素材所属品牌ID--}}
<input type="hidden" id="mProductFile" value="/innovate/materialDownload/{{$lists['enclosure']}}" >{{-- 素材下载地址 --}}
<input type="hidden" id="areadyDown" value="{{$isDownload}}" >  {{-- 用户已下载该值为0 --}}
@endsection

@section('footer-scripts')
{{-- 下载的前端验证在这里面 --}}
<script type="text/javascript" src="/js/loongjoy.clipdetail.js"></script>
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
