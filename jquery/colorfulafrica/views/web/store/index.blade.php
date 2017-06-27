@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner store">
	@if($data['ads'])
		@foreach($data['ads'] as $ad)
	<img src="/image/get/{{$ad['picKey']}}">
	<div class="filter">
		<div class="container">
			<h1>{{$ad['name']}}</h1>
			{{-- <p>{{$ad['summary']}}</p> --}}
			{{-- <a>{{trans('index.buy_now')}}</a> --}}
		</div>
	</div>
		@endforeach
	@endif
</div>
@endsection

@section('content')
<div class="content">
	<div class="container store">
		<div class="input">
			<a class="search-btn" data-pageindex="1"></a>
			<input type="" name="" placeholder="{{trans('index.search_goods_keyword')}}" class="mousetrap">
		</div>
		<ul class="recommend">
			@if($data['recommend'])
				@foreach($data['recommend'] as $key=>$recommend)
					@if($key%2==0)
			<li>
				<a class="img-link pull-left"href="/{{Config::get('app.locale')}}/store/detail/{{$recommend['id']}}"><img src="/image/get/{{$recommend['picKey']}}" alt="590x322"></a>
				<ul class="pull-left">
					<li class="title"><a href="/{{Config::get('app.locale')}}/store/detail/{{$recommend['id']}}">{{$recommend['name']}}</a></li>
					<li class="content">{{$recommend['summary']}}</li>
					<li class="price">&yen;<span>{{$recommend['price']}}</span></li>
					<li><a data-id="{{$recommend['id']}}" class="addcar">{{trans('index.add_to_shoppingcar')}}</a></li>
				</ul>
			</li>
					@else
			<li>
				<ul class="pull-left">
					<li class="title"><a href="/{{Config::get('app.locale')}}/store/detail/{{$recommend['id']}}">{{$recommend['name']}}</a></li>
					<li class="content">{{$recommend['summary']}}</li>
					<li class="price">&yen;<span>{{$recommend['price']}}</span></li>
					<li><a data-id="{{$recommend['id']}}" class="addcar">{{trans('index.add_to_shoppingcar')}}</a></li>
				</ul>
				<a class="img-link pull-right" href="/{{Config::get('app.locale')}}/store/detail/{{$recommend['id']}}"><img src="/image/get/{{$recommend['picKey']}}"></a>
			</li>
					@endif
				@endforeach
			@endif
		</ul>
		<ul class="normal">
			@if($data['mall'] )
				@foreach($data['mall'] as $commodity)
			<li>
				<div class="price">
					<div>&yen;</div>
					<div class="num">{{$commodity['price']}}</div>
				</div>
				<a class="img-link" href="/{{Config('app.locale')}}/store/detail/{{$commodity['id']}}"><img src="/image/get/{{$commodity['picKey']}}"></a>
				<div class="info">
					<span><a href="/{{Config('app.locale')}}/store/detail/{{$commodity['id']}}">{{$commodity['name']}}</a></span>
					<a data-id="{{$commodity['id']}}" class="addcar">{{trans('index.add_to_shoppingcar')}}</a>
				</div>
			</li>
				@endforeach
			@endif
		</ul>
		<div class="loading-more">{{trans('index.load_more')}}</div>
	</div>
</div>
@endsection

