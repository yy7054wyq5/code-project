@extends('mine.fragment.layout')


@section('uc-content')
<div class="uc-main-main">
  <div class="uc-pwd" id="j_uc_pwd">
    <div class="uc-pwd-header">
      <div class="w-tab">
        <div class="w-tab-item active"><a href="/mine/pwd">修改登录密码</a></div>
        <div class="w-tab-item"><a href="/mine/pwd/phone">修改手机号</a></div>
      </div>
    </div>
    <div class="uc-pwd-body">
      <form autocomplete="off" novalidate>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="uc-pwd-row">
          <div class="uc-pwd-label">原密码：</div>
          <div class="uc-pwd-cont">
            <input type="password" name="oldPwd" class="i-ipt" placeholder="输入原密码">
            <div class="help"></div>
          </div>
        </div>
        <div class="uc-pwd-row">
          <div class="uc-pwd-label">新密码：</div>
          <div class="uc-pwd-cont">
            <input type="password" id="newPwd" name="newPwd" class="i-ipt" placeholder="输入新密码">
            <div class="help"></div>
          </div>
        </div>
        <div class="uc-pwd-row">
          <div class="uc-pwd-label">密码强度：</div>
          <div class="uc-pwd-cont">
            <div class="lv" id="j_pwd_strength">
              <span class="lv-item low"></span>
              <span class="lv-item mid"></span>
              <span class="lv-item high"></span>
            </div>
          </div>
        </div>
        <div class="uc-pwd-row">
          <div class="uc-pwd-label">确认密码：</div>
          <div class="uc-pwd-cont">
            <input type="password" name="reNewPwd" class="i-ipt" placeholder="确认新密码">
            <div class="help"></div>
          </div>
        </div>
        <div class="uc-pwd-row">
          <div class="uc-pwd-label"></div>
          <div class="uc-pwd-cont">
          <button type="submit" class="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
