<div class="header user">
	@section('user-header')
	<div class="content">
		<a class="logo" href="/{{Config::get('app.locale')}}"></a>
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
						{{-- <li><a href="/{{Config::get('app.locale')}}/offline">{{trans('index.offstore')}}</a></li> --}}
					</ul>
				</div>
			</li>
			<li><a href="/{{Config::get('app.locale')}}/aboutus" aboutus>{{trans('index.aboutus')}}</a></li>
{{-- 			<li class="user has-sub">
			</li> --}}
		</ul>
		<div class="header-btn">
			<div style="width:145px; margin-right: 40px;">
				<div class="trs" style="width: 145px; ">
	{{-- 					<a href="javascript:;" >{{Session::get('webUser.uname')}}</a>
					<ul>
						<li><a href="/{{Config::get('app.locale')}}/user/strategy">{{trans('index.mystrategy')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/food">{{trans('index.myfood')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/line">{{trans('index.myline')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/order">{{trans('index.myorder')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/userinfo">{{trans('index.setting')}}</a></li>
						<li><a class="out">{{trans('index.logout')}}</a></li>
					</ul> --}}
					@if(isset($_COOKIE['islogin'])&& $_COOKIE['islogin']==1)
					<a href="/{{Config::get('app.locale')}}/user/" class="username">{{Session::get('webUser.uname')}}</a>
					<ul style="float: right;">
						<li><a href="/{{Config::get('app.locale')}}/user/strategy">{{trans('index.mystrategy')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/food">{{trans('index.myfood')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/line">{{trans('index.myline')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/order">{{trans('index.myorder')}}</a></li>
						<li><a href="/{{Config::get('app.locale')}}/user/userinfo">{{trans('index.setting')}}</a></li>
						<li><a class="out">{{trans('index.logout')}}</a></li>
					</ul>
					@else
					<a class="user-login" style="margin-right:2px;">{{trans('index.login')}}</a>
					<i class="line" style="margin-right:2px;"></i>
					<a class="user-reg" style="margin-right:2px;">{{trans('index.register')}}</a>
					@endif
				</div>
			</div>
			@if(isset($_COOKIE['islogin'])&& $_COOKIE['islogin']==1)
			<i class="car"></i>
			<a href="/{{Config::get('app.locale')}}/user/car">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{trans('index.car')}}</a>
			@endif
			  <?php
	          $url = $_SERVER['REQUEST_URI'];
	          $url = $url === '/' ? '/CN' : $url;
	          $reg = '/^\/[^\/]+(?=($|\/))/';
	          $lang = Config::get('app.locale') == 'en' ? 'CN' : 'EN';
	          $lang_url = preg_replace($reg, '/'.strtolower($lang), $url, 1);
	          ?>
				<i class="country-icon @if(Config::get('app.locale')=='en') cn @else en  @endif"></i>
				<a class="country-txt" data-url="{{$lang_url}}">@if(Config::get('app.locale')=='en') CN @else EN @endif</a>
			</div>
	</div>
	@show

	@section('index-header')
	@endsection

	@section('banner')
	<div class="top">
		<div class="info">
			<img src="/image/get/{{Session::get('webUser.userIcon')}}" alt="113x113">
			<i id="camera"></i>
			<input id="fileupload" type="file" name="files">
			<div class="progress-bar"></div>
			<div class="name">
				<span class="txt">{{Session::get('webUser.uname')}}</span>
				@if(Session::get('webUser.sex')==0)
				<i class="woman"></i>
					@else
					<i class="man"></i>
				@endif
			</div>
		</div>
		<div class="menu">
			<a class="strategy" href="/{{Config::get('app.locale')}}/user/strategy">
				<i></i>
				<span>{{trans('index.mystrategy')}}</span>
			</a>
			<a class="food" href="/{{Config::get('app.locale')}}/user/food">
				<i></i>
				<span>{{trans('index.myfood')}}</span>
			</a>
			<a class="line" href="/{{Config::get('app.locale')}}/user/line">
				<i></i>
				<span>{{trans('index.myline')}}</span>
			</a>
			<a class="order" href="/{{Config::get('app.locale')}}/user/order">
				<i></i>
				<span>{{trans('index.myorder')}}</span>
			</a>
			<a class="set" href="/{{Config::get('app.locale')}}/user/userinfo">
				<i></i>
				<span>{{trans('index.setting')}}</span>
			</a>
		</div>
	</div>
	@show

	@yield('user-content')
</div>