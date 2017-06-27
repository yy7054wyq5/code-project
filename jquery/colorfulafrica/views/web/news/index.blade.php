@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner">
	<div class="img-slide-container">
		<div class="img-con">
			@foreach($data['ads'] as $ad)
			<div class="item" onclick="window.open('/{{Config::get('app.locale')}}/news/detail/{{$ad['resourceId']}}','_self')">
				<img src="/image/get/{{$ad['picKey']}}" alt="">
				<span>{{$ad['name']}}</span>
			</div>
			@endforeach
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
	<div class="container news">
		<ul class="tab">
			@foreach($data['country'] as $key=>$country)
				@if($key==0)
					<li class="active" data-id="{{$country['id']}}">{{$country['name']}}</li>
					@else
					<li class="" data-id="{{$country['id']}}">{{$country['name']}}</li>
				@endif
			@endforeach
			<li class="input">
				<a></a>
				<input type="" name="" placeholder="{{trans('index.search_news_keyword')}}" class="mousetrap">
			</li>
		</ul>
		<div class="clear"></div>
		<div class="tab-con active">
			<ul class="recommend">
                @if($data['recommend'])
				@foreach($data['recommend'] as $recommend)
				<li>
					<img src="/image/get/{{$recommend['picKey']}}" onclick="window.open('/{{Config::get('app.locale')}}/news/detail/{{$recommend['id']}}','_self')">
					<h3 onclick="window.open('/{{Config::get('app.locale')}}/news/detail/{{$recommend['id']}}','_self')">{{$recommend['name']}}</h3>
					<span>{{date('Y-m-d'),$recommend['createTime']}}</span>
				</li>
				@endforeach
                @endif
			</ul>
			<div class="clear"></div>
			<ul class="common">
                @if($data['news'])
				@foreach($data['news'] as $val)
				<li>
					<img src="/image/get/{{$val['picKey']}}" onclick="window.open('/{{Config::get('app.locale')}}/news/detail/{{$val['id']}}','_self')">
					<div>
						<h4>
							<span class="title" onclick="window.open('/{{Config::get('app.locale')}}/news/detail/{{$val['id']}}','_self')">{{$val['name']}}</span>
							<span class="date">{{$val['createTime']}}</span>
						</h4>
						<p>{{strip_tags($val['summary'])}} </p>
					</div>
				</li>
				@endforeach
                @endif
			</ul>
		</div>
		<div class="tab-con"></div>
		<div class="tab-con"></div>
		<div class="tab-con"></div>
		<div class="loading-more">{{trans('index.load_more')}}</div>
	</div>
</div>
@endsection
