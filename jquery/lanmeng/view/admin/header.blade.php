<!DOCTYPE html>
<html lang="zh">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="renderer" content="webkit">
	<meta charset="utf-8">
	<title><?=Config::get('app.appName')?>管理系统</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{!!HTML::script('super/super/js/html5shiv.min.js') !!}"></script>
    <script src="{!!HTML::script('super/super/js/respond.min.js') !!}"></script>
    <![endif]-->
	<!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/loongjoyIE.css">
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	{!!HTML::style('super/css/cloud-admin.css')!!}
	{!!HTML::style("super/css/themes/default.css") !!}
    {!!HTML::style("super/css/responsive.css") !!}
    {!!HTML::style("super/font-awesome/css/font-awesome.min.css") !!}
	<!-- DATE RANGE PICKER -->
	{!!HTML::style("super/js/bootstrap-daterangepicker/daterangepicker-bs3.css") !!}
	<!-- FONTS -->
	{!!HTML::style("super/css/css.css") !!}

	{!!HTML::style("super/js/datatables/media/css/jquery.dataTables.min.css") !!}
	<!-- JAVASCRIPTS -->
	{!!HTML::script('super/js/jquery/jquery-2.0.3.min.js') !!}
</head>
<body>
<header class="navbar clearfix navbar-fixed-top" id="header">
	<div class="container">
		<div class="navbar-brand">
			<a href="/superman">
				<img src="/super/img/logo/logo.png" alt="Cloud Admin Logo" class="img-responsive" height="30" width="120">
			</a>
			<div class="visible-xs">
				<a href="#" class="team-status-toggle switcher btn dropdown-toggle">
					<i class="fa fa-users"></i>
				</a>
			</div>
			<div id="sidebar-collapse" class="sidebar-collapse btn">
				<i class="fa fa-bars" data-icon1="fa fa-bars" data-icon2="fa fa-bars" ></i>
			</div>
		</div>
		<ul class="nav navbar-nav pull-left hidden-xs" id="navbar-left">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-cog"></i>
					<span class="name">快捷</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu skins">
					<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/" target="_blank" data-skin="default">网站首页</a></li>
				</ul>
			</li>
		</ul>
		<ul class="nav navbar-nav pull-right">
			<li class="dropdown user" id="header-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<!-- <img alt="" src="/super/img/avatars/avatar3.jpg" /> -->
					<span class="username"><?=Session::get('user.adminusername')?></span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="/superman/user/upassword"><i class="fa fa-user"></i>密码修改</a></li>
					<li><a href="/superman/index/loginout"><i class="fa fa-power-off"></i>退出登录</a></li>
				</ul>
			</li>
		</ul>
	</div>
</header>
<section id="page">
@include('admin.left')