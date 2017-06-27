@extends('login')

@section('header-scripts')
<script type="text/javascript" src="/js/validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/validate/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/validate/messages_zh.js"></script>
<script type="text/javascript" src="/js/validate/validate-methods.js"></script>
<script type="text/javascript" src="/js/loongjoy.reg.js"></script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?d56bba6bf3c28cf93142896f846bc6f7";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="/js/validate/validation.css">
<style type="text/css">
  body{background-color: #f5f5f5;}
  .footer{background-color: #f5f5f5;}
  .code-img{
      float: left;display: block; margin-left: 10px; cursor: pointer;
  }
  .tips{
    position: absolute;
    left: 8px;
    top: 29px;
    z-index: 2;
    color: #999999;
  }
</style>
@endsection

@section('header-search')
<p class="login-header">欢迎注册</p>
@endsection

@section('content')
<div class="reg-main">
  <div class="container">
    <p class="loginP">我已经注册，现在就<a href="/login" target="_self" class="blue-font">登录</a></p>
    <div class="myclear"></div>
    <div class="reg-box input-group">
      <form id="regForm">
        <table>
        <tbody>
          <tr>
            <td width="100"><span class="red-font">*</span>用户名：</td>
            <td width="266"><input type="text" class="form-control" placeholder="" name="username" id="username" maxlength="15"></td>
            <td width="412" class="label-box"><label id="username-error" class="error" for="username"></label></td>
          </tr>
          <tr>
            <td><span class="red-font">*</span>设置密码：</td>
            <td><input type="password" class="form-control" placeholder="" name="password" id="password" maxlength="16"></td>
            <td align="left" class="label-box"><label id="password-error" class="error" for="password"></label></td>
          </tr>
          <tr>
            <td><span class="red-font">*</span>密码确认：</td>
            <td><input type="password" class="form-control" placeholder="" name="rePassword" id="rePassword" maxlength="16"></td>
            <td align="left" class="label-box"><label id="rePassword-error" class="error" for="rePassword"></label></td>
          </tr>
          <tr>
            <td><span class="red-font">*</span>手机号：</td>
            <td><input type="text" class="form-control" placeholder="" name="mobile" id="mobile" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " maxlength="11"></td>
            <td align="left" class="label-box"><label id="mobile-error" class="error" for="mobile"></label></td>
          </tr>
          <tr>
            <td><span class="red-font">*</span>验证码：</td>
            <td style="position: relative;"><input type="text" class="form-control" placeholder="" name="frontCode" id="frontCode" maxlength="3" style="width: 156px;"><img src="/api/user/vailcode" width="100" height="38" class="code-img" title="点击图片刷新验证码"><div class="tips">请输入正确的计算结果</div></td>
            <td align="left" class="label-box"><label id="frontCode-error" class="error" for="frontCode"></label></td>
          </tr>
          <tr>
            <td><span class="red-font">*</span>短信验证码：</td>
            <td><input type="text" class="form-control" placeholder="" name="code" id="code" maxlength="4"><a class="send mobileCode">获取短信验证码</a></td>
            <td align="left" class="label-box"><label id="code-error" class="error" for="code"></label></td>
          </tr>
          <tr>
            <td><span class="red-font"></span>推荐人：</td>
            <td><input type="text" class="form-control" placeholder="" name="recommend" id="recommend"></td>
            <td>&nbsp;&nbsp;填写推荐人帐号，非必填</td>
          </tr>
          <tr>
            <td colspan="2" class="last-td">
                <p><input type="checkbox" id="protocol" name="protocol" checked="checked">我已经阅读并同意《<a role="button" class="blue-font" data-toggle="modal" data-target="#myModal">蓝网用户注册协议</a>》</p>
                <div class="clear"></div>
                <a role="button" class="detail-btn">立即注册</a>
            </td>
            <td valign="top" style="padding-top:0;" align="left" class="label-box"><label id="protocol-error" class="error" for="protocol"></label></td>
          </tr>
        </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
@endsection

 {{-- 模态框 --}}
@section('modal')
  @include('layouts.modal')
@endsection

@section('footer-scripts')
  @parent
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
          if(Cookies.get('regCode')>0){
              var times = Cookies.get('regCode')-1;
              if(times==0){
                  Cookies.remove('regCode');
                  $('.send.mobileCode').removeClass('wait').text('获取短信验证码');
                  return false;
              }
              $('.send.mobileCode').addClass('wait').text('还有'+times+'s');
              var countDown = setInterval(function () {
                  times = times - 1;     
                  if(times<=0){
                      Cookies.remove('regCode');
                      $('.send.mobileCode').removeClass('wait').text('获取短信验证码');
                  }
                  else{
                      Cookies.set('regCode',times);
                      $('.send.mobileCode').text('还有'+times+'s');
                  }   
              },1000);
              setTimeout(function () {
                  window.clearInterval(countDown);
              },times*1000);
          }
          else{
              Cookies.remove('regCode');
          }
      });
  </script>
@endsection