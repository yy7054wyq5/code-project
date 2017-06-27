@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner partner">
	<div class="container">
		<h1>{{trans('index.partner')}}</h1>
		<div class="tab-partner">
			@if($data['category'])
				@foreach($data['category'] as $key=>$cate)
					<a class=" @if($key==0)active @endif" data-id="{{$cate['id']}}">{{Config('app.locale')=='zh'?$cate['name']:$cate['nameEn']}}</a>
				@endforeach
			@endif
		</div>
		{{-- class为list的ul，为选项卡内容容器 --}}

		<ul class="list active">
		@if($data['partner'])
		@foreach($data['partner'] as $key=>$partner)
			@if($key%2==0)
			<li>
				<img src="/image/get/{{$partner['picKey']}}" alt="688x392" class="pull-left">
				<div class="info pull-left">
					<h2>{{Config('app.locale')=='zh'?$partner['name']:$partner['nameEn']}}</h2>
					<a href="/{{Config::get('app.locale')}}/partner/detail/{{$partner['id']}}">{{trans('index.check_detail')}}</a>
				</div>
			</li>
			@else
			<li>
				<div class="info pull-left">
					<h2>{{Config('app.locale')=='zh'?$partner['name']:$partner['nameEn']}}</h2>
					<a href="/{{Config::get('app.locale')}}/partner/detail/{{$partner['id']}}">{{trans('index.check_detail')}}</a>
				</div>
				<img src="/image/get/{{$partner['picKey']}}" class="pull-left">
			</li>
			@endif
			@endforeach
		@endif
		</ul>
		@if($data['category'])
				@foreach($data['category'] as $key=>$cate)
 		<ul class="list">
		</ul>
		@endforeach
		@endif
		<div style="height:200px;"></div>
	</div>
</div>
@endsection
