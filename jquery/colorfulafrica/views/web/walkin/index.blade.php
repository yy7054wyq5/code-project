@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner walkin">
	@if($data['ads'])
		@foreach($data['ads'] as $ad)
	<img src="/image/get/{{$ad['picKey']}}">
	<div class="filter">
		<div class="container">
			<h1>{{$ad['name']}}</h1>
			{{-- <p>{{$ad['summary']}}</p> --}}
		</div>
	</div>
		@endforeach
	@endif
</div>
@endsection

@section('content')
<div class="content">
	<div class="container walkin">
		<div class="tab country">
			<i>|</i>
			@foreach($data['country'] as $key=>$country)
				@if($data['countryId']==$country['id'])
					<a class="active" data-id="{{$country['id']}}">{{$country['name']}}</a>
					@else
					<a class="" data-id="{{$country['id']}}">{{$country['name']}}</a>
				@endif
			@endforeach
			<div class="input">
				<input type="" name="" placeholder="{{trans('index.search_line_keyword')}}" class="mousetrap">
				<a></a>
			</div>
		</div>
		<div class="tab category">
			<i>|</i>
				<a class="active" data-id="">{{trans('index.all')}}</a>
			@if($data['category'])
				@foreach($data['category'] as $key=>$cate)

				<a class=" @if($key==-1) active @endif" data-id="{{$cate['id']}}">{{Config('app.locale')=='en'?$cate['nameEn']:$cate['name']}}</a>
				@endforeach
			@endif
		</div>
		<ul class="list">
			@if($data['tourism'])
				@foreach($data['tourism'] as $tourism)
				<li>
					<a href="/{{Config::get('app.locale')}}/walkin/detail/{{$tourism['id']}}">
					<img src="/image/get/{{$tourism['picKey']}}" style="width:320px;height:230px" onclick="window.open('/{{Config::get('app.locale')}}/walkin/detail/{{$tourism['id']}}','_self')">
					<ul>
						<li class="title" onclick="window.open('/{{Config::get('app.locale')}}/walkin/detail/{{$tourism['id']}}','_self')">{{Config('app.locale')=='zh'?$tourism['name']:$tourism['nameEn']}}</li>
						<li class="content">{{$tourism['summary']}}
						</li>
						<li class="info">
							<i class="love"></i>
							<span class="love-person">{{$tourism['favoriteNum']}}</span>
							<i class="comment"></i>
							<span class="comment-person">{{$tourism['commentNum']}}</span>
							<span class="price">{{trans('index.consult_price')}}<span>{{$tourism['feeStart']}}-{{$tourism['feeEnd']}}</span>{{trans('index.percost')}}</span>
						</li>
					</ul>
				</a>
				</li>
				@endforeach
			@endif
		</ul>
		<div class="loading-more">{{trans('index.load_more')}}</div>
		<div class="partner-item" style="display: none;">
			<h2>{{trans('index.releatived_partner')}}</h2>
			@if($data['partner'])
			<img src="/image/get/{{$data['partner']['picKey']}}" style="width:450px;height:300px" alt="450x300">
			<ul>
				<li class="title">{{Config('app.locale')=='zh'?$data['partner']['name']:$data['partner']['nameEn']}}</li>
				<li>{{$data['partner']['address']}}</li>
				<li>{{trans('index.phone')}}：{{$data['partner']['telephone']}} </li>
				<li>{{trans('index.mobile')}}：{{$data['partner']['mobile']}} </li>
				<li>{{trans('index.tax')}}：{{$data['partner']['tax']}}</li>
				<li>{{trans('index.email')}}：{{$data['partner']['email']}}</li>
				<li>{{$data['partner']['summary']}}</li>
			</ul>
			@endif
		</div>
	</div>
</div>
@endsection
