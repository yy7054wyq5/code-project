@extends('web.layouts.main')

@section('index-header')
@endsection

@section('content')
<div class="content">
	<div class="container aboutus">
		<h1>{{Config('app.locale')=='zh'?$data['name']:$data['nameEn']}}</h1>
		{{-- <img src="http://placehold.it/975x300"> --}}
		<p>{!!$data['describe']!!}</p>
	{{-- 	<img src="http://placehold.it/975x300"> --}}
		{{-- <img src="/dist/img/index111.png" > --}}
		{{-- <div class="ceshi">
			<div class="ceng"></div>
		</div>
		<p>大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡</p>
		<p>大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡</p>
		<p>大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡大家啊卡拉胶倒垃圾的卡</p> --}}
	</div>
</div>

@endsection

