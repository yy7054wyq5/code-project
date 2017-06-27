@extends('web.layouts.main')

@section('header')
<script type="text/javascript">
	window.UEDITOR_HOME_URL = "/dist/lib/ueditor/";
</script>
@endsection

@section('content')
<div class="car-header strategy">
	<div class="content car">
		<a href="/index" class="logo"><i class="logo"></i></a>
		<span>{{trans('index.submit_strategy')}}</span>
		<div class="header-btn">
			<a class="draft" data-type="0">{{trans('index.save')}}<span>&nbsp;&nbsp;{{trans('index.or')}}</span></a>
			<a class="save" data-type="1">{{trans('index.submit_strategy')}}</a>
		</div>
	</div>
</div>
<div class="strategy-edit-con" data-id="{{$detail?$detail['id']:0}}">
	<div class="strategy-input title">
		<input type="text" name="strategy-title" placeholder="{{trans('index.please_input_strategy_title')}}" value="{{$detail?$detail['name']:''}}">
		<span><span>0</span>/30</span>
	</div>
	<div class="chose-con">
		<div class="chose-title">{{trans('index.country')}}></div>
		<a class="selected country" data-id="{{$detail?$detail['countryId']:$country[0]['id']}}">{{$detail?$detail['countryName']:$country[0]['name']}}</a>
		<i class="down"></i>
		<div class="con">
			@foreach($country as $counties)
			<a id="{{$counties['id']}}">{{$counties['name']}}</a>
			@endforeach
		</div>
	</div>
	<div class="chose-con" style="float:right;">
		<div class="chose-title">{{trans('index.block')}}></div>
		<a class="selected category" data-id="{{$detail?$detail['categoryId']:$category[0]['id']}}">{{$detail?$detail['cateName']:$category[0]['name']}}</a>
		<i class="down"></i>
		<div class="con">
			@foreach($category as $cate)
			<a id="{{$cate['id']}}">{{$cate['name']}}</a>
			@endforeach
		</div>
	</div>
	<div class="clear"></div>
	<div class="strategy-input des" style="margin-top:40px;">
		<input type="text" name="strategy-des" placeholder="{{trans('index.please_input_strategy_summary')}}" class="des" value="{{$detail?$detail['summary']:''}}">
		<span><span>0</span>/50</span>
	</div>
	<div class="add-tag">
		<span>{{trans('index.add_tags')}}：</span>
		<input type="text" name="strategy-tag" placeholder="{{trans('index.add_strategy_tags')}}" value="{{$detail?$detail['tags']:''}}" >
	</div>
	{{-- 如果是编辑游记需要传个图片ID --}}
	<div class="add-cover" data-id="{{$detail?$detail['picId']:''}}">
		<span>{{trans('index.cover')}}：</span>
		<a id="cover">点击上传封面</a>
		<input id="upcover" type="file" name="files">
		<div class="img-box">
			<img src=" @if($detail) /image/get/{{$detail['picId']}} @endif">
		</div>
	</div>

	<div class="clear"></div>
	<textarea name="detail" id="ueditor" >{{$detail?$detail['detail']:''}}</textarea>
	<script id="ueditor" name="content" type="text/plain"></script>
	<script type="text/javascript" src="/dist/lib/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="/dist/lib/ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript">
		/*编辑器*/
		var ue = UE.getEditor('ueditor',{
			initialFrameHeight : 500
		});
		ue.ready(function() {
		    //设置编辑器的内容
		   // ue.setContent('请在这里开始游记正文吧...');
		    //获取html内容，返回: <p>hello</p>
		    var html = ue.getContent();
		    //获取纯文本内容，返回: hello
		    var txt = ue.getContentTxt();
		});
	</script>
	<div class="hack"></div>
</div>
@endsection

@section('footer')
@endsection