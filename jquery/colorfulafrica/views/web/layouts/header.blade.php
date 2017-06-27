<div class="header">
	<div class="content">
		<a class="logo" href="/{{Config::get('app.locale')}}"></a>
		@section('header-menu')
		<ul class="header-menu">
			<li style="padding-left: 20px;"><a href="/{{Config::get('app.locale')}}/index" index>{{trans('index.index')}}</a></li>
			<li><a href="/{{Config::get('app.locale')}}/news" news>{{trans('index.news')}}</a></li>
			<li class="has-sub">
				<div class="trs">
					<a href="javascript:;" strategy>{{trans('index.strategy')}}</a>
					<ul>
						<li><a href="/{{Config::get('app.locale')}}/strategy">{{trans('index.colorfulafrica_strategy')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/food">{{trans('index.colorfulafrica_food')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/partner">{{trans('index.partner')}}</a></li>
					</ul>
				</div>
			</li>
			<li><a href="/{{Config::get('app.locale')}}/walkin" walkin>{{trans('index.walk')}}</a></li>
			<li class="has-sub">
				<div class="trs">
					<a href="javascript:;" store>{{trans('index.store')}}</a>
					<ul>
						<li><a href="/{{Config::get('app.locale')}}/store">{{trans('index.colorfulafrica_store')}}</a></li>
						<li><a offline>{{trans('index.offstore')}}</a></li>
						{{-- <li><a href="/{{Config::get('app.locale')}}/">{{trans('index.offstore')}}</a></li> --}}
					</ul>
				</div>
			</li>
			<li style="padding-left: 15px;"><a href="/{{Config::get('app.locale')}}/aboutus" aboutus>{{trans('index.aboutus')}}</a></li>
		</ul>
		@show
		<div class="header-btn">
			{{-- <a class="weather" href="/{{Config::get('app.locale')}}/index/weather">
				<i class="{{App\Utils\Helpers::getWeatherSmallIcon()[Session::get('weather.code')]}}"></i>
			</a> --}}
			<div style="width:184px;">
				<div class="trs" style="width:184px;">
					@if(isset($_COOKIE['islogin'])&& $_COOKIE['islogin']==1)

					<a href="/{{Config::get('app.locale')}}/user/" class="username">{{Session::get('webUser.uname')}}</a>
					<ul style="width:120px; margin-top: 5px; margin-left: 26px;">
						<li><a href="/{{Config::get('app.locale')}}/user/strategy">{{trans('index.mystrategy')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/food">{{trans('index.myfood')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/line">{{trans('index.myline')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/order">{{trans('index.myorder')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/userinfo">{{trans('index.setting')}}</a></li>
						<li><a class="out">{{trans('index.logout')}}</a></li>
					</ul>

					@else
					<a class="user-reg" style="margin-right:2px;">{{trans('index.register')}}</a>
					<i class="line" style="margin-right:17px;"></i>
					<a class="user-login" style="margin-right:17px;">{{trans('index.login')}}</a>
					@endif
				</div>
			</div>
			@if(isset($_COOKIE['islogin'])&& $_COOKIE['islogin']==1)
			<i class="car"></i>
			@endif
			<i class="exchange-rate-icon"></i>
			{{-- <a class="rate-btn" href="/{{Config::get('app.locale')}}/index/rate">{{trans('index.currency')}}</a> --}}
			<a class="rate-btn" target="_blank"  rel="noopener noreferrer" href="http://www.xe.com/zh-CN/currencyconverter/
">{{trans('index.currency')}}</a>
		  	<?php
$url = $_SERVER['REQUEST_URI'];
$url = $url === '/' ? '/CN' : $url;
$reg = '/^\/[^\/]+(?=($|\/))/';
$lang = Config::get('app.locale') == 'en' ? 'CN' : 'EN';
$lang_url = preg_replace($reg, '/' . strtolower($lang), $url, 1);
?>
			<i class="country-icon @if(Config::get('app.locale')=='en') cn @else en  @endif"></i>
			<a class="country-txt" data-url="{{$lang_url}}">@if(Config::get('app.locale')=='en') CN @else EN @endif</a>
		</div>
	</div>
	<div class="clear"></div>
	@section('index-header')
	<div class="container">
		<div class="input-con">
			<input type="" name="" placeholder="{{trans('index.search_option1')}}" class="mousetrap">
			<a class="index-search search-btn">{{trans('index.search')}}</a>
		</div>
		<ul class="index-menu">
			<li><a href="/{{Config::get('app.locale')}}/index" class="active">{{trans('index.index')}}</a></li>
			<li><a href="/{{Config::get('app.locale')}}/news">{{trans('index.news')}}</a></li>
			<li class="has-sub">
				<a href="javascript:;">{{trans('index.strategy')}}</a>
				<ul>
					<li><a href="/{{Config::get('app.locale')}}/strategy">{{trans('index.colorfulafrica_strategy')}}</a></li>
					<li><a href="/{{Config::get('app.locale')}}/food">{{trans('index.colorfulafrica_food')}}</a></li>
					<li><a href="/{{Config::get('app.locale')}}/partner">{{trans('index.partner')}}</a></li>
				</ul>
			</li>
			<li><a href="/{{Config::get('app.locale')}}/walkin">{{trans('index.walk')}}</a></li>
			<li class="has-sub">
				<a href="javascript:;">{{trans('index.store')}}</a>
				<ul>
					<li><a href="/{{Config::get('app.locale')}}/store">{{trans('index.colorfulafrica_store')}}</a></li>
					<li><a offline>{{trans('index.offstore')}}</a></li>
					{{-- <li><a href="/{{Config::get('app.locale')}}/offline">{{trans('index.offstore')}}</a></li> --}}
				</ul>
			</li>
			<li style="padding-left: 15px;"><a href="/{{Config::get('app.locale')}}/aboutus">{{trans('index.aboutus')}}</a></li>
		</ul>
		<div class="weather">
			<ul>
				<li class="title">{{Session('weather.tmp')}}&deg;</li>
				<li class="city-name">{{Config('app.locale')=='zh'?Session('weather.cityName'):Session('weather.cityNameEn')}}</li>
				<li class="city-temperature">{{Session('weather.temperature')}}</li>
			</ul>
			<i class="{{App\Utils\Helpers::getWeatherIcon()[Session::get('weather.code')]}}" onclick="window.open('/{{Config::get('app.locale')}}/index/weather','_self')"></i>
			{{-- <img src="/dist/img/ah_bar_ic_sun.png"> --}}
		</div>
	</div>
	<div class="clear"></div>
	@show

	@section('banner')
	@show

</div>