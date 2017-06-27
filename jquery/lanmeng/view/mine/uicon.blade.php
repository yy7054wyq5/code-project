@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-setting" id="j_uc_uicon">
    <div class="uc-setting-header">
      <div class="w-tab">
        <div class="w-tab-item"><a href="/mine/setting">基本信息</a></div>
        <div class="w-tab-item active"><a href="/mine/setting/uicon">头像照片</a></div>
      </div>
    </div>
    <div class="uicon tabCont active">
      <form>
        <a href="javascript:;" class="upload" id="uploadBtn">选择您要上传的头像</a>
        <div class="upload-info">
          <div class="prog">
            <div class="wrap"><div class="in"></div></div>
            <span class="pct">0%</span>
          </div>
          <span class="msg"></span>
        </div>
        <p>仅支持JPG、GIF、PNG、JPEG、BMP格式, 文件小于2M</p>
        <div class="preview">
          <div class="view1">
            <div class="in"><img src="{{{ $uicon ? $uicon : '/img/mine/me_home_hp_nor.jpg' }}}"></div>
          </div>
          <div class="side">
            <p>您上传的头像会自动生成两种尺寸，请注意小尺寸的头像是否清晰</p>
            <div class="view2"><img src="{{{ $uicon ? $uicon : '/img/mine/me_home_hp_nor.jpg' }}}"></div>
            <div class="view3"><img src="{{{ $uicon ? $uicon : '/img/mine/me_home_hp_nor.jpg' }}}"></div>
          </div>
        </div>
        <input type="submit" value="保存" class="submit" id="submitBtn">
      </form>
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
