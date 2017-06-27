@extends('login')

@section('header-scripts')
<script type="text/javascript" src="/js/validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/validate/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/validate/messages_zh.js"></script>
<script type="text/javascript" src="/js/validate/validate-methods.js"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="/js/validate/validation.css">
<link rel="stylesheet" href="/js/validate/validation.css">
<style type="text/css">
  .tips{
    position: absolute;
    left: 23px;
    top: 7px;
    z-index: 2;
    color: #999999;
  }
</style>
@endsection

@section('header-search')
<p class="login-header">找回密码</p>
@endsection

@section('content')
<div class="get-back">
	<div class="container">
		<div class="con">
		<h4>第一步，输入用户名</h4>
		<table>
			<tr>
				<td class="nopadding" style="padding-bottom: 0; padding-top: 15px;"><span class="red-font">*</span>用户名</td>
				<td style="padding-bottom: 0;"><input class="form-control" id="username"></td>
			</tr>
			<tr>
				<td class="tipsbox one" colspan="2"></td>
			</tr>
			<tr>
				<td class="nopadding" style="padding-top: 5px;"><span class="red-font">*</span>验证码</td>
				<td style="padding-top: 0; padding-bottom: 0; position: relative;" class="float"><input class="form-control" id="frontCode" maxlength="3" name="frontCode"><img src="/api/user/vailcode" width="100" height="34" class="code-img" style="margin-left: 12px; cursor: pointer;" title="点击图片刷新验证码"><div class="tips">请输入正确的计算结果</div></td>
			</tr>
			<tr>
				<td class="tipsbox two" colspan="2"></td>
			</tr>
			<tr>
				<td class="nopadding" style="padding-top: 0; padding-bottom: 15px;"><span class="red-font">*</span>短信验证码</td>
				<td class="float" style="padding-top: 0;"><input class="form-control" id="code"><a role="button" class="btn code send">获取验证码</a></td>
			</tr>
			<tr>
				<td colspan="2">
					<a class="btn sub">提交</a>	
				</td>
			</tr>
		</table>	
		</div>
	</div>
</div>
@endsection

@section('footer-scripts')
<script type="text/javascript">
//提示输入计算结果
$('.tips').click(function(event) {
    $(this).remove();
    $('input[name="frontCode"]').focus();
});
$('input[name="frontCode"]').focusin(function () {
    $(this).siblings('.tips').remove();
});
$(function() {
	//验证用户名
	$('#username').focusout(function(event) {
		if($('#username').val()==''){
			$('.tipsbox.one').html('<span class="red-font">*请输入用户名</span>');
			return false;
		}
		$('.tipsbox.one').html('<img src="/img/sloading.gif" style="height:20px;">');
		$.post('/api/user/checkusername/'+$('#username').val(), function(data, textStatus, xhr) {
			if(data.status==0){
				$.post('/api/user/getmobile/'+$('#username').val(), function(data) {
					$('.tipsbox.one').html('手机号：'+data.tips);
				});
			}
			else{
				$('.tipsbox.one').html('<span class="red-font">*用户名不存在</span>');	
			}
		});	
	});

	//发送验证码
	$('.code').click(function(event) {
		if($('#username').val()==''){
			$('.tipsbox.one').html('<span class="red-font">*请输入用户名</span>');
			return false;
		}
		else if($('#frontCode').val()==''){
			$('.tipsbox.two').html('<span class="red-font">*请输入右图的验证码</span>');
			return false;
		}
		else if($(this).hasClass('wait')){
			$('.tipsbox.one').html('请稍候');
			return false;
		}
		//$('.tipsbox.one').html('<img src="/img/sloading.gif" style="height:20px;">');
		$.get('/api/user/checkvailcode', {code: $('#frontCode').val()}, function(data, textStatus, xhr) {
			if(data.status==0){
				$.post('/api/user/sendmessage/'+$('#username').val(), function(data, textStatus, xhr) {
					if(data.status==0){
						$('.tipsbox.two').html('短信验证码发送成功');
						$('.send').addClass('wait');
						$('.send').text('还有60秒');
						var time = 60;
						var a = setInterval(function () {
							time = time - 1;
							$('.send').text('还有'+time+'秒');
						},1000);
						setTimeout(function () {
							$('.send').text('重新发送').removeClass('wait');
							window.clearInterval(a);
						},60000);
					}
					else{
						$('.code-img').attr('src', '/api/user/vailcode/'+parseInt(Math.random()*10000000000000)+'');  
					}
				});
			}
			else{
				$('.tipsbox.two').html('<span class="red-font">*图片'+data.tips+'</span>');
			}
		});


	});

	//验证验证码
	$('.btn.sub').click(function(event) {
		if($('#username').val()==''){
			$('.tipsbox.one').html('<span class="red-font">*请输入用户名</span>');
			return false;
		}
		else if($('#frontCode').val()==''){
			$('.tipsbox.two').html('<span class="red-font">*请输入右图的验证码</span>');
			return false;
		}
		else if($('#code').val()==''){
			$('.tipsbox.two').html('<span class="red-font">*请输入短信验证码</span>');
			return false;
		}
		load($.post('/api/user/checkcode', {code: $('#code').val(),username: $('#username').val()}))
		.done(function (data) {
			if(data.status==0){
			    Cookies.set('name',$('#username').val());
			    location.href = '/setpass';
			}
			else{
			    $('.tipsbox.two').html('<span class="red-font">'+data.tips+'</span>');
			}
		});
		
	});
	
	//刷验证码
	$(document).on('click', '.code-img', function(event) {
	    $('.code-img').attr('src', '/api/user/vailcode/'+parseInt(Math.random()*10000000000000)+'');
	    $('input[name="frontCode"]').val('');
	});
});
</script>
@endsection