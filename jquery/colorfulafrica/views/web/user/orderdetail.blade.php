@extends('web.user.layouts.main')

@section('user-content')
	<div class="user-container orderdetail">
		<div class="order-status">
			<span>{{trans('index.order_state')}}：
			@if($detail['payState']==1){{trans('index.no_pay')}}
			@elseif($detail['payState']==2){{trans('index.payed')}}
			@elseif($detail['payState']==3){{trans('index.shipped')}}
			@elseif($detail['payState']==4){{trans('index.finished')}}
			@endif
			</span>
			@if($detail['payState']==4)
			<a href="/{{Config('app.locale')}}/user/commentorder/{{$detail['id']}}">{{trans('index.go_comment')}}</a>
			@endif
			@if($detail['payState']==1)
			<a class="go-pay" data-id="{{$detail['id']}}">{{trans('index.go_pay')}}</a>
			@endif
			@if(in_array($detail['payState'], array(2,3,4)))<a class="gray">{{trans('index.apply_refund')}}</a>@endif
		</div>
		<table class="order-info">
			<tr>
				<td>{{trans('index.orderNo')}}：{{$detail['orderNo']}}</td>
				<td>{{trans('index.ordertime')}}：{{$detail['createTime']}}</td>
				<td>{{trans('index.payment')}}：
				@if($detail['payment']==1) {{trans('index.alipay')}}
				@elseif($detail['payment']==2){{trans('index.wechatpay')}}
				@else{{trans('index.union_pay')}}
				@endif
				</td>
			</tr>
			<tr>
				<td>{{trans('index.order_notice')}}： {{$detail['remark']}} </td>
				<td>{{-- 物流方式： --}}</td>
			</tr>
		</table>
		@if($detail['payState']==1)
		<div class="order-progress one">
			<div class="status">
				<div class="txt active" style="padding-left:30px;">{{trans('index.submit_order')}}</div>
				<div class="txt">{{trans('index.payed')}}</div>
				<div class="txt">{{trans('index.shipped')}}</div>
				<div class="txt">{{trans('index.received')}}</div>
			</div>
			<div class="date">
				<div style="padding-left:20px;" class="active">{{$detail['createTime']}}</div>
			</div>
		</div>
		@elseif($detail['payState']==2)
		<div class="order-progress two">
			<div class="status">
				<div class="txt active" style="padding-left:30px;">{{trans('index.submit_order')}}</div>
				<div class="txt">{{trans('index.payed')}}</div>
				<div class="txt">{{trans('index.shipped')}}</div>
				<div class="txt">{{trans('index.received')}}</div>
			</div>
			<div class="date">
				<div style="padding-left:20px;" class="active">{{$detail['createTime']}}</div>
				<div style="padding-left:10px;" class="active">{{$detail['payTime']}}</div>
			</div>
		</div>
		@elseif($detail['payState']==3)
		<div class="order-progress three">
			<div class="status">
				<div class="txt active" style="padding-left:30px;">{{trans('index.submit_order')}}</div>
				<div class="txt">{{trans('index.payed')}}</div>
				<div class="txt">{{trans('index.shipped')}}</div>
				<div class="txt">{{trans('index.received')}}</div>
			</div>
			<div class="date">
				<div style="padding-left:20px;" class="active">{{$detail['createTime']}}</div>
				<div style="padding-left:10px;" class="active">{{$detail['payTime']}}</div>
				<div class="active">{{$detail['shipTime']}}</div>
			</div>
		</div>
		@elseif($detail['payState']==4)
		<div class="order-progress four">
			<div class="status">
				<div class="txt active" style="padding-left:30px;">{{trans('index.submit_order')}}</div>
				<div class="txt">{{trans('index.payed')}}</div>
				<div class="txt">{{trans('index.shipped')}}</div>
				<div class="txt active">{{trans('index.received')}}</div>
			</div>
			<div class="date">
				<div style="padding-left:20px;" class="active">{{$detail['createTime']}}</div>
				<div style="padding-left:10px;" class="active">{{$detail['payTime']}}</div>
				<div class="active">{{$detail['shipTime']}}</div>
				<div style="text-align:left; padding-left:10px;" class="active">{{$detail['receiveTime']}}</div>
			</div>
		</div>
		@endif
		<div class="shipping">
			<div class="title">物流跟踪[<a>收起</a>]</div>
			<hr>
			<div class="detail">
				暂无物流信息
			</div>
			<div class="user-address">
				<i class="coordinate"></i>
				<ul>
					<li>{{trans('index.receiver')}}：{{$detail['receiver']}}</li>
					<li>{{trans('index.receiver_address')}}：{{$detail['provinceName'].$detail['cityName'].$detail['districtName'].$detail['address']}}</li>
					<li>{{trans('index.phone')}}：{{$detail['mobile']}}</li>
				</ul>
			</div>
		</div>

		<ul class="product-list">
		@foreach($detail['detail'] as $good)
			<li>
				<img src="/image/get/{{$good['picKey']}}">
				<div class="info">
					<span>{{$good['number']}}{{trans('index.items')}}</span>
					<div class="title">{{$good['name']}}</div>
					<div class="weight">{{$good['spec']}}</div>
					<div class="price">&yen;<span>{{$good['price']*$good['number']}}</span></div>
				</div>
			</li>
		@endforeach	
		</ul>

		<ul class="total-price">
			<li>{{trans('index.total_price')}}：&yen;<span class="product-price">{{$detail['totalPrice']}}</span></li>
			{{-- <li>运费：&yen;<span class="shipping-price">12.00</span></li> --}}
			<li>{{trans('index.real_pay')}}：<span class="red">&yen;<strong class="fact-price">{{$detail['totalPrice']}}</strong></span></li>
		</ul>
	</div>
@endsection
