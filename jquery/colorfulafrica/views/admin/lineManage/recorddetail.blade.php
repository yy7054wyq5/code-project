@extends('admin.adminbase')
@section('title', '记录')
@section('content')
<div class="dialog-demo-box" style="display:none;"></div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">答题记录</h3>
        </div>
        <div class="box-body">
        <div class="container-fluid">
        	<div class="row">
	        @if ($detail)
	        	<h4>{{$detail[0]['htitle']}}</h4><br/>
	        	
	            @foreach($detail as $key=>$data)
	           {{$key+1}}、{{$data['title']}}<br/>
	            	<ul>
		          		@foreach(unserialize($data['option']) as $option)
		                	<input type="checkbox" @if(mb_substr_count($data['answer'],$option)) checked="" @endif disabled="" />{{$option}}
		                	
		                 @endforeach
		                
	               </ul>
	            @endforeach
	        	
	        @endif
	        </div>
        </div>         
        </div>
        <div class="box-footer">
         
        </div>
    </div>
@endsection