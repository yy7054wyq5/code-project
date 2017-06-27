@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner store-detail">
	<div class="container content-txt">
		<div class="product">
			<div class="photo">
				<ul id="thumblist">
				@if($store['album'])
				@foreach($store['album'] as $key=>$album)
					<li class="@if($key==0) active @endif"><a href='javascript:void(0);'><img src='/image/get/{{$album['id']}}'></a></li>
				@endforeach
				@endif
				</ul>
				<div class="show-img">
				<img src=" @if($store['album'])  /image/get/{{$store['album'][0]['id']}} @endif" >
				</div>
			</div>
			<div class="info">
				<h1>{{$store['name']}}</h1>
				<span class="price">&yen;{{$store['price']}}</span>
				<span class="subtitle">{{trans('index.spec')}}</span>
				<div class="size">
					@if(isset($store['spec']))
						@foreach($store['spec'] as $spec)
					<a>{{$spec['spec']}}</a>
						@endforeach
					@endif
				</div>
				<span class="subtitle">{{trans('index.number')}}</span>
				<div class="addcut">
					<input type="" name="" value="1">
					<a class="add">+</a>
					<a class="cut" style="margin-top: 14px;">-</a>
				</div>
				<a href="javascript:;" class="buy-btn addcar" data-id="{{$store['id']}}">{{trans('index.add_to_shoppingcar')}}</a>
				<a href="javascript:;" class="buy-btn buynow" data-id="{{$store['id']}}">{{trans('index.buy_now')}}</a>
			</div>
		</div>
		<div class="store-tab">
			<div class="abb">
				<a class="active" tab="txt-detail">{{trans('index.good_detail')}}</a>
				<a tab="comment">{{trans('index.comment_total')}}（{{$store['commentNum']}}）</a>
			</div>
		</div>
		<div class="txt-detail tab-con">
			<?php echo
$store['detail'] ?>
		</div>
		<div class="comment tab-con">
			<div class="total"><span>{{$store['commentNum']}}</span>{{trans('index.comment_unit')}}</div>
			<ul class="list">
				@foreach($store['comment']['lists'] as $comment)
				<li>
					<div class="comment-detail">
						<img src="/image/get/{{$comment['picKey']}}">
						<div class="detail">
							<div class="user">
								<span class="name">{{$comment['name']}}</span>
								<span class="date">{{$comment['createTime']}}</span>
							</div>
							<div class="con">
								{{$comment['content']}}
							</div>
						</div>
					</div>
				@foreach($comment['reply'] as $reply)
					<div class="recomment-detail">
						<div class="detail"><span>{{$reply['nickname']}}</span> @if(Config('app.locale')=='zh')说@endif：</div>
						<div class="con">{{$reply['content']}}</div>
					</div>
					@endforeach
					<div class="input-box">
						<textarea name=""></textarea>
						<div class="txt"><span class="txtnum">0</span>/200</div>
					</div>
					@if(Session('webUser.userId') && $comment['userId']!=Session('webUser.userId') && !$comment['isComment'])
					<a class="rebtn">{{trans('index.reply')}}</a>
					@endif
					<a class="sendcomment">{{trans('index.submit_reply')}}</a>
						</li>
					@endforeach
			</ul>
			{{-- 页码 --}}
			{!!$store['comment']['pager']!!}
		</div>
	</div>
</div>
@endsection

