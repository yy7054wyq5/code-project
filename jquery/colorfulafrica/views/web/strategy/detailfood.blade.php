@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner food-detail">
	<div class="container content-txt">
		<div class="bar">
			<img src="/image/get/{{$food['picKey']}}" alt="586x460"/>
			<h1>@if(Config('app.locale')=='zh'){{$food['name']}}@else {{$food['nameEn']}} @endif</h1>
			<div class="con">@if(Config('app.locale')=='zh'){{$food['summary']}} @else {{$food['summaryEn']}}@endif</div>
			<div class="cover-btn">
				<span>{{trans('index.comment')}}&nbsp;{{$food['commentNum']}}</span>
				<i class="comment"></i>
				<span class="dianzan" data-id="{{$food['id']}}">{{trans('index.thumb')}}&nbsp;{{$food['thumbNum']}}</span>
				{{-- 如果点了赞下面这个zan加个active  --}}
				<i class="zan @if($food['isFavorite']==1)active @endif"></i>
			</div>
		</div>
		<div class="txt-detail">
			<?php echo $food['detail'] ?>
		</div>
		<div class="sidebar">
		@if(isset($food['commodities'][0]))
			<h2>{{trans('index.hot_good')}}</h2>
			<div class="store">
				<img src="/image/get/{{$food['commodities'][0]['info']['picKey']}}" style="width:235px" alt="235x235" onclick="window.open('/{{Config('app.locale')}}/store/detail/{{$food['commodities'][0]['commodityId']}}','_self')">
				<div class="title" onclick="window.open('/{{Config('app.locale')}}/store/detail/{{$food['commodities'][0]['commodityId']}}','_self')">{{Config('app.locale')=='zh'?$food['commodities'][0]['info']['name']:$food['commodities'][0]['info']['nameEn']}}</div>

				<div class="price">&yen;<span>{{$food['commodities'][0]['info']['price']}}</span></div>
				<a data-id="{{$food['commodities'][0]['info']['id']}}" class="addcar">{{trans('index.add_to_shoppingcar')}}</a>
				<a data-id="{{$food['commodities'][0]['info']['id']}}"style="margin-left:5px;" class="buynow">{{trans('index.buy_now')}}</a>
			</div>
		@endif
		@if(isset($food['travels'][0]))
			<h2>{{trans('index.recommad_strategy')}}</h2>
			<div class="high">
				<a href="/{{Config('app.locale')}}/strategy/detail/{{$food['travels'][0]['travelId']}}">
				<img src="/image/get/{{$food['travels'][0]['info']['picKey']}}" style="width:235px" alt="235x162">
				<div class="title">{{$food['travels'][0]['info']['name']}}</div>
				</a>
			</div>
		@endif
		@if(isset($food['partners'][0]))
			<h2>{{trans('index.partner')}}</h2>
			<div class="partner">
				<a href="/{{Config('app.locale')}}/partner/detail/{{$food['partners'][0]['partnerId']}}">
				<img src="/image/get/{{$food['partners'][0]['info']['picKey']}}" style="width:235px" alt="235x188">
				<div class="title">{{Config('app.locale')=='zh'?$food['partners'][0]['info']['name']:$food['partners'][0]['info']['nameEn']}}</div>
				</a>
			</div>
		@endif
		</div>
	</div>
	<div class="container">
		<div class="comment">
			<div class="total"><span>{{$food['commentNum']}}</span>{{trans('index.comment_unit')}}</div>
			<ul class="list">
			@foreach($food['comment']['lists'] as $comment)
				<li>
					<div class="comment-detail" data-id="{{$comment['id']}}">
						<img src="/image/get/{{$comment['picKey']}}" alt="56x56">
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
						<div class="detail"><span>{{$reply['nickname']}}</span>：</div>
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
			{!!$food['comment']['pager']!!}
		</div>
		{{-- data-id放被评论的资源ID --}}
		<div class="send-comment" data-id="{{$food['id']}}">
			<span class="title">{{trans('index.comment')}}</span>
			<textarea></textarea>
			<a class="comment-btn" data-type="3">{{trans('index.submit')}}</a>
		</div>
	</div>
</div>
@endsection

