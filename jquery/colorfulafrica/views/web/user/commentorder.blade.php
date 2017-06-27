@extends('web.user.layouts.main')

@section('user-content')
	<div class="user-container commentorder">
		<div class="order-status">
			<span>{{trans('index.comment').trans('index.order')}}</span>
		</div>
		<table class="order-info">
			<tr>
				<td>{{trans('index.orderNo')}}：{{$detail['orderNo']}}</td>
				<td>{{trans('index.ordertime')}}：{{$detail['createTime']}}</td>
			</tr>
		</table>
		<ul class="product-list">
		@foreach($detail['detail'] as $key => $good)
			<li data-index="{{$key}}">
				<div class="product-detail">
					<img  src="/image/get/{{$good['picKey']}}">
					<div class="info">
						<h5>{{$good['name']}}</h5>
						<p>&yen;{{$good['price']}}</p>
						<span>{{$good['spec']}}</span>
					</div>
				</div>
				<div class="send-comment" data-id="{{$good['id']}}">
					<span class="title">{{trans('index.comment')}}</span>
					@if($good['comment'])
					{{-- 这是显示评价的DIV --}}
					<div class="comment-txt">
						{{$good['comment']['content']}}
					</div>
					@if($good['comment']['album'])
					<div class="comment-img">
					@foreach($good['comment']['album'] as $album)
						<img  src="/image/get/{{$album}}">
					@endforeach
					</div>
					@endif
					@else
					<textarea placeholder="写下商品评论"></textarea>
					<span class="content-num"><span>0</span>/500</span>
					<div class="push-img">
						<div class="camera-box">
							<i class="comment-order-icon"></i>
							<input id="comment-order-icon{{$key}}" type="file" name="files" class="upcommentsimg">
							{{-- <i class="comment-order-icon"></i> --}}
						</div>
						<div class="img-con">
							<div class="img-list"></div>
							<span>晒图，还能上传<span class="number">10</span>张</span>
						</div>
						<a class="submit-comment" data-orderid="{{$detail['id']}}">{{trans('index.submit')}}</a>
					</div>
					@endif


				</div>

			</li>

		@endforeach
		</ul>
	{{-- 	<div class="comment-btn-box">
			<a class="submit-comment">{{trans('index.submit')}}</a>
		</div> --}}
	</div>
@endsection
