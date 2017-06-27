@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner walkin-detail">
	<div class="container content-txt">
		<div class="bar">
			<img src="/image/get/{{$line['picKey']}}" alt="586x460">
			<h1>{{Config('app.locale')=='zh'?$line['name']:$line['nameEn']}}</h1>
			<div class="describe">{{$line['summary']}}</div>
			<div class="price"><span>{{$line['feeStart']}}-{{$line['feeEnd']}}</span>/人</div>
			<div class="handle">
				<span>{{$line['commentNum']}}{{trans('index.person_commented')}}</span>
				<i class="comment"></i>
				<span>{{$line['favoriteNum']}}{{trans('index.person_collected')}}</span>
				<i class="love"></i>
				@if($line['isCollected']==1)
				<i class="star active"></i>
				@else
				<i class="star"></i>
				@endif
				{{-- 已收藏需要加个active --}}
				<span class="collect" data-id="{{$line['id']}}">{{trans('index.collection')}}</span>
			</div>
		</div>
		<div class="line-detail">
			<div class="tabs">
				<a href="#line" class="active">{{trans('index.line_detail')}}</a>
				<a href="#note">{{trans('index.notice')}}</a>
				<a href="#passcard">{{trans('index.visa')}}</a>
				<a href="#comment">{{trans('index.comment')}}（{{$line['commentNum']}}）</a>
			</div>
			<div class="detail">
				<h3 id="line">{{trans('index.line_detail')}}</h3>
				<?php echo $line['detail'] ?>
				<h3 id="note">{{trans('index.notice')}}</h3>
				<p>{{$line['notice']}}</p>
				<h3 id="passcard">{{trans('index.visa')}}</h3>
				<p>{{$line['visa']}}</p>
				<h3 id="comment">{{trans('index.comment')}}</h3>
				<div class="comment">
					<div class="total"><span>{{$line['commentNum']}}</span>{{trans('index.comment_unit')}}</div>
					<ul class="list">
					@foreach($line['comment']['lists'] as $comment)
						<li>
							<div class="comment-detail">
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
					{!!$line['comment']['pager']!!}
				</div>
				{{-- data-id放被评论的资源ID --}}
				<div class="send-comment" data-id="{{$line['id']}}">
					<span class="title">{{trans('index.comment')}}</span>
					<textarea></textarea>
					<a class="comment-btn" data-type="2">{{trans('index.submit')}}</a>
				</div>
			</div>
		</div>
		<div class="bottom">
			<h4>{{trans('index.recommad_food')}}</h4>
			<div class="food-box">
			@if($line['foods'])
			@foreach($line['foods'] as $k=>$food)
				<div>
				@if($k%2==0)
					<img src="/image/get/{{$food['info']['picKey']}}" alt="235x235" onclick="window.open('/{{Config::get('app.locale')}}/food/detail/{{$food['foodId']}}','_self')">
					<a href="/{{Config::get('app.locale')}}/food/detail/{{$food['foodId']}}">{{$food['info']['name']}}</a>
				@else
					<a>{{$food['info']['name']}}</a>
					<img src="/image/get/{{$food['info']['picKey']}}" onclick="window.open('/{{Config::get('app.locale')}}/food/detail/{{$food['foodId']}}','_self')">
				@endif
				</div>
			@endforeach
			@endif
			</div>
			<h4>{{trans('index.strategy_album')}}</h4>
			<div class="photo-box">
			@if($line['travels'])
				@foreach($line['travels'] as $travel)
				<div>
					<img src="/image/get/{{$travel['info']['picKey']}}" alt="320x222" onclick="window.open('/{{Config::get('app.locale')}}/strategy/detail/{{$travel['travelId']}}','_self')">
					<a>{{$travel['info']['name']}}</a>
				</div>
				@endforeach
				@endif
			</div>
			<h4>{{trans('index.partner')}}</h4>
			<div class="partner-box">
			@if($line['partners'])
				@foreach($line['partners'] as $partner)
				<a href="/{{Config::get('app.locale')}}/partner/detail/{{$partner['partnerId']}}">
					<img src="/image/get/{{$partner['info']['picKey']}}" alt="235x188">
				</a>
				@endforeach
			@endif
			</div>
		</div>
	</div>
</div>
@endsection


