@extends('web.layouts.main')

@section('header')
@endsection

@section('content')
<div class="car-header">
	<div class="content car">
		<a href="/{{Config::get('app.locale')}}/index" class="logo"><i class="logo"></i></a>
		<span>{{trans('index.submit_order')}}</span>
		<div class="header-btn">
			<a href="/{{Config::get('app.locale')}}/user/userinfo">{{Session::get('webUser.uname')}}</a>
			<i class="car black" onclick="window.open('{{Config('app.locale')}}/user/car','_self')"></i>
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
<div class="container confirm">
	<h3>{{trans('index.receiver_address')}}</h3>
	<div class="line"></div>
	<div class="address-box">
	@foreach($data['address'] as $address)
		<div class="item @if($address['isDefault'])active @endif" data-id="{{$address['id']}}" data-object="{{json_encode($address)}}">
			<div class="name">{{$address['name']}}</div>
			@if($address['isDefault']==1)<a class="default">{{trans('index.defualt_address')}}</a> @else<a class="default">{{trans('index.set_defualt')}}</a>@endif
			<div class="address">{{$address['detail']}}</div>
			<div class="mobile">{{$address['mobile']}}</div>
			<div class="item-btn">
				<a class="edit">{{trans('index.edit')}}</a>
			</div>
			<i class="chose"></i>
		</div>
	@endforeach	
		<div class="item add-address"></div>
		<div class="slideup">
			<a class="active">
				<span>展开</span>
				<i></i>
			</a>
		</div>
	</div>
	<h3>{{trans('index.payment')}}</h3>
	<div class="line"></div>
	<div class="pay-way">
		<a class="active" data-id="1">{{trans('index.alipay')}}</a>
		<a data-id="2">{{trans('index.wechatpay')}}</a>
		<a data-id="3">{{trans('index.union_pay')}}</a>
	</div>
	<h3>{{trans('index.good_list')}}</h3>
	<div class="line"></div>
	<ul class="list">
		<li class="title">
			<div class="product">&nbsp;</div>
			<div class="product-perprice">{{trans('index.per_price')}}</div>
			<div class="product-perprice">{{trans('index.number')}}</div>
			<div class="product-total">{{trans('index.subcount')}}</div>
		</li>
		@foreach($data['good'] as $good)
		<li data-id="{{$good['id']}}">
			<div class="product">
				<img src="/image/get/{{$good['picKey']}}" alt="96x96">
				<span class="name">
					<table>
						<tr>
							<td>{{$good['name']}}</td>
						</tr>
					</table>
				</span>
				<span class="heavy">{{$good['spec']}}</span>
			</div>
			<div class="product-perprice">
				&yen;<span>{{$good['price']}}</span>
			</div>
			<div class="num">
					{{$good['number']}}
			</div>
			<div class="product-total">
				&yen;<span>{{$good['subtotalPrice']}}</span>
			</div>
		</li>
		@endforeach
	</ul>
	<div class="bak">
		<div style="width:40px;">{{trans('index.notice')}}</div>
		<textarea name="notice"></textarea>
		<div class="order-info">
			{{-- <div >
				<span>配送方式：快递运输</span>
				<span>&yen;10.00</span>
			</div> --}}
			<div>
				<span>{{trans('index.order_totalPrice')}}</span>
				<span class="big">&yen;{{$data['totalPrice']}}</span>
			</div>
		</div>
	</div>
	<div class="confirm-order">
		<div style="padding-right:20px;margin-bottom:10px;">{{trans('index.subcount')}}:&nbsp;{{$data['totalNum']}}&nbsp;{{trans('index.items')}}，{{trans('index.total_price')}}：&yen;{{$data['totalPrice']}}</div>
		{{-- <div style="padding-right:20px;">运费：&yen;10</div> --}}
		<div class="bottom">
			<a class="confirm-order-btn">{{trans('index.submit_order')}}</a>
			<div>{{trans('index.need_pay')}}：<span>&yen;<span class="fact-price">{{$data['totalPrice']}}</span></span></div> 
		</div>
	</div>
</div>

@endsection

@section('footer')
  @include('web.user.layouts.footer')
@endsection