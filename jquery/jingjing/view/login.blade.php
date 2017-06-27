@extends('web.main')

@section('body')
<body class="login">
    <div class="top-bg"></div>
    <div class="wrap">
        <div class="top"><span><a href="/" target="_self">首页</a></span>
        </div>
        <div class="login-center">
            <a href="/" target="_self"><img src="/img/web/login_logo.png" class="logo"></a>
            <form>
                <div class="login-box-bg"></div>
                <ul class="login-box">
                    <li><i class="user-name"></i><input type="text"  id="loginName" value="请输入手机号码" /></li>
                    <li><i class="pass-word"></i><input type="password"  id="loginPass"/></li>
                    <li class="no-bg"><a class="jjbtn"  target="_self">登录</a>{{-- <a href="">忘记密码？</a><span>|</span> --}}<a href="/web/reg" target="_self" class="reg-btn">注册新账户</a></li>
                </ul>
            </form>
        </div>
        <div class="bottom"></div>
    </div>
</body>
@endsection
