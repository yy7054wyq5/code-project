@extends('layouts.main')

@section('banner')
@endsection
@section('content')
<div class="deal-detail-main">
<div class="container detail-main">
  <ol class="breadcrumb">
    <li><a href="/deal" class="red-font" target="_self">交易平台</a></li>
    <li class="arrow"></li>
    <li>{{ mb_substr($info->title, 0, 15, 'utf-8') }}</li>
  </ol>
  <div class="detail-box">
      <h1>{{ $info->title }}</h1>
      <div class="sub-h clear"><span class="tag">@if($info->status == 0) 进行中 @else 已结束 @endif</span><span class="deal-date">发布时间：{{ date('Y-m-d H:i', $info->created) }}</span></div>
      <div class="myclear"></div>
      <table>
          <tr>
            <td colspan="2"><span class="ls2w">品</span>牌：{{ $info->brand }}</td>
          </tr>
          <tr>
            <td colspan="2"><span class="ls2w">车</span>型：{{ $info->cartype }}</td>
          </tr>
          <tr>
            <td width="450"><span class="ls2w">单</span>价：  <span class="red-font">¥ <span class="font22">{{ $info->price }}</span></span></td>
            <td><span class="ls2w">成</span>色：{{ $info->quality }}</td>
          </tr>
          <tr>
            <td><span class="ls2w">数</span>量：<span class="red-font">{{ $info->num }}</span></td>
            <td>出厂日期：{{ date('Y年m月d日', $info->factorytime) }}</td>
          </tr>
          <tr>
            <td class="qq-talk-box"><span class="ls3w">联</span><span class="ls3w">系</span><span class="ls3wp">人</span>：{{ $info->linkname }}<!-- <a class="qq-talk" role="button" target="_blank" href="http://wpa.qq.com/msgrd?v=1&amp;uin=发布人QQ号"></a> --></td>
            <td><span class="ls2w">地</span>址：{{ $info->province }}{{ $info->city }}{{ $info->address }}</td>
          </tr>
          <tr>
            <td colspan="2"><div class="deal-mobile"><i class="left-icon"></i><span>{{ $info->mobile }}</span><i class="right-icon"></i></div></td>
          </tr>
      </table>
  </div>
  <div class="detail-user-box">
    <div class="detail-user">
        <div class="user-trans"></div>
        <img src="{{ isset($userinfo->image) ? $userinfo->image : '/img/auto-portrait-one.jpg' }}">
    </div>
    <ul>
      <li>{{ isset($userinfo->company) ? $userinfo->company : '暂无公司名称信息' }}</li>
      <li>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;区：{{ isset($userinfo->addressstr) ? $userinfo->addressstr : '-----' }}</li>
      <li>所属品牌：{{ isset($userinfo->brand) ? $userinfo->brand : '-----' }}</li>
      <li>加入时间：{{ isset($userinfo->created) ? date('Y年m月d日', $userinfo->created) : '暂无数据' }}</li>
    </ul>
  </div>
  <h2>描述</h2>
  <div class="article">
    <?php echo htmlspecialchars_decode($info->content);?>
  </div>
  <div class="comment-box">
    <h3>我有话说</h3>
      <form class="form-horizontal" id="form" onsubmit="return false;" >
          <input type="hidden" name="_token" id="token" value="">
          <input type="hidden" name="commentType"  value="7">
          <input type="hidden" name="cid"  value="{{ $info->id }}">
            <textarea class="conmment-field" name="comment" id="conmment">亲，内容是否喜欢？快说点什么吧！</textarea>
            <a class="btn" role="button">发表评论</a>
      </form>
    <div class="myclear"></div>
    <h4>全部评论<small>已有{{ $count }}名用户发表了评论</small></h4>
    <ul class="all-conmment">
      {{-- 用户评论 --}}
      @if($lists)
      @foreach($lists as $value)
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
    <!-- 翻页 -->
    @if($lists)
    <?php echo $page;?>
    @endif
    <!-- 翻页 -->
  </div>

</div>
</div>
@endsection