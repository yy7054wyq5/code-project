@extends('layouts.main')

@section('menu')
@endsection

@section('banner')
@endsection

@section('header-search')
<p class="login-header">欢迎登录</p>
@endsection

@section('content')
<div class="container login-main">
  <div class="login-adv">
    <table>
      <tr>
        <td><a href="" target="_self"></a><img src="/img/login-adv.png"></td>
      </tr>
    </table>
  </div>
  <div class="login-box">
    <h1>蓝网会员登录</h1>
    <div class="input-group">
        <input type="text" class="form-control login-username" name="username" placeholder="用户名">
        <label class="tips" id="ajaxTips">用户名不能为空</label>
        <input type="password" class="form-control login-password" name="password" placeholder="密码">
        <label class="tips">用户名不能为空</label>
        <a class="detail-btn" role="button">登录</a>
        <input type="checkbox" checked="checked" class="autoLogin">自动登录
        <a role="button" style="margin-left: 120px;" href="/getback">找回密码？</a>
    </div>
    <a class="go-reg" role="button" href="/reg" target="_self">立即注册</a>
  </div>
</div>
<div class="myclear"></div>
@endsection

{{-- 登录注册底部 --}}
@section('footer')
<div class="login-footer">
  <div class="container footer">
    <table>
      <tr class="font12">
        <td colspan="2"><a href="/help/25" target="_self">关于我们</a>|
        <a href="/help/26" target="_self">联系我们</a>|
        <a href="/help/27" target="_self">法律声明</a>|
        <a href="/help/28" target="_self">服务条款</a>|
        <a href="/help/29" target="_self">隐私声明</a>|
        <a href="/help/1" target="_self">帮助中心</a></td>
      </tr>
      <tr>
        <td colspan="2">上海祎策数字科技有限公司 版权所有 Copyright © 2009-2016 沪ICP备12031561号-1</td>
      </tr>
    </table>
  </div>
</div>
@endsection

@section('footer-scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var $loginMain = $('.container.login-main');
        var $loginFooter = $('.login-footer');
        var sHeight = document.body.clientHeight;
        var wHeight = window.screen.height; 
        $loginMain.css('margin-top', (wHeight-sHeight)/4);
        $loginFooter.css('margin-top', (wHeight-sHeight)/3); 
        if(wHeight<=768){
            $loginMain.css('margin-top', 0);
            $loginFooter.css('margin-top', 0); 
        }
    });
</script>
@endsection
