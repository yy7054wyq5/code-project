@extends('login')

@section('header-scripts')
<script type="text/javascript" src="/js/validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/validate/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/validate/messages_zh.js"></script>
<script type="text/javascript" src="/js/validate/validate-methods.js"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="/js/validate/validation.css">
@endsection

@section('header-search')
<p class="login-header">重设密码</p>
@endsection

@section('content')
<div class="get-back">
	<div class="container set-pass">
		<div class="con">
		<h4>第二步，设置密码</h4>
		<table>
			<tr>
				<td class="nopadding" style="padding-bottom: 0; padding-top: 15px;"><span class="red-font">*</span>新密码</td>
				<td style="padding-bottom: 0;"><input class="form-control" id="pass" type="password"></input></td>
			</tr>
			<tr>
				<td class="tipsbox" colspan="2"></td>
			</tr>
			<tr>
				<td class="nopadding" style="padding-top: 0; padding-bottom: 15px;"><span class="red-font">*</span>确认密码</td>
				<td style="padding-top: 0;"><input class="form-control" id="repass" type="password"></input></td>
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
$(function() {
	$('.btn.sub').click(function(event) {
		if($('#pass').val()==''){
			$('.tipsbox').html('<span class="red-font">*密码不能为空</span>');
			return false;
		}
		else if($('#repass').val()==''){
			$('.tipsbox').html('<span class="red-font">*重复密码不能为空</span>');
			return false;
		}
		else if($('#pass').val()!==$('#repass').val()){
			$('.tipsbox').html('<span class="red-font">*两处密码不一致</span>');
			return false;
		}
		else if($('#pass').val().length<6){
			$('.tipsbox').html('<span class="red-font">*密码长度不低于6位</span>');
			return false;
		}
		
		load($.post('/api/user/resetpassword', 
		{
			username: Cookies.get('name'),
			password: $('#pass').val(),
			repassword: $('#repass').val()
		})).done(function (data) {
			littleTips('密码重设成功，请妥善保管好您的密码');
			location.href = '/';
			Cookies.remove('name');
			// $('h4').text('密码重置成功!');
			// $('.con table').remove();
			// $('.con').append('<p>请妥善保管好您的密码</p><p><a href="/">回到首页</a></p>');
		});
	});

	$('#repass').focusout(function(event) {
		$('.tipsbox').html('');
	});

});
</script>
@endsection