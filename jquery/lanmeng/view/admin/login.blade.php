<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="renderer" content="webkit">
	<meta charset="utf-8">
	<title><?=Config::get('app.appName')?>管理系统</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!--[if lt IE 9]>
	<script src="js/flot/excanvas.min.js"></script>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js">
	</script>
	<![endif]-->
	{!!HTML::style('super/css/cloud-admin.css')!!}
    {!!HTML::style("super/font-awesome/css/font-awesome.min.css") !!}
    {!!HTML::style("super/js/bootstrap-daterangepicker/daterangepicker-bs3.css") !!}
    {!!HTML::style("super/js/uniform/css/uniform.default.min.css") !!}
    {!!HTML::style("super/css/animatecss/animate.min.css") !!}

	{!!HTML::style("super/css/css.css") !!}
</head>
<body class="login">	
	<!-- PAGE -->
	<section id="page">
			<!-- LOGIN -->
			<section>
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box-plain">
								<h2 class="bigintro">Sign In</h2>
								<div class="divide-40"></div>
								<form onsubmit="return false;">
								  <div class="form-group">
								  	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
									<label for="username">用户名</label>
									<i class="fa fa-envelope"></i>
									<input type="text" class="form-control" name="username" id="username" >
								  </div>
								  <div class="form-group"> 
									<label for="password">密&nbsp;&nbsp;&nbsp;码</label>
									<i class="fa fa-lock"></i>
									<input type="password" class="form-control" name="password" id="password" >
								  </div>
								  <div class="form-actions">
									<button type="submit" onclick="dologin();" class="btn btn-danger">登录</button>
								  </div>
								</form>
								<!-- /SOCIAL LOGIN -->
								<!-- <div class="login-helpers">
									忘记密码?<a href="#" onclick="swapScreen('forgot');return false;">点击</a>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/LOGIN -->
	</section>
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	{!!HTML::script('super/js/jquery/jquery-2.0.3.min.js') !!}
	{!!HTML::script('super/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js') !!}
	{!!HTML::script('super/bootstrap-dist/js/bootstrap.min.js') !!}
	{!!HTML::script('super/js/uniform/jquery.uniform.min.js') !!}
	{!!HTML::script('super/js/script.js') !!}
	{!!HTML::script('super/layer/layer.js') !!}
	<script>
		jQuery(document).ready(function() {		
			App.setPage("login");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<script type="text/javascript">
		/*function swapScreen(id) {
			jQuery('.visible').removeClass('visible animated fadeInUp');
			jQuery('#'+id).addClass('visible animated fadeInUp');
		}*/
		// ajax表单
		function dologin(){

			$.post("/superman/index/logging", {username: $("#username").val(), password : $("#password").val(), _token : $("#token").val()}, function(data){
				if (data['status'] == 0) {
					layer.msg("登录成功");
					//document.write(data['content']);
					location.href = data['url'];
				} else {
					layer.msg("登录失败");
				}
	        }, "json");
		}
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>