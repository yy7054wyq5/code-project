@extends('web.user.layouts.main')

@section('banner')
@endsection

@section('user-content')
<div style="height: 10px;width: 100%;"></div>
<div class="wrap">
	<div class="container search">
		<div class="search-con">
			<input type="text" name="" value="{{$data['keyword']}}" class="mousetrap">
			<a class="search-btn">{{trans('index.search')}}</a>
		</div>
		<div class="search-tab">
			<a class="all active" data-tag="all" data-id="0">{{trans('index.all')}}<span>（<span>{{$data['num']}}</span>）</span></a>
			<a class="line" data-tag="line"  data-id="1">{{trans('index.line')}}<span>（<span>{{count($data['line'])}}</span>）</span></a>
			<a class="strategy" data-tag="strategy"  data-id="2">{{trans('index.strategy')}}<span>（<span>{{count($data['travel'])}}</span>）</span></a>
			<a class="food" data-tag="food"  data-id="3">{{trans('index.food')}}<span>（<span>{{count($data['food'])}}</span>）</span></a>
			<a class="store" data-tag="store"  data-id="4">{{trans('index.good')}}<span>（<span>{{count($data['goods'])}}</span>）</span></a>
		</div>
		<div class="con line">
		@if($data['line'])
			<h2>{{$data['keyword']}}热门线路</h2>
			<ul>
			@foreach($data['line'] as $line)
				<li>
					<img src="/image/get/{{$line['picKey']}}" alt="320x230">
					<a onclick="window.open('/{{Config::get('app.locale')}}/walkin/detail/{{$line['id']}}','_self')">
						<h5>{{$line['name']}}</h5>
						<p>{{$line['summary']}}</p>
					</a>
				</li>
			@endforeach	
			</ul>
			@endif
		</div>
	
		<div class="con strategy">
		@if($data['travel'])
			<h2>{{$data['keyword']}}游记</h2>
			<ul>
			@foreach($data['travel'] as $travel)
				<li>
					<img src="/image/get/{{$travel['picKey']}}" alt="240x172">
					<a onclick="window.open('/{{Config::get('app.locale')}}/strategy/detail/{{$travel['id']}}','_self')">
						<h5>{{$travel['name']}}</h5>
						<p>{{$travel['summary']}}</p>
					</a>
				</li>
			@endforeach	
			</ul>
			@endif
		</div>
		<div class="con food">
		@if($data['food'])
			<h2>{{$data['keyword']}}美食</h2>
			@foreach($data['food'] as $food)
			<dl>
				<dt><img src="/image/get/{{$food['picKey']}}" alt="172x172"></dt>
				<dd><a onclick="window.open('/{{Config::get('app.locale')}}/food/detail/{{$food['id']}}','_self')">{{$food['name']}}</a></dd>
			</dl>
			@endforeach
			@endif
		</div>
		<div class="con store">
		@if($data['goods'])
			<h2>{{$data['keyword']}}商品</h2>
			@foreach($data['goods'] as $good)
			<dl>
				<dt><img src="/image/get/{{$good['picKey']}}" alt="160x160"></dt>
				<dd><a onclick="window.open('/{{Config::get('app.locale')}}/store/detail/{{$good['id']}}','_self')">{{$good['name']}}</a></dd>
				<dd class="price">&yen;{{$good['price']}}</dd>
			</dl>
			@endforeach
		@endif	
		</div>
	</div>
</div>
@endsection