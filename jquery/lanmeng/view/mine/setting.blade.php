@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-setting" id="j_uc_setting">
    <div class="uc-setting-header">
      <div class="w-tab">
        <div class="w-tab-item active"><a href="/mine/setting">基本信息</a></div>
        <div class="w-tab-item"><a href="/mine/setting/uicon">头像照片</a></div>
      </div>
    </div>
    <div class="uinfo tabCont active">
      <form class="uif" autocomplete="off" novalidate>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="uinfo-panel">
          <div class="pic"><img src="{{{ $uicon ? $uicon : '/img/mine/me_home_hp_nor.jpg' }}}"></div>
          <p class="nickname">用户名：&ensp;{{ $info->username }}</p>
          <p class="lv"><img src="/img/mine/lv/me_home_grow_ic2_v{{ $info->level }}.png"><span>V{{ $info->level }}会员</span></p>
          <p class="type">会员类型：&ensp;个人用户</p>
        </div>
        <div class="errBox"></div>
        <div class="uinfo-row">
          <label class="uinfo-label"><b>*</b>昵称：</label>
          <div class="uinfo-cont">
            <input type="text" class="i-ipt" value="{{ $info->nickname ? $info->nickname : $info->username }}" name="nickname" tabindex="1">
            <p class="help">2-10位字符，支持汉字、字母、数字及 ‘-’ 、 ‘_’ 任意<br>以上两种组合</p>
          </div>
        </div>
        <div class="uinfo-row">
          <label class="uinfo-label">生日：</label>
          <div class="uinfo-cont">
            <select class="i-select year" name="year" tabindex="2">
              <option value="">年</option>
              <?php $nowY = date('Y');?>
              @for($i = 1900; $i <= $nowY; $i++)
              <option value="{{ $i }}" @if($i == $info['birth_y']) selected @endif>{{ $i }}</option>
              @endfor
            </select>
            <select class="i-select month" name="month" tabindex="3">
              <option value="">月</option>
              @for($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}" @if($i == $info['birth_m']) selected @endif>{{ $i }}</option>
              @endfor
            </select>
            <select class="i-select day" name="day" tabindex="4">
              <option value="">日</option>
              @if($dayLen)
              @for($i = 1; $i <= $dayLen; $i++)
              <option value="{{ $i }}" @if($i == $info['birth_d']) selected @endif>{{ $i }}</option>
              @endfor
              @endif
            </select>
          </div>
        </div>
        <div class="uinfo-row">
          <label class="uinfo-label">性别：</label>
          <div class="uinfo-cont">
            <label class="sex"><input type="radio" name="sex" class="i-radio" tabindex="5" value="0" @if($info['sex']==0) checked @endif>&ensp;男</label>
            <label class="sex"><input type="radio" name="sex" class="i-radio" tabindex="6" value="1" @if($info['sex']==1) checked @endif>&ensp;女</label>
          </div>
        </div>
        <div class="uinfo-row">
          <div class="uinfo-label">手机号：</div>
          <div class="uinfo-cont"><b>{{ substr($info->mobile, 0, 3) }}****{{ substr($info->mobile, 7, 4) }}</b><a href="/mine/pwd/phone" class="edit">修改</a></div>
        </div>
        <div class="uinfo-row">
          <div class="uinfo-label">邮箱：</div>
          <div class="uinfo-cont">
            <input type="text" class="i-ipt" value="{{ $info->email }}" tabindex="7" name="email" id="email">
          </div>
        </div>
        <div class="uinfo-row">
          <div class="uinfo-label">QQ：</div>
          <div class="uinfo-cont">
            <input type="text" class="i-ipt" value="{{ $info->qq }}" tabindex="8" name="qq">
          </div>
        </div>
        <div class="uinfo-row">
          <label class="uinfo-label">联系人：</label>
          <div class="uinfo-cont">
            <input type="text" class="i-ipt" value="{{ $info->realname }}" name="linkman">
          </div>
        </div>
        <div class="uinfo-row">
          <div class="uinfo-label"></div>
          <div class="uinfo-cont">
            <input type="submit" value="保存" class="submit">
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
