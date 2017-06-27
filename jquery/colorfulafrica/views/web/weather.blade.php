@extends('web.user.layouts.main')

@section('banner')
@endsection

@section('content')
<div class="container weather weather-module">
	<div class="chose-weather">
		<div class="city">
			<span class="name">{{Config('app.locale')=='en'?$data['currentCity']['nameEn']:$data['currentCity']['name']}}</span>
			<span class="line"></span>
			<span class="date">{{date('Y.m.d H:i')}}</span>
			<span class="week">{{$data['weather'][0]['week']}} @if(Config('app.locale')=='zh'){{trans('index.lunar')}}{{$data['lunar']}}@endif</span>
		</div>
		<div class="weather">
			<i class="{{\App\Utils\Helpers::getWeatherIcon()[$data['weather'][0]['code']]}}"></i>
			<div>
				<p>{{$data['weather'][0]['weather']}}</p>
				<p>{{$data['weather'][0]['temperature']}}</p>
			</div>
		</div>
	</div>
	<div class="user-chose">
		<ul>
		@foreach($data['country'] as $country)
			<li @if($country['id']==$data['currentCountry']) class="active" @endif data-id="{{$country['id']}}">{{$country['name']}}</li>
		@endforeach
		</ul>
		<div class="active">
		@foreach($data['city'] as $city)
			<a data-id="{{$city['id']}}" href="/{{Config('app.locale')}}/index/weather/{{$city['countryId']}}/{{$city['id']}}">{{$city['name']}}</a>
		@endforeach
		</div>
	</div>
	<div class="hack"></div>
	<ul class="week-weather">
	@foreach($data['weather'] as $key=>$weather)
	@if($key<7)
		<li>
			<div class="date">{{$weather['date']}}</div>
			<i class="{{\App\Utils\Helpers::getWeatherSmallIcon()[$weather['code']]}}"></i>
			<div class="des">{{$weather['weather']}}</div>
			<div class="degrees">{{$weather['temperature']}}</div>
		</li>
	@endif
	@endforeach
	</ul>
</div>
@endsection
