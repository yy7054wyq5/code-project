@extends('web.user.layouts.main')
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
@section('user-content')
<div class="user-container invest-detail">
@if($detail)
	
	<h1>{{$detail[0]['htitle']}}</h1>
	
	<div class="invest-infor"></div>
	<div class="con">
	      <form id="QAQform" action="/{{Config('app.locale')}}/zh/user/answer" novalidate="novalidate">
	      <input type="hidden" name="qid" value="{{$qid}}">
	      <div class="QAQ">	                           
	      	@foreach($detail as $key=>$invest)
                  <p>{{$key+1}}、{{$invest['title']}}
	              <ul class="QA-box mt clear">
	              @foreach(unserialize($invest['option']) as $option)
                 	<li><input type="checkbox" data-answer="{{$invest['answer']}}" @if(mb_substr_count($invest['answer'],$option)) checked="checked" @endif name="answer[{{$invest['id']}}][]"  @if($invest['answer']) disabled="" @endif value="{{$option}}">{{$option}}</li>  
                  <li id="clear-box"></li>
                  @endforeach
	              </ul>    
	        @endforeach      
	          <a class="btn" @if($invest['answer']) disabled="" @endif type="submit" role="button">提交</a>
	      </div>
	    </form>
    </div>
    
@endif    
</div>
@endsection

@section('footer-scripts')
	@parent
	<script type="text/javascript">
     $(function() {
     	$('.btn').on('click',function(){
 		 	$.ajax({
            url: '/{{Config('app.locale')}}/user/answer',
            data: $('form').serialize(),
            type: 'post',
            dataType: 'json',
            context: this,
            beforeSend: function () {
                $(':submit', this).attr('disabled', '');
            },
            complete: function () {
                $(':submit', this).removeAttr('disabled');
            },
            success: function (data) {
                //console.log(data)
      			alert(data.msg);
            }
     	});
     });	
    }); 	
	</script>
@endsection