@extends('layouts.main')

@section('banner')
@endsection

@section('header-scripts')
<script type="text/javascript" src="/js/validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/validate/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/validate/messages_zh.js"></script>
<script type="text/javascript" src="/js/validate/validate-methods.js"></script>
@endsection

@section('content')
<div class="invest-detail">
<div class="container">
  <ol class="breadcrumb">
    <li><a href="/innovate" class="red-font" target="_self">创库</a></li><li class="arrow"></li>
    <li><a href="/innovate/invest-list" target="_self" class="red-font">互动调研</a></li>
    <li class="arrow"></li>
    <li>{{$lists->title}}</li>
  </ol>
  <div class="article">
    <h1>{{$lists->title}}</h1>
    <div class="article-infor">有效期：{!! date('Y-m-d',$lists->begintime)!!}-{!! date('Y-m-d', $lists->endtime) !!}</div>
    <div class="con">
      <form id="QAQform">
       {!! $lists->content !!}
        <input name="qid" value="{{$lists->qid}}" type="hidden" />
      <div class="QAQ">
        @if($special)
          @foreach($special as $key => $item )
            <input type="hidden" name="info[{{$item['id']}}][type]" value="{{$item['type']}}" />
            @if($item['type'] == 0)
            <p>{{$key+1}}、{{$item['title']}}<input type="hidden" id="an1" value="{{$item['id']}}"> {{-- 接收选择的值 --}}</p>
            <ul class="QA-box radio-box clear">
              @if(is_array($item['option']))
                @foreach($item['option'] as $key => $subitem)
                  <li><input type="radio" @if($disabled) disabled="disabled" @endif name="info[{{$item['id']}}][answer]" value="{{$subitem}}" id="Q1a">{{$subitem}}</li>
                @endforeach
              @endif
              {{-- 清除浮动用，勿动 --}}
              <li id="clear-box"></li>
            </ul>
            @elseif($item['type'] == 1)
              <p>{{$key+1}}、{{$item['title']}}［可多选］<input type="hidden" id="an3" value="{{$item['id']}}"> {{-- 接收选择的值 --}}</p>
              <ul class="QA-box mt clear">
                @if(is_array($item['option']))
                  @foreach($item['option'] as $subitem)
                   <li><input type="checkbox" @if($disabled) disabled="disabled" @endif name="info[{{$item['id']}}][answer][]" multiple="multiple[]" value="{{$subitem}}" >{{$subitem}}</li>
                  @endforeach
                @endif
                {{-- 清除浮动用，勿动 --}}
                <li id="clear-box"></li>
              </ul>
            @elseif($item['type'] == 2)
              <p>{{$key+1}}、{{$item['title']}} <input type="hidden" id="an3"  value="{{$item['id']}}">  </p>
              <textarea @if($disabled) disabled="disabled" @endif name="info[{{$item['id']}}][answer]" id="pesronSuggest"></textarea>
              @endif
          @endforeach
        @endif

        <p class="your-meg">你的信息</p>
        <div class="meg-box-top"></div>
        <div class="meg-box">
            <table>
                <tr>
                  <td><span  style="margin-left:15px;">经销商名称：</span><input @if($disabled) disabled="disabled" @endif type="text" name="dealer" id="dealer"><span class="error-box"><label id="dealer-error" class="error" for="dealer"></label></span></td>
                  <td><span  style="margin-left:15px;">调研人：</span><input @if($disabled) disabled="disabled" @endif type="text" name="marketAnalyst"><span class="error-box"><label id="marketAnalyst-error" class="error" for="marketAnalyst"></label></span></td>
                  <td><span  style="margin-left:15px;">职位：</span><input @if($disabled) disabled="disabled" @endif type="text" name="personPost" id="personPost"><span class="error-box"><label id="personPost-error" class="error" for="personPost"></label></span></td>
                </tr>
                <tr>
                  <td><span  style="margin-left:46px;">*电话：</span><input @if($disabled) disabled="disabled" @endif type="text" name="mobile" id="mobile" maxlength="11"><span class="error-box"><label id="mobile-error" class="error" for="mobile"></label></span></td>
                  <td><span  style="margin-left:27px;">邮箱：</span><input @if($disabled) disabled="disabled" @endif type="text" name="email" id="email"><span class="error-box"><label id="email-error" class="error" for="email"></label></span></td>
                  <td><span  style="margin-left:15px;">备注：</span><input @if($disabled) disabled="disabled" @endif type="text" name="remark" id="remark"><span class="error-box"><label id="remark-error" class="error" for="remark"></label></span></td>
                </tr>
            </table>
        </div>
          <a class="btn" @if($disabled) disabled="disabled" onclick="littleTips('该问卷不在有效期，请试试其他的吧~');return;" @else id="postForm" @endif role="button">提交</a>
      </div>
    </form>
    </div>
  </div>
</div>
</div>
@endsection

@section('footer-scripts')
<script type="text/javascript" src="/js/loongjoy.invest.js"></script>
@endsection
