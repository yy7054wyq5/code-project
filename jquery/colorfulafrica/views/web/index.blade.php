@extends('web.layouts.main')
@section('header-menu')
@endsection
@section('banner')
<div class="banner index">
	<div class="img-slide-container">
		<div class="img-con">
			@foreach($data['ads'] as $ad)
				<div class="item">
					<a href="@if($ad['url'])
					@if(str_contains('http',$ad['url']) || str_contains('https',$ad['url'])){{$ad['url']}} @else http://{{$ad['url']}} @endif
					@else {{url().'/'.config('app.locale')}}
					@endif">
					<img src="/image/get/{{$ad['picKey']}}" alt="">
					<span>{{$ad['name']}}</span>
					</a>
				</div>
			@endforeach
		</div>
		<div class="img-btn">
			<div class="number">
				<span class="index">3</span>
				<span>/</span>
				<span class="total">5</span>
			</div>
			<a class="left-btn"><i></i></a>
			<a class="right-btn"><i></i></a>
		</div>
	</div>
</div>
@endsection
@section('content')
<div class="content">
	<div class="container index">
		<h2><i></i><span>{{trans('index.news')}}</span></h2>
		<div class="floor">
			@if(isset($data['info'][0]))
			<div class="left-item" style="border-right: 1px solid #fff; border-bottom: 1px solid #fff;">
				<img src="/image/get/{{$data['info'][0]['picKey']}}" class="lazy" >
				<a class="ljoy-hover" href="/{{Config::get('app.locale')}}/news/detail/{{$data['info'][0]['id']}}">
					<h3>{{$data['info'][0]['name']}}</h3>
					<p>{{strip_tags($data['info'][0]['summary'])}}</p>
				</a>
			</div>
			@endif
			@if(isset($data['info'][1]))
			<div class="small-item" style="border-right: 1px solid #fff; border-bottom: 1px solid #fff;">
				<img src="/image/get/{{$data['info'][1]['picKey']}}" class="lazy">
				<a class="ljoy-hover" href="/{{Config::get('app.locale')}}/news/detail/{{$data['info'][1]['id']}}">
					<h3>{{$data['info'][1]['name']}}</h3>
					<p>{{strip_tags($data['info'][1]['summary'])}}</p>
				</a>
			</div>
			@endif
			@if(isset($data['info'][2]))
			<div class="big-item" style="border-right: 1px solid #fff; border-bottom: 1px solid #fff;">
				<img src="/image/get/{{$data['info'][2]['picKey']}}" class="lazy">
				<a class="ljoy-hover" href="/{{Config::get('app.locale')}}/news/detail/{{$data['info'][2]['id']}}">
					<h3>{{$data['info'][2]['name']}}</h3>
					<p>{{strip_tags($data['info'][2]['summary'])}}</p>
				</a>
			</div>
			@endif
			@if(isset($data['info'][3]))
			<div class="small-item" style="border-bottom: 1px solid #fff;">
				<img src="/image/get/{{$data['info'][3]['picKey']}}" class="lazy">
				<a class="ljoy-hover" href="/{{Config::get('app.locale')}}/news/detail/{{$data['info'][3]['id']}}">
					<h3>{{$data['info'][3]['name']}}</h3>
					<p>{{strip_tags($data['info'][3]['summary'])}}</p>
				</a>
			</div>
			@endif
			@if(isset($data['info'][4]))
			<div class="small-item" style="border-right: 1px solid #fff;">
				<img src="/image/get/{{$data['info'][4]['picKey']}}" class="lazy">
				<a class="ljoy-hover" href="/{{Config::get('app.locale')}}/news/detail/{{$data['info'][4]['id']}}">
					<h3>{{$data['info'][4]['name']}}</h3>
					<p>{{strip_tags($data['info'][4]['summary'])}}</p>
				</a>
			</div>
			@endif
			@if(isset($data['info'][5]))
			<div class="small-item" style="border-right: 1px solid #fff;">
				<img src="/image/get/{{$data['info'][5]['picKey']}}" class="lazy">
				<a class="ljoy-hover" href="/{{Config::get('app.locale')}}/news/detail/{{$data['info'][5]['id']}}">
					<h3>{{$data['info'][5]['name']}}</h3>
					<p>{{strip_tags($data['info'][5]['summary'])}}</p>
				</a>
			</div>
			@endif
			@if(isset($data['info'][6]))
			<div class="big-item">
				<img src="/image/get/{{$data['info'][6]['picKey']}}" class="lazy">
				<a class="ljoy-hover" href="/{{Config::get('app.locale')}}/news/detail/{{$data['info'][6]['id']}}">
					<h3>{{$data['info'][6]['name']}}</h3>
					<p>{{strip_tags($data['info'][6]['summary'])}}</p>
				</a>
			</div>
			@endif
		</div>
		<div class="clear"></div>
		<h2><i></i><span>{{trans('index.strategy')}}</span><a class="exchange" data-page="{{$data['raiders']['page']}}">{{trans('index.change')}}</a><i class="icon"></i></h2>
		<div class="clear"></div>
		<div class="floor strategy">
			@if($data['raiders'])
            @foreach($data['raiders'] as $key=>$val)
            @if(is_numeric($key))
			<div class="strategy-item">
				<a href="{{$val['url'].$val['resourcesId']}}"><img src="/image/get/{{$val['picKey']}}"></a>
				<div class="icon">
                    @if($val['resourcesType']==2)
					<i class="travel-notes"></i>
					<span>{{trans('index.travel')}}</span>
                    @elseif($val['resourcesType']==3)
                    <i class="food"></i>
                    <span>{{trans('index.food')}}</span>
                    @else
                    <i class="contact"></i>
                    <span>{{trans('index.partner')}}</span>
                    @endif
				</div>
				<div class="info">
					<h3><a href="{{$val['url'].$val['resourcesId']}}">{{$val['name']}}</a></h3>
					<span class="classic">{{$val['cate']}}</span>
					<span class="looks">{{$val['looks']}}{{trans('index.person_view')}}</span>
				</div>

			</div>
			@endif
            @endforeach
            @endif
		</div>
		<div class="clear"></div>
		<h2><i></i><span>{{trans('index.walk')}}</span></h2>
		<div class="floor play">
            @if($data['tourism'])
			@foreach($data['tourism'] as $key=>$val)
			<div class="play-item" onclick="window.open('/{{Config::get('app.locale')}}/walkin/index/{{$val['Id']}}','_self')">
				<img src="/image/get/{{$val['picKey']}}">
				<div class="back"></div>
				<div class="info">
					@if(isset($data['tourism'][0])&&$key==0)
					<i class="south-africa"></i>
						@elseif(isset($data['tourism'][1]) &&$key==1)
						<i class="kenya"></i>
					@elseif(isset($data['tourism'][2]) &&$key==2)
						<i class="egpyt"></i>
						@else
						<i class=""></i>
					@endif
					<h3><a href="/{{Config::get('app.locale')}}/walkin/index/{{$val['Id']}}">
					{{$val['name']}}</a></h3>
					<span>{{$val['summary']}}</span>
				</div>
			</div>
			@endforeach
            @endif
		</div>
		<div class="clear"></div>
		<h2><i></i><span>{{trans('index.store')}}</span></h2>
		<div class="floor store active">
            @if($data['mall'])
			@foreach($data['mall']['infos'] as $key=>$mall)
				@if(is_numeric($key))
			<a class="store-item" href="/{{Config::get('app.locale')}}/store/detail/{{$mall['id']}}">
				<img src="/image/get/{{$mall['picKey']}}">
				<h3>{{$mall['name']}}</h3>
				<span>&yen;{{$mall['price']}}</span>
			</a>
			@endif
			@endforeach
            @endif
		</div>
		<div class="clear"></div>
		@if($data['mall']['pager']['page']>1)
		<div class="floor store"></div>
		@endif
		<div class="clear"></div>
		@if($data['mall']['pager']['page']>2)
		<div class="floor store"></div>
		@endif
		<div class="clear"></div>
		<ul class="store-btn">
			<li class="active good"></li>
			@if($data['mall']['pager']['page']>1)
			<li></li>
			@endif
			@if($data['mall']['pager']['page']>2)
			<li class="good" style="margin-right:0"></li>
			@endif
		</ul>
		<div class="clear"></div>
	</div>
</div>
@endsection

