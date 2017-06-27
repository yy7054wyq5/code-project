<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?= Config::get('app.appCnName')?> 平台管理系统</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/AdminLTE.min.css">
	<link rel="stylesheet" href="/css/_all-skins.min.css">
	<link rel="stylesheet" href="/css/font-awesome.min.css">
	<link rel="stylesheet" href="/css/main.css">
</head>
<body class="skin-blue">
	<div class="login-page" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;">
		<div class="login-box">
			<div class="login-logo">
				<a href=""><?= Config::get('app.appCnName')?> 平台管理系统</a>
			</div>
			<div class="login-box-body">
				<h4>用户登录</h4>
				<form id="loginForm" action="/backstage/index/logging" method="post" m-bind="ajax">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="jurl" value="{{request('jurl')}}">

					<!-- 错误提示 -->
					<div class="alert alert-danger errMsgBox">
						<button class="close">&times;</button>
						<div class="result"></div>
					</div>

					<div class="form-group has-feedback">
						<input name="username" type="text" class="form-control" placeholder="请输入用户名">
						<span class="fa fa-user form-control-feedback" style="line-height: 34px;"></span>
					</div>
					<div class="form-group has-feedback">
						<input name="password" type="password" class="form-control" placeholder="请输入密码">
						<span class="fa fa-lock form-control-feedback" style="line-height: 34px;"></span>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-8">
								<input name="captcha" class="form-control" type="text" placeholder="请输入验证码">
							</div>
							<div class="col-xs-4" id="captcha">
								<img style="width: 100%;height: 34px;"  class="captcha" src="/backstage/index/captcha" alt="" data-url="/backstage/index/captcha">
							</div>
						</div>
					</div>
					<div class="form-group">
							<button type="submit" class="btn btn-primary btn-flat form-control">登录</button>
					</div>
				</form>
				{{--<a href="/js/jquery-1.11.2.min.js" class="text-right">找回密码</a>--}}
			</div>
		</div>
	</div>



<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/app.min.js"></script>
{{--<script src="/js/bootstrap-datepicker.min.js"></script>--}}

<script>
    $('#captcha').click(function(){
        $(this).find('img').attr("src",'/backstage/index/captcha?t=' +Math.random());
    });
</script>
</body>
</html>