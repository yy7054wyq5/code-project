@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-comment2" id="j_uc_comment">
    <div class="uc-comment2-header">
      <div class="title">我要留言</div>
    </div>
    <div class="uc-comment2-body">
      <form id="j_comment" autocomplete="off" novalidate>
        <div class="cmt">
          <div class="cmt-w">
            <div class="cmt-u">
              <div class="cmt-label">姓名：</div>
              <div class="cmt-cont"><input type="text" name="username" class="i-ipt"></div>
            </div>
            <div class="cmt-u">
              <div class="cmt-label">联系方式：</div>
              <div class="cmt-cont"><input type="text" name="linktype" class="i-ipt"></div>
            </div>
            <div class="cmt-u">
              <div class="cmt-label">公司名称：</div>
              <div class="cmt-cont"><input type="text" name="company" class="i-ipt"></div>
            </div>
            <div class="cmt-u">
              <div class="cmt-label">邮箱：</div>
              <div class="cmt-cont"><input type="text" name="email" class="i-ipt"></div>
            </div>
          </div>
          <div class="cmt-r">
            <textarea name="content" placeholder="亲，留下您的意见或建议以便我们继续改进！"></textarea>
          </div>
        </div>
        <button type="submit" class="cmt-submit">提交</button>
        <div class="cmt-help"></div>
      </form>
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
