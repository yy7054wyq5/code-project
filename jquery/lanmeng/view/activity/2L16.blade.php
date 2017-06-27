<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="loongjoy"/>
<meta name="description" content="客户公司描述"/>
<meta name="keywords" content="蓝网，蓝网平台，蓝网汽车， lemauto，蓝网汽车广告，蓝网物料，蓝网汽车物料，创意物料，汽车，4s店，礼品，展厅物料，家具，自驾游，经销商，大众，案例，展架，吊旗，巨鳗，立牌，蓝梦物料，蓝梦广告物料，上海大众物料订购，上海大众蓝网"/>
<meta name="robots" content="all,index,follow"/>
<meta name="baidu-site-verification" content="QET8caGmlt" />
<link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon"/>
<title>蓝网汽车终端营销整合服务平台-中国领先的B2B汽车终端营销整合服务平台</title>
<link rel="stylesheet" type="text/css" href="/css/last.css"/>
<style type="text/css">
    .jj1 a{
      display: block;
      float: left;
      width: 330px;
      height: 132px;
    }
    .clear{
      clear: both;
      width: 100%;
      height: 1px;
    }
</style>
<script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?d56bba6bf3c28cf93142896f846bc6f7";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
  </script>
</head>
<body style="background:url({{ $backurl }}) top center no-repeat;background-size: cover;">
<div class="ban_zq">
</div>
<div class="main3">
  <div class="jj1" >
    <a href="{{ $top ? $top[0] : '' }}" target="_blank"></a>
    <a href="{{ $top ? $top[1] : '' }}" target="_blank"></a>
    <a href="{{ $top ? $top[2] : '' }}" target="_blank"></a>
  </div>
  <div class="clear"></div>
  <div class="jg_50">
  </div>
  <div class="bt_zq">
    <!-- <img src="http://www.lemauto.cn/uploads/20151029/20151029141432747.png"> -->
  </div>
  <div class="jg_50">
  </div>
  <div class="lm11">
    <a href="javascript:void(0)" class="x1" id="B101" onmouseover="secBlue(1);">{{ isset($type[0]) ? $type[0]['name'] : '' }}</a>
    <a href="javascript:void(0)" class="x2" id="B102" onmouseover="secBlue(2);">{{ isset($type[1]) ? $type[1]['name'] : '' }}</a>
    <a href="javascript:void(0)" class="x2" id="B103" onmouseover="secBlue(3);">{{ isset($type[2]) ? $type[2]['name'] : '' }}</a>
    <a href="javascript:void(0)" class="x2" id="B104" onmouseover="secBlue(4);">{{ isset($type[3]) ? $type[3]['name'] : '' }}</a>
  </div>
  <div class="lb_zq">
    <ul style="display: block;" id="tb_B101">
      @if(isset($content[1]))
      @foreach($content[1] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <ul style="display: none;" id="tb_B102">
      @if(isset($content[2]))
      @foreach($content[2] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <ul style="display: none;" id="tb_B103">
      @if(isset($content[3]))
      @foreach($content[3] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <ul style="display: none;" id="tb_B104">
      @if(isset($content[4]))
      @foreach($content[4] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <div class="clear">
    </div>
  </div>
  <div class="bt_zq">
    <!-- <img src="/uploads/20151029/20151029141440625.png"> -->
  </div>
  <div class="jg_50">
  </div>
  <div class="lm11">
    <a href="javascript:void(0)" class="x1" id="C101" onmouseover="secClue(1);">{{ isset($type[4]) ? $type[4]['name'] : '' }}</a>
    <a href="javascript:void(0)" class="x2" id="C102" onmouseover="secClue(2);">{{ isset($type[5]) ? $type[5]['name'] : '' }}</a>
    <a href="javascript:void(0)" class="x2" id="C103" onmouseover="secClue(3);">{{ isset($type[6]) ? $type[6]['name'] : '' }}</a>
    <a href="javascript:void(0)" class="x2" id="C104" onmouseover="secClue(4);">{{ isset($type[7]) ? $type[7]['name'] : '' }}</a>
  </div>
  <div class="lb_zq">
    <ul style="display: block;" id="tb_C101">
      @if(isset($content[5]))
      @foreach($content[5] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <ul style="display: none;" id="tb_C102">
      @if(isset($content[6]))
      @foreach($content[6] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <ul style="display: none;" id="tb_C103">
      @if(isset($content[7]))
      @foreach($content[7] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <ul style="display: none;" id="tb_C104">
      @if(isset($content[8]))
      @foreach($content[8] as $value)
      <li>
      <a href="{{ $value['url'] }}" target="_blank">
      <img src="{{ $value['imageurl'] }}">
      <p class="p_1">{{ $value['title'] }}</p>
      <p class="p_2">
        {{ $value['price'] ? '￥'.$value['price'] : '' }}<s>{{ $value['oldprice'] ? '￥'.$value['oldprice'] : '' }}</s>
      </p>
      </a>
      </li>
      @endforeach
      @endif
    </ul>
    <div class="clear">
    </div>
  </div>
</div>
<script language="JavaScript" type="text/javascript">
    function secBlue(n) {
        for (i = 1; i < 5; i++) {
            eval("document.getElementById('B10" + i + "').className='x2'");
        }
        eval("document.getElementById('B10" + n + "').className='x1'");
        for (i = 1; i < 5; i++) {
            eval("ele_hide = document.getElementById('tb_B10" + i + "')");
            ele_hide.style.display = "none";
        }
        eval("ele_play = document.getElementById('tb_B10" + n + "')");
        ele_play.style.display = "block";
    }
    function secClue(n) {
        for (i = 1; i < 5; i++) {
            eval("document.getElementById('C10" + i + "').className='x2'");
        }
        eval("document.getElementById('C10" + n + "').className='x1'");
        for (i = 1; i < 5; i++) {
            eval("ele_hide = document.getElementById('tb_C10" + i + "')");
            ele_hide.style.display = "none";
        }
        eval("ele_play = document.getElementById('tb_C10" + n + "')");
        ele_play.style.display = "block";
    }
</script>
</body>
</html>