@extends('web.layouts.main')

@section('header')
@endsection

@section('content')
<div class="car-header">
	<div class="content car">
		<a href="/{{Config::get('app.locale')}}/index" class="logo"><i class="logo"></i></a>
		<span>{{trans('index.currency')}}</span>
		<div class="header-btn">
			<a href="/{{Config::get('app.locale')}}/user/userinfo">{{Session::get('webUser.uname')}}</a>
			@if(isset($_COOKIE['islogin'])&& $_COOKIE['islogin']==1)
			<i class="car black" onclick="window.open('/{{Config::get('app.locale')}}/user/car','_self')"></i>
			<span>{{trans('index.car')}}</span>
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
</div>
<div class="container rate">
	<table width="470">
		<tr>
			<td>{{trans('index.cny')}}</td>
			<td><input type="text" name="rmb"></td>
		</tr>
		<tr>
			<td>国家货币</td>
			<td><select name="country">
			@foreach($data as $currency)
				<option value="{{$currency['currencyUnit']}}">{{$currency['currencyName'].$currency['currencyUnit']}}</option>
			@endforeach	
			</select></td>
		</tr>
		<tr>
			<td></td>
			<td><a class="exchange">{{trans('index.exchange')}}</a></td>
		</tr>
		<tr>
			<td></td>
			<td class="dis"></td>
		</tr>
	</table>
</div>
@endsection

@section('footer')
  @include('web.user.layouts.footer')
@endsection