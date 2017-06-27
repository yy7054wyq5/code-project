<!DOCTYPE html>
<html lang="{{Config('app.locale')}}">
<head>
<meta charset="UTF-8">
<meta name="author" content="loongjoy" />
<meta name="description" content="{{trans('index.colorfulafrica')}}" />
<meta name="keywords" content="{{trans('index.colorfulafrica')}}" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="x-dns-prefetch-control" content="on" />
<meta name="baidu-site-verification" content="QET8caGmlt" />
<title>@yield('title',trans('index.colorfulafrica'))</title>
<link rel="icon" href="/favicon.ico"  type="image/x-icon"/>
<link rel="dns-prefetch" href="http://static.bshare.cn" />
<link rel="dns-prefetch" href="http://www.baidu.com" />
<link rel="stylesheet" href="/dist/lib/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/dist/css/loongjoy.min.css">
<link rel="stylesheet" href="/dist/css/main.min.css">
<link rel="stylesheet" type="text/css" href="/dist/lib/jQuery-File-Upload/css/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="/dist/lib/jQuery-File-Upload/css/jquery.fileupload-ui.css">
@yield('styles')
<script type="text/javascript" src="/dist/lib/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="/dist/lib/jquery_lazyload/jquery.lazyload.js"></script>
{{-- <script type="text/javascript" src="/dist/lib/uploadify/jquery.uploadify.min.js"></script> --}}
<script type="text/javascript" src="/dist/lib/js-cookie/src/js.cookie.js"></script>
<script type="text/javascript" src="/dist/lib/mousetrap/mousetrap.min.js"></script>
<script type="text/javascript" src="/dist/lib/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/dist/lib/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/dist/lib/jQuery-File-Upload/js/jquery.fileupload.js"></script>
@yield('header-scripts')
<script type="text/javascript" src="/dist/js/loongjoy.js"></script>
<script type="text/javascript" src="/dist/js/main.js"></script>
<!--[if lt IE 9]>
  <link rel="stylesheet" href="/dist/css/assist.min.css">
  <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
  @section('header')
    @include('web.layouts.header')
  @show

  @yield('content')
  
  @section('footer')
    @include('web.layouts.footer')
  @show
</body>
</html>

@yield('footer-scripts')
