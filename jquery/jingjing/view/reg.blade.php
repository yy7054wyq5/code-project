@extends('web.main')

@section('body')
<body class="register">
    <div class="top-bg">
        <div class="wrap">
            <div class="top">
                <span>
                <a href="/" target="_self">首页</a>
                <a href="/web/login" target="_self">登录</a>
                </span>
            </div>
            <div class="reg-center">
                <a href="/" target="_self"><img src="/img/web/register_icon.png" class="logo"></a>
                <form id="regForm">
                <table class="reg">
                    <tr>    
                        <td>用户名</td>
                        <td width="725"><input type="text" id="nickname"/><label class="error"></label></td>
                    </tr>
                    <tr>    
                        <td>密码</td>
                        <td><input type="password" id="password" /><label class="error"></label></td>
                    </tr>
                    <tr>    
                        <td>确认密码</td>
                        <td><input type="password" id="rePassword" /><label class="error"></label></td>
                    </tr>
                    <tr>    
                        <td>手机号</td>
                        <td><input type="text" id="mobile" onkeyup="this.value=this.value.replace(/[^\d]/g,'') "   onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "/><label class="error"></label></td>
                    </tr>
                    <tr>    
                        <td>验证码</td>
                        <td class="captcha-box"><input type="text"  class="last-input" id="captcha" ><a class="send">发送验证码</a><label class="error"></label><img src="/img/web/loading.gif" class="loading"></td>
                    </tr>
                </table>
                <a class="jjbtn" role="button">快速注册</a>
                </form>
            </div>
            <div class="bottom"></div>
        </div>
    </div>
</body>
@endsection