@extends('web.user.layouts.main')

@section('user-content')
<div class="user-container strategy">
	<div class="user-tab">
		<a class="active" data-tag="0" data-currentpage="1">{{trans('index.my_submit_strategy')}}（<span>{{$travels['num']['realNum']}}</span>）</a>
		<a data-tag="1" data-currentpage="1">{{trans('index.my_commented_strategy')}}</a>
		<a data-tag="2" data-currentpage="1">{{trans('index.my_conllected_strategy')}}</a>
		<a data-tag="3" data-currentpage="1">{{trans('index.draft')}}（<span>{{$travels['num']['fragNum']}}</span>）</a>
	</div>
	{{-- 第1个.list是我发布的游记 --}}
	<ul class="list active" data-tag="0">
		@foreach($travels['result'] as $key=>$travel)
		<li>
			<i class="circle"></i>
			<div class="date">{{trans('index.submit_when')}}{{$travel['createTime']}}</div>
			<div class="line">
				<div class="list-btn">
					<i class="write"></i>
					<a href="/{{Config('app.locale')}}/strategy/create-strategy/{{$travel['id']}}">{{trans('index.edit')}}</a>
					<i class="delete"></i>
					<a data-id="{{$travel['id']}}" class="deleteBtn">{{trans('index.delete')}}</a>
				</div>
				<a href="/{{Config('app.locale')}}/strategy/detail/{{$travel['id']}}" title="">{{$travel['name']}}</a>
				<hr>
			</div>
		</li>
		@endforeach
	</ul>
	{{-- 第2个.list是我评论的游记 --}}
	<ul class="list" data-tag="1"></ul>
	{{-- 第3个.list是我收藏的游记 --}}
	<ul class="list" data-tag="2"></ul>
	{{-- 第4个.list是草稿箱 --}}
	<ul class="list" data-tag="3"></ul>
	<div class="loading-more">{{trans('index.load_more')}}</div>
	<div class="no-product">{{trans('index.no_content')}}</div>
</div>
@endsection