@extends('layouts.main')
@section('styles')
<link rel="stylesheet" href="/css/mine.css">
@endsection
@section('footer-scripts')
<script type="text/javascript" src="/js/validate/jquery.validate.min.js"></script>
<script src="/js/My97DatePicker/WdatePicker.js"></script>
<script src="/uploader/SimpleAjaxUploader.js"></script>
<script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "//hm.baidu.com/hm.js?d56bba6bf3c28cf93142896f846bc6f7";
      var s = document.getElementsByTagName("script")[0];
      s.parentNode.insertBefore(hm, s);
    })();
</script>
<script>
  $.validator.addMethod(
    "pattern",
    function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    },
    "Please check your input."
  );
</script>
<script src="/js/mine.js"></script>
@endsection
@section('header')
<div class="header uc-header" id="j_uc_header">
  <div class="fixed">
    <div class="container">
        <ul class="header-top">
        @if(is_null($user))
         <li ><a href="/login" target="_self" class="red-font">亲，请登录</a></li>
         <li><a href="/reg" target="_self">注册</a></li>
         @else
         <li><a href="javascript:;" class="minename">{{ Session::get('user.username') }}</a></li>
         <li><a onclick="loginOut()" role="button">退出</a></li>
         @endif
         <li><a href="/mine">我的蓝网</a></li>
         <li><a href="/mine/order/11">我的订单</a></li>
         <li><a href="/cart">我的购物车(<b id="car_num">{{ isset($cartsnum) ? $cartsnum : 0 }}</b>)</a></li>
        </ul>
    </div>
    <div class="line clear"></div>
  </div>
  <div class="uc-header-body">
    <div class="container">
      <h1 class="logo"><a href="/">蓝网,汽车终端营销整合服务平台</a></h1>
      <ul class="unav">
        <li><a href="/">首页</a></li>
        <li class="drop">
          <a href="javascript:;" class="drop-toggle">账户设置</a>
          <div class="drop-menu">
            <a href="/mine/setting">个人设置</a>
            <!-- <a href="#">我的头像</a> -->
            <a href="/mine/address">收货地址</a>
            <a href="/mine/pwd">账户安全</a>
            <a href="/mine/auth">我的认证</a>
          </div>
        </li>
        @if(Session::get('bbs_auth') === 0)
        <li><a href="/bbs">社区</a></li>
        @endif
      </ul>
      <div class="search">
        <form>
          <a href="javascript:;" class="search-tab active">商品</a>
          <a href="javascript:;" class="search-tab">案例</a>
          @if(Session::get('bbs_auth') === 0)
          <a href="javascript:;" class="search-tab">社区</a>
          @endif
          <a href="javascript:;" class="search-tab">资讯</a>
          <input type="text" class="search-ipt">
          <input type="submit" value="搜索" class="search-btn">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="uc">
  <div class="container">
    <div class="uc-main">
      @section('uc-content')
      @show
    </div>
    <div class="uc-side">
      <!-- menu -->
      <?php $tempurl = explode('?', $_SERVER['REQUEST_URI'])[0];?>
      <div class="uc-menu">
        <dl>
          <dt>订单中心</dt>
          <dd class="@if($tempurl == '/mine/order/11') active @endif"><a href="/mine/order/11">我的订单</a></dd>
          <dd class="@if($tempurl == '/mine/order2') active @endif"><a href="/mine/order2">创库订单</a></dd>
        </dl>
        <dl>
          <dt>关注中心</dt>
          <dd class="@if($tempurl == '/mine/focus') active @endif"><a href="/mine/focus">关注的商品</a></dd>
          <dd class="@if($tempurl == '/mine/case') active @endif"><a href="/mine/case">我的案例</a></dd>
          <dd class="@if($tempurl == '/mine/deal') active @endif"><a href="/mine/deal">我的交易</a></dd>
          <dd class="@if($tempurl == '/mine/material') active @endif"><a href="/mine/material">我的素材</a></dd>
        </dl>
        <dl>
          <dt>资产中心</dt>
          <dd class="@if($tempurl == '/mine/score') active @endif"><a href="/mine/score">我的积分</a></dd>
          <dd class="@if($tempurl == '/mine/grow') active @endif"><a href="/mine/grow">我的成长值</a></dd>
          <dd class="@if($tempurl == '/mine/coupon') active @endif"><a href="/mine/coupon">我的优惠券</a></dd>
        </dl>
        <dl>
          <dt>设置</dt>
          <dd class="@if($tempurl == '/mine/setting') active @endif"><a href="/mine/setting">个人设置</a></dd>
          <dd class="@if($tempurl == '/mine/address') active @endif"><a href="/mine/address">收货地址</a></dd>
          <dd class="@if($tempurl == '/mine/invoice') active @endif"><a href="/mine/invoice">我的发票</a></dd>
          <dd class="@if($tempurl == '/mine/pwd') active @endif"><a href="/mine/pwd">账户安全</a></dd>
          <dd class="@if($tempurl == '/mine/auth') active @endif"><a href="/mine/auth">我的认证</a></dd>
         @if($isGroupUser == 6) <dd class="@if($tempurl == '/mine/mygroup') active @endif"><a href="/mine/mygroup">我的集团</a></dd> @endif
        </dl>
        <dl>
          <dt>客户留言</dt>
          <dd class="@if($tempurl == '/mine/comment') active @endif"><a href="/mine/comment">我的留言</a></dd>
        </dl>
      </div>
      <!-- end menu -->
    </div>
  </div>
</div>
@endsection
