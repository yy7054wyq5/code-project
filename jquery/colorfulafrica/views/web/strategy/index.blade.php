@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner strategy">
	<h2>
		<a class="menu active">{{trans('index.strategy_tips')}}</a>
		<i class="line">|</i>
		<a class="menu cateName">{{$data['category'][0]['name']}}</a>
		@if(isset($_COOKIE['islogin'])&& $_COOKIE['islogin']==1)
		<a class="write" a href="/{{Config::get('app.locale')}}/strategy/create-strategy">{{trans('index.write_strategy')}}</a>
		<i class="icon"></i>
		@endif
	</h2>
	<div class="clear"></div>
	<div class="img-con swipe">
		<a class="left-btn"><i></i></a>
		<a class="right-btn"><i></i></a>
		<div class="img-con-center">
			@foreach($data['category'] as $cate)
			<div class="item" data-id="{{$cate['id']}}">
				<img src="/image/get/{{$cate['picKey']}}" alt="">
				<span>{{$cate['name']}}</span>
			</div>
			@endforeach
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="tab">
	<i>|</i>
	@foreach($data['country'] as $key=>$country)
	@if($key==0)
	<a class="active" data-id="{{$country['id']}}">{{$country['name']}}</a>
	@else
	<a data-id="{{$country['id']}}">{{$country['name']}}</a>
	@endif
	@endforeach
	<div class="input">
		<input type="" name="" placeholder="{{trans('index.search_strategy_keyword')}}" class="mousetrap">
		<a></a>
	</div>
</div>
<div class="clear" style="height:30px;"></div>
<div class="content">
	<div class="container strategy">
        @if($data['raiders'])
		<ul class="tab-con @if($data['country'][0]['id']==1) active @endif" data-id="1">
		@foreach($data['raiders'] as $key=>$raiders)
			<li>
				<a class="img-link" href="/{{Config::get('app.locale')}}/strategy/detail/{{$raiders['id']}}"><img src="/image/get/{{$raiders['picKey']}}"></a>
				<ul>
					<li class="strategy-info">
						<img class="user-img" src="/image/get/{{$raiders['userIcon']}}">
						<span class="user-name">{{$raiders['nickname']}}</span>
						<span class="user-place">{{trans('index.on')}}<span>{{$raiders['countryName']}}</span>{{trans('index.submited_strategy')}}</span>
						<span class="user-comment"><strong>{{$raiders['commentNum']}}</strong>{{trans('index.person_comment')}}</span>
						<i class="comment"></i>
						<span class="user-collect"><strong>{{$raiders['favoriteNum']}}</strong>{{trans('index.person_collected')}}</span>
						<i class="love"></i>
					</li>
					<li class="strategy-title" onclick="window.open('/{{Config::get('app.locale')}}/strategy/detail/{{$raiders['id']}}','_self')">{{$raiders['name']}}</li>
					<li class="strategy-con">{{$raiders['summary']}}</li>
				</ul>
			</li>
				@endforeach
		</ul>
        @endif
		<ul class="tab-con" data-id="2"></ul>
		<ul class="tab-con" data-id="3"></ul>
		<ul class="tab-con" data-id="4"></ul>
		{{-- <ul class="tab-con"></ul> --}}
		<div class="loading-more">{{trans('index.load_more')}}</div>
	</div>
</div>
@endsection

