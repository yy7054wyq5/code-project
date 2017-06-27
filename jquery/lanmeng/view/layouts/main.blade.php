<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="loongjoy" />
  <meta name="description" content="蓝网" />
  <meta name="keywords" content="蓝网，蓝网平台，蓝网汽车， lemauto，蓝网汽车广告，蓝网物料，蓝网汽车物料，创意物料，汽车，4s店，礼品，展厅物料，家具，自驾游，经销商，大众，案例，展架，吊旗，巨鳗，立牌，蓝梦物料，蓝梦广告物料，上海大众物料订购，上海大众蓝网" />
  <meta name="description" content="蓝网业务涵盖汽车行业4S店营销层面相关策略策划，创意设计，宣传品，展具和礼品的定制和销售，以及提供汽车周边产品等资源的整合服务支持。"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta http-equiv="x-dns-prefetch-control" content="on" />
  <meta name="baidu-site-verification" content="QET8caGmlt" />
  <title>@yield('title','蓝网汽车终端营销整合服务平台-中国领先的B2B汽车终端营销整合服务平台')</title>
  <link rel="icon" href="/favicon.ico"  type="image/x-icon"/>
  <link rel="dns-prefetch" href="http://static.bshare.cn" />
  <link rel="dns-prefetch" href="http://www.lemauto.cn" />
  <link rel="dns-prefetch" href="http://www.baidu.com" />
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/loongjoy.css">
  @yield('styles')
  <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="/js/js.cookie.js"></script>
  <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?d56bba6bf3c28cf93142896f846bc6f7";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
  </script>
  @yield('header-scripts')
  <!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/loongjoyIE.css">
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
 <!-- 头部 -->
  @section('header')
    @include('layouts.header')
  @show

 <!-- 中部 -->
  @yield('content')

  <!-- 底部 -->
  @section('footer')
    @include('layouts.footer')
  @show<!-- 客服 -->
  <ul class="contact-us">
    <li class="contact-left"><a class="open-btn" role="button"></a><a class="close-btn" role="button"></a></li>
    <li class="contact-right">
          <div class="girl-top"></div>
          <div class="contact-girl">
              <table>
                <tr><td class="blue-font">我们的在线时间</td></tr>
                <tr><td class="red-font"><img src="/img/float-contackus-clock.png"/>09:00～17:30</td></tr>
              </table>
              @if(isset($service[0]))
              @foreach($service as $value)
              <a role="button" href="http://wpa.qq.com/msgrd?v=1&uin={{ $value->qq }}" target="_blank">{{ $value->name }}</a>
              @endforeach
              @endif
          </div>
          <div class="girl-bottom"></div>
    </li>
  </ul>
   {{-- 模态框 --}}
  @section('modal')
  @show
</body>
</html>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/md5.js"></script>
<script type="text/javascript" src="/js/loongjoy.js"></script>
@yield('footer-scripts')
