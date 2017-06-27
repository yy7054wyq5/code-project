@extends('web.layouts.main')

@section('header')
@endsection

@section('content')
<div class="car-header">
	<div class="content car">
		<a href="/{{Config::get('app.locale')}}/index" class="logo"><i class="logo"></i></a>
		<span>{{trans('index.car')}}</span>
		<div class="header-btn">
			<a href="/{{Config::get('app.locale')}}/user/userinfo">{{Session::get('webUser.uname')}}</a>
			<i class="car black" onclick="window.open('/user/car','_self')"></i>
			<span>{{trans('index.car')}}</span>
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
<div class="container car">
	<h3>{{trans('index.all')}}（{{count($carGoods)}}）</h3>
	<table>
		<thead>
			<tr>
				<td width="500" style="padding-left: 20px;">{{trans('index.good')}}</td>
				<td width="180">{{trans('index.per_price')}}</td>
				<td width="180">{{trans('index.number')}}</td>
				<td width="180">{{trans('index.subcount')}}</td>
				<td>{{trans('index.select_all')}}<input type="checkbox" class="chose-all"></td>
			</tr>
		</thead>
	</table>
	<ul class="car-list">
		@if($carGoods)
		@foreach($carGoods as $good)
		<li data-id="{{$good['id']}}">
			<table>
				<tbody>
					<tr>
						<td class="product" width="470">
							<img src="/image/get/{{$good['picKey']}}" alt="96x96">
							<span class="name">
								<table>
									<tr>
										<td>{{$good['name']}}</td>
									</tr>
								</table>
							</span>
							<span class="heavy">
								<table>
									<tr>
										<td>{{$good['spec']}}</td>
									</tr>
								</table>
							</span>
						</td>
						<td class="product-perprice" width="160">
							&yen;<span>{{$good['price']}}</span>
						</td>
						<td class="num" width="110">
							<input type="text" name="num" value="{{$good['number']}}">
							<span class="add">+</span>
							<span class="cut">-</span>
						</td>
						<td class="product-total" width="275">
							&yen;<span>{{$good['price']*$good['number']}}</span>
						</td>
						<td>
							<i class="delete" data-id="{{$good['id']}}"></i>
						</td>
					</tr>
				</tbody>
			</table>
			<i class="chose"></i>
		</li>
		@endforeach
		@endif
	</ul>
	<div class="car-bottom">
		<div class="chosed-product">{{trans('index.selected_good')}}<span class="car-num">0</span>{{trans('index.items')}}</div>
		<div class="bottom-btn">
			<i class="delete"></i>
			<span>{{trans('index.select_all')}}</span>
			<input type="checkbox" class="chose-all">
		</div>
		<div class="clear"></div>
		<div class="car-total">
			<span>{{trans('index.total_count')}}</span>
			<span class="car-price">&yen;<span>0</span></span>
			<a class="confirm">{{trans('index.checkout')}}</a>
		</div>
	</div>
</div>
@endsection

@section('footer')
  @include('web.user.layouts.footer')
@endsection