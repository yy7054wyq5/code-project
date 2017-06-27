@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner">
	<div class="img-slide-container">
		<div class="img-con" >
			@if($data['ads'])
			@foreach($data['ads'] as $ad)
				<div class="item" onclick="window.open('/{{Config::get('app.locale')}}/food/detail/{{$ad['resourceId']}}','_self')"><img src="/image/get/{{$ad['picKey']}}" style="width: 1180px; height: 520px;"><span>{{$ad['name']}}</span></div>
			@endforeach
			@endif
		</div>
		<div class="img-btn">
			<div class="number">
				<span class="index">3</span>
				<span>/</span>
				<span class="total">5</span>
			</div>
			<a class="left-btn"><i></i></a>
			<a class="right-btn"><i></i></a>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="content">
	<div class="container food">
		<div class="tab country">
			<i>|</i>
			@foreach($data['country'] as $key=>$country)
				@if($key==0)
				<a class="active" data-id="{{$country['id']}}">{{$country['name']}}</a>
				@else
				<a data-id="{{$country['id']}}">{{$country['name']}}</a>
				@endif
			@endforeach
			<div class="input">
				<input type="" name="" placeholder="{{trans('index.search_food')}}" class="mousetrap">
				<a></a>
			</div>
		</div>
		<div class="tab category">
			<i>|</i>
			@foreach($data['category'] as $key=>$category)
					<a class=" @if($key==0) active @endif" data-id="{{$category['id']}}">
					{{Config('app.locale')=='zh'?$category['name']:$category['nameEn']}}
					</a>
			@endforeach
		</div>
		<ul class="list">
			@if($data['food'])
				@foreach($data['food'] as $food)
			<li>
				<div class="detail">
					<h3><a href="/{{Config::get('app.locale')}}/food/detail/{{$food['id']}}">{{$food['name']}}</a></h3>
					<p>{{strip_tags($food['summary'])}}</p>
				</div>
				<img src="/image/get/{{$food['picKey']}}"　alt="380x380">
				<div class="info">
					<i class="zan"></i>
					<span class="zan-person">{{$food['thumbNum']}}</span>
					<span class="comment-person">{{$food['commentNum']}}</span>
					<i class="comment"></i>
				</div>
			</li>
				@endforeach
			@endif
		</ul>
		<div class="loading-more">{{trans('index.load_more')}}</div>
	</div>
</div>
@endsection