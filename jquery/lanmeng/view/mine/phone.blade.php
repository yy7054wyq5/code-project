@extends('mine.fragment.layout')


@section('uc-content')
<div class="uc-main-main">
  <div class="uc-phone" id="j_uc_phone">
    <div class="uc-phone-header">
      <div class="w-tab">
        <div class="w-tab-item"><a href="/mine/pwd">修改登录密码</a></div>
        <div class="w-tab-item active"><a href="/mine/pwd/phone">修改手机号</a></div>
      </div>
    </div>
    <div class="uc-phone-body">
      <div class="w-step w-step-phone">
        <div class="w-step-item on">
          <i>1</i>
          <span>验证新手机</span>
        </div>
        <div class="w-step-item">
          <i class="check"></i>
          <span>修改结果</span>
        </div>
      </div>
      <form autocomplete="off" novalidate>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <table>
          <col span="1" width="280"></col>
          <col span="1" width="170"></col>
          <col span="1" width="300"></col>
          <tr>
            <td class="text-right">新手机号码:</td>
            <td><input type="text" class="i-ipt" name="mobile" id="mobile"><div class="help"></div></td>
            <td></td>
          </tr>
          <!-- <tr>
            <td class="text-right">登录密码:</td>
            <td><input type="password" name="password" class="i-ipt"><div class="help"></div></td>
            <td></td>
          </tr> -->
          <tr>
            <td class="text-right">验证码:</td>
            <td><input type="text" class="i-ipt" name="code" id="captcha"><div class="help"></div></td>
            <td><a href="javascript:;" id="captchaBtn" class="ubtn">获取验证码</a><div class="help"></div></td>
          </tr>
          <tr>
            <td></td>
            <td><button type="submit" class="submit">提交</button></td>
            <td></td>
          </tr>
        </table>
      </form>
      <p class="result"><img class="check" src="/img/mine/me_home_set_ic_ok.png">恭喜您，修改验证手机号码成功!</p>
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection

