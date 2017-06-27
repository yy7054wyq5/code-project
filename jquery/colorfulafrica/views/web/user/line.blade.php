@extends('web.user.layouts.main')

@section('user-content')
<div class="user-container line">
	<div class="user-tab">
		<a class="active">{{trans('index.my_conllected_line')}}</a>
	</div>
	<ul class="list active">
		@foreach($line as $line)
		<li data-id="{{$line['id']}}">
			<i class="circle"></i>
			<div class="date">{{trans('index.I_at')}}{{$line['createTime']}}{{trans('index.collected_this_strategy')}}</div>
			<div class="line">
				<div class="list-btn" style="top:40px;">
					<i class="star"></i>
					<a>{{trans('index.cancel_collect')}}</a>
				</div>
				<div class="content">
					<img src="/image/get/{{$line['picKey']}}" style="width:84px;">
					<div class="txt nobg" style="width:845px;">{{$line['name']}}</div>
				</div>
				<hr>
			</div>
		</li>
		@endforeach
	</ul>
	<div class="loading-more">{{trans('index.load_more')}}</div>
	<div class="no-product">{{trans('index.no_content')}}</div>
</div>
@endsection