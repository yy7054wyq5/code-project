@extends('web.user.layouts.main')
<script type="text/javascript" src="/dist/lib/jquery/dist/jquery.min.js"></script>
<style>
	.list>li>ul>li{
		float: left;
	}
</style>
@section('user-content')
<div class="user-container ">
	<div class="user-tab">	
	</div>
	<form action="" onsubmit="return false;">
	<ul class="list active">
	@if($detail)
	@foreach($detail as $invest)
		<li>{{$invest['title']}}
			<ul>
			@foreach(unserialize($invest['option']) as $option)
				<li><input type="checkbox" @if(mb_substr_count($invest['answer'],$option)) checked="checked" @endif name="answer[{{$invest['id']}}]" value="{{$option}}">{{$option}}</li>
			@endforeach	
			</ul>
		</li>
	@endforeach	
	@endif
	</ul>
	<button type="submit"  class="submit-comment">提交</button>
	</form>
</div>
<script>
	$(function () {
		var url= window.location.href;
		var qid = url.substring(url.lastIndexOf('/') + 1);
		$('button[type=submit]').on('click',function(){
			$answers=$(':checkbox[checked=checked]');
			var answerArr = new Array();
			$answers.each(function(i,value){
				answerArr.push(value);
			});
			$.post('/{{Config('app.locale')}}/user/answer',{'qid':qid,'answer':answerArr},function(){
				
			});
		});
		
	});
</script>
@endsection