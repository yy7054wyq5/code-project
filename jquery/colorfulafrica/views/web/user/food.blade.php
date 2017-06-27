@extends('web.user.layouts.main')

@section('user-content')
<div class="user-container food">
	<div class="user-tab">
		<a class="active" data-tag="0" data-currentpage="1">{{trans('index.my_commented_food')}}</a>
		<a data-tag="1" data-currentpage="1">{{trans('index.my_favorited_food')}}</a>
	</div>
	<ul class="list active" data-tag="0"></ul>
	<ul class="list" data-tag="1"></ul>
	<div class="loading-more">{{trans('index.load_more')}}</div>
	<div class="no-product">{{trans('index.no_content')}}</div>
</div>
@endsection