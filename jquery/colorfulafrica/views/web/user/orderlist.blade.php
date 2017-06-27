@extends('web.user.layouts.main')

@section('user-content')
	<div class="user-container order">
		<div class="user-tab">
			<a class="active" data-tag="0" data-currentpage="1">{{trans('index.all')}}</a>
			<a data-tag="1" data-currentpage="1">{{trans('index.no_pay')}}（<span>{{$num['noPay']}}</span>）</a>
			<a data-tag="2" data-currentpage="1">{{trans('index.payed')}}（<span>{{$num['payed']}}</span>）</a>
			<a data-tag="3" data-currentpage="1">{{trans('index.shipped')}}（<span>{{$num['shiped']}}</span>）</a>
			<a data-tag="4" data-currentpage="1">{{trans('index.finished')}}</a>
		</div>
		<ul class="list active order" data-tag="0">
			@foreach($orders as $key=>$order)
			@if($key<6)
			<li data-orderid="{{$order['id']}}" >
				<div class="info">
					<span>{{$order['createTime']}}</span>
					<span class="order-number"><a href="/{{Config('app.locale')}}/user/orderdetail/{{$order['id']}}">{{trans('index.orderNo')}}：{{$order['orderNo']}}</a></span>
					@if($order['payState']==1)<a>{{trans('index.no_pay')}}</a>
					@elseif($order['payState']==2)<a>{{trans('index.payed')}}</a>
					@elseif($order['payState']==3)<a>{{trans('index.shipped')}}</a>
					@elseif($order['payState']==4)<a>{{trans('index.finished')}}</a>
					@endif
				</div>
				<div class="order-content">
					<a class="img-link" href="/{{Config('app.locale')}}/user/orderdetail/{{$order['id']}}"><img src="/image/get/{{$order['orderdetail']['picKey']}}"></a>
					<ul>
						<li class="title">{{$order['orderdetail']['name']}}</li>
						<li>{{$order['orderdetail']['spec']}}</li>
						<li>x{{$order['orderdetail']['number']}}</li>
					</ul>
					<ul class="price-btn">
						@if($order['payState']==3)<li><a class="receive-good">{{trans('index.confirm_receive_good')}}</a></li>
						@elseif($order['payState']==1)<li><a class="go-pay">{{trans('index.go_pay')}}</a></li>
						@elseif($order['payState']==2)<li></li>
						@elseif($order['payState']==4)<li><a class="go-comment" href="/{{Config('app.locale')}}/user/commentorder/{{$order['id']}}" >{{trans('index.go_comment')}}</a></li>
						@endif
						<li>&yen;<span>{{$order['price']}}</span></span>
					</ul>
				</div>
			</li>
			@endif
			@endforeach
		</ul>
		<ul class="list order" data-tag="1"></ul>
		{{-- 			<li onclick="window.location.href='orderdetail'">
						<div class="info">
							<span>21-12-12 12:12:12</span>
							<span class="order-number">订单编号：2121212</span>
							<a>未支付</a>
						</div>
						<div class="order-content">
							<img src="http://placehold.it/96x96">
							<ul>
								<li class="title">南得很大很大距离</li>
								<li>1000g</li>
								<li>x3</li>
							</ul>
							<ul class="price-btn">
								<li><a>去支付</a></li>
								<li>&yen;<span>290.00</span></span>
							</ul>
						</div>
					</li> --}}
		<ul class="list order" data-tag="2"></ul>
		{{-- 			<li onclick="window.location.href='orderdetail'">
						<div class="info">
							<span>21-12-12 12:12:12</span>
							<span class="order-number">订单编号：2121212</span>
							<a>已支付</a>
						</div>
						<div class="order-content">
							<img src="http://placehold.it/96x96">
							<ul>
								<li class="title">南得很大很大距离</li>
								<li>1000g</li>
								<li>x3</li>
							</ul>
							<ul class="price-btn">
								<li></li>
								<li>&yen;<span>290.00</span></span>
							</ul>
						</div>
					</li> --}}
		<ul class="list order" data-tag="3"></ul>
		{{-- 			<li onclick="window.location.href='orderdetail'">
						<div class="info">
							<span>21-12-12 12:12:12</span>
							<span class="order-number">订单编号：2121212</span>
							<a>已发货</a>
						</div>
						<div class="order-content">
							<img src="http://placehold.it/96x96">
							<ul>
								<li class="title">南得很大很大距离</li>
								<li>1000g</li>
								<li>x3</li>
							</ul>
							<ul class="price-btn">
								<li><a>确认收货</a></li>
								<li>&yen;<span>290.00</span></span>
							</ul>
						</div>
					</li> --}}
		<ul class="list order" data-tag="4"></ul>
		{{-- 			<li onclick="window.location.href='orderdetail'">
						<div class="info">
							<span>21-12-12 12:12:12</span>
							<span class="order-number">订单编号：2121212</span>
							<a>已完成</a>
						</div>
						<div class="order-content">
							<img src="http://placehold.it/96x96">
							<ul>
								<li class="title">南得很大很大距离</li>
								<li>1000g</li>
								<li>x3</li>
							</ul>
							<ul class="price-btn">
								<li><a>去评价</a></li>
								<li>&yen;<span>290.00</span></span>
							</ul>
						</div>
					</li> --}}
		<div class="loading-more">{{trans('index.load_more')}}</div>
		<div class="no-product">{{trans('index.no_content')}}</div>
	</div>
@endsection
