@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner strategy-detail">
	<div class="container content-txt">
		<div class="title">
			<div class="filter"></div>
			<img class="writer-img" src="/image/get/{{$travel['picId']}}}" alt="115x115">
			<h1>{{$travel['name']}}</h1>
			<img class="cover" src="/image/get/{{$travel['picId']}}" alt="80x420">
			<div class="writer">
				<div class="info">
					<span class="name">{{$travel['nickname']}}</span>
					<span class="date">{{trans('index.submit_when')}} {{$travel['createTime']}}</span>
				</div>
				<div class="handle">
					@if($travel['isCollected']==1)
					<i class="star active"></i>
						@else
						<i class="star "></i>
					@endif
						{{-- 已收藏需要加个active --}}
					<span class="collect" data-id="{{$travel['id']}}">{{trans('index.collection')}}</span>
					<i class="love"></i>
					<span>{{$travel['favoriteNum']}}{{trans('index.person_collected')}}</span>
					<i class="comment"></i>
					<span>{{$travel['commentNum']}}{{trans('index.person_comment')}}</span>
				</div>
			</div>
		</div>
		<div class="tag">
			<span class="line">|</span>
			@foreach(explode(',',$travel['tags']) as $tag)
			<span class="item">{{$tag}}</span>
			@endforeach
		</div>
		<div class="txt-detail">
			<?php echo $travel['detail'];?>
		</div>
		<div class="comment">
			<div class="total"><span>{{$travel['commentNum']}}</span>{{trans('index.comment_unit')}}</div>
			<ul class="list">
				@foreach($travel['comment']['lists'] as $comment)
				<li>
					<div class="comment-detail" data-id="{{$comment['id']}}">
						<img src="/image/get/{{$comment['picKey']}}" alt="56x56">
						<div class="detail">
							<div class="user">
								<span class="name">{{$comment['nickname']}}</span>
								<span class="date">{{$comment['createTime']}}</span>
							</div>
							<div class="con">
								{{$comment['content']}}
							</div>
						</div>
					</div>
					@foreach($comment['reply'] as $reply)
					<div class="recomment-detail">
						<div class="detail"><span>{{$reply['nickname']}}</span>说：</div>
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
			{!!$travel['comment']['pager']!!}
		</div>
		{{-- data-id放被评论的资源ID --}}
		<div class="send-comment" data-id="{{$travel['id']}}">
			<span class="title">{{trans('index.comment')}}</span>
			<textarea></textarea>
			<a class="comment-btn" data-type="1">{{trans('index.submit')}}</a>
		</div>
	</div>
</div>
@endsection

@section('footer-scripts')
<script type="text/javascript">

</script>
@endsection


