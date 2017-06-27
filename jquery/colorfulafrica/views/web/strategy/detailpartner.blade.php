@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner partner-detail">
	<div class="container content-txt">
		<h1>{{Config('app.locale')=='zh'?$partner['name']:$partner['nameEn']}}</h1>
		<div class="img-slide-container">
			<div class="img-con">
			@if($partner['album'])
				@foreach($partner['album'] as $pic)
				<div class="item">
					<img src="/image/get/{{$pic['id']}}" alt="">
				</div>
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
			<div class="thumb"></div>
		</div>
		<ul class="partner-info">
			<li>
				<i class="name"></i>
				<span>{{trans('index.name')}}：</span>
				<span class="small">{{$partner['name']}}</span>
			</li>
			<li>
				<i class="web"></i>
				<span>{{trans('index.web_address')}}：</span>
				<span class="small">{{$partner['link']}}</span>
			</li>
{{-- 			<li>
				<i class="address"></i>
				<span>{{trans('index.address')}}：</span>
				<span class="small">{{$partner['address']}}</span>
			</li> --}}
			<li>
				<i class="phone"></i>
				<span>{{trans('index.phone')}}： </span>
				 <span>{{$partner['telephone']}}</span>
			</li>
{{-- 			<li>
				<i class="open"></i>
				<span>{{trans('index.open_hour')}}：</span>
				<span>{{$partner['openBegin']}}a.m-{{$partner['openEnd']}} p.m</span>
			</li> --}}
		</ul>
		<div class="txt-detail">
			<?php echo $partner['detail'] ?>
		</div>
	</div>
</div>
@endsection

