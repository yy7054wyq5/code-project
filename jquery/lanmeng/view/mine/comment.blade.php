@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-comment" id="j_uc_comment">
    <div class="uc-comment-header">
      <div class="title">我的留言 <small>共{{ $count }}条留言</small></div>
      <div class="side">
        <a href="/mine/comment/leave" class="ubtn">我要留言</a>
      </div>
    </div>
    <div class="uc-comment-body">
      <div class="cmt-list">
        @if(count($lists))
        @foreach($lists as $value)
        <div class="cmt-item">
          <div class="cmt-title">您在{{ date('Y-m-d H:i', $value->created) }}对本网站发表了留言 <a class="toggle" href="javascript:;">[收起]</a></div>
          <div class="cmt-cont">
            <p>{{ $value->username }}</p>
            <div class="meta">
              <span>{{ $value->company }}</span>
              <span>{{ $value->linktype }}</span>
              <span>{{ $value->email }}</span>
            </div>
            <p>{{ $value->content }}</p>
          </div>
        </div>
        @endforeach
        @else
        <div class="cmt-empty">暂无留言</div>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
