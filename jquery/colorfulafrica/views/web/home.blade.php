@extends('web.layouts.main')

@section('header')
@endsection

@section('content')
	<?php
		$url = $_SERVER['REQUEST_URI'];
		$url = $url === '/' ? '/CN' : $url;
		$reg = '/^\/[^\/]+(?=($|\/))/';
		$lang = Config::get('app.locale') == 'en' ? 'CN' : 'EN';
		$lang_url = preg_replace($reg, '/'.strtolower($lang), $url, 1);
	?>
<div class="home-body">
	<div class="top">
		<div class="home-wrap">
			<a class="logo" href="/{{Config('app.locale')}}/index"></a>
			<div class="top-btn">
				<a class="sina" href="http://weibo.com/u/5894161757"></a>
				<a class="wechat"></a>
				<i class="country-icon @if(Config::get('app.locale')=='en') cn @else en @endif"></i>
				<span class="country-txt" data-url="{{$lang_url}}">@if(Config::get('app.locale')=='en') CN @else EN @endif</span>
				<div class="wechat-code">
					<img src="/dist/img/code.png">
					<span>微信扫一扫</span>
					{{-- wechat_scan --}}
				</div>
			</div>
		</div>
	</div>
	<div class="home-wrap content">
		<div class="see-height">
			<p>宽度：<span class="_winodw_width"></span></p>
			<p>高度：<span class="_winodw_height"></span></p>
		</div>
		<div class="bottom-logo @if(Config::get('app.locale')=='zh') cn @else en @endif"></div>
		<div class="icon-group">
			<div class="item @if(Config::get('app.locale')=='zh') cn @else en @endif strategy">
				<div class="img-item">
					<img src="/dist/img/home/rhinoceros-s.png" data-src="/dist/img/home/rhinoceros-l.png">
				</div>
				<a href="/{{Config('app.locale')}}/strategy"></a>
			</div>
			<div class="item @if(Config::get('app.locale')=='zh') cn @else en @endif news">
				<div class="img-item">
					<img src="/dist/img/home/leopard-s.png" data-src="/dist/img/home/leopard-l.png">
				</div>
				<a href="/{{Config('app.locale')}}/news"></a>
			</div>
			<div class="item @if(Config::get('app.locale')=='zh') cn @else en @endif store">
				<div class="img-item">
					<img src="/dist/img/home/elephant-s.png" data-src="/dist/img/home/elephant-l.png">
				</div>
				<a href="/{{Config('app.locale')}}/store"></a>
			</div>
			<div class="item @if(Config::get('app.locale')=='zh') cn @else en @endif walkin">
				<div class="img-item">
					<img src="/dist/img/home/buffalo-s.png" data-src="/dist/img/home/buffalo-l.png">
				</div>
				<a href="/{{Config('app.locale')}}/walkin"></a>
			</div>
			<div class="item @if(Config::get('app.locale')=='zh') cn @else en @endif aboutus">
				<div class="img-item">
					<img src="/dist/img/home/lion-s.png" data-src="/dist/img/home/lion-l.png">
				</div>
				<a href="/{{Config('app.locale')}}/aboutus"></a>
			</div>
		</div>
		<a href="/{{Config('app.locale')}}/index" class="arrow"></a>
	</div>
</div>
<img src="/dist/img/home/home.jpg" class="tmp-bg">
@endsection

@section('footer')
@endsection

@section('footer-scripts')
	@parent
	{{-- 替换图片 --}}
	<script type="text/javascript">
	$(function() {
		function exchangeImg($obj) {
			temSrc = $obj.attr('src');
			$obj.attr('src', $obj.data('src'));
			$obj.data('src', temSrc);
		}

		//pc
		function pcLayout() {
			//获取最小高度
			var minHeight = $(window).height()-$('.top').height();
			minHeight = $(window).height()-$('.top').height();
			$('.home-wrap.content,.icon-group').css('min-height',minHeight);
			$('.arrow').css('left', ($('.home-wrap.content').width()-$('.arrow').width())/2 );
		}

		//phone
		// 551为背景等比例被缩放高度
		function phoneLayout() {
			//var h = $('.tmp-bg').height();
			$('.home-body').height(551);
			$('.home-wrap,.icon-group').height(551-$('.top').height());
			if($('.isOn').hasClass('isOn')) return;
			$('body').height($(window).height()).prepend('<div class="isOn" style="height:'+($('body').height()-$('.home-body').height())/2+'px"></div>');
		}

		//查看高度
		var url = location.href;
		if(url.indexOf('seeheight')>-1){
			$('.see-height').show();
			$('._winodw_width').text($(window).width());
			$('._winodw_height').text($(window).height());
		}

		//横竖
		window.addEventListener('orientationchange', function(event){
			if ( window.orientation == 180 || window.orientation==0 ) {
				location.reload();
			}
			if( window.orientation == 90 || window.orientation == -90 ) {
				location.reload();
			}
		});

		var temSrc = '';
		$('body,html').width('auto').css({
			background: '#000',
		});

		//定位
		if($(window).width()<$(window).height()){
			phoneLayout();
		}else{
			pcLayout();
		}
		//定位
		$(window).resize(function () {
			if($(window).width()<$(window).height()){
				phoneLayout();
			}else{
				pcLayout();
			}
		});

		//点击微信
		$('.wechat').on('click',function(event) {
			$('.wechat-code').slideDown();
			setTimeout(function () {
				if($('.wechat-code').css('opacity')=='1'){
					$('.wechat-code').slideUp();
				}
			},10000);
		});
		$('.wechat-code').on('click',function(event) {
			$(this).slideUp();
		});

		//鼠标点动物
		$('.img-item>img').mouseenter(function(event) {
			//exchangeImg($(this));
			$(this).toggleClass('on');
		})
		.mouseleave(function(event) {
			// exchangeImg($(this));
			$(this).toggleClass('on');
		});

		//箭头
		$('.arrow').css('left', ($('.home-wrap.content').width()-$('.arrow').width())/2 );
		var arrowanimation = setInterval(function () {
			$('.arrow').toggleClass('on');
		},1000);
	});
	</script>
@endsection