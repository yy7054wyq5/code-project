@extends('mine.fragment.layout')

@section('uc-content')
<div class="orderreply">
  <div class="orderreply-header">
    <div class="title">商品评价</div>
  </div>
  <div class="orderreply-body">
    <table>
      <col width="11.1111%">
      <col width="11.1111%">
      <col width="44.4444%">
      <col width="33.3333%">
      <tr>
        <th colspan="2">订单号： </th>
        <th>商品信息</th>
        <th>评价状态</th>
      </tr>
      @if($lists)
      @foreach($lists as $value)
      <tr>
        <td class="u-pic"><img src="{{ $value->imageurl }}" alt=""></td>
        <td class="u-title" colspan="2">
          <div class="title">{{ isset($value->goodsname) ? $value->goodsname : "---" }}</div>
          <div class="date">下单时间：{{ $value->updated }}</div>
        </td>
        <td class="u-status noreply">@if(!empty($value->comment)) 已评价 @else 立即评价 @endif</td>
      </tr>
      <tr>
        <form class="form-horizontal" id="form{{ $value->goodsid }}"  method="post" >
          <td colspan="4" class="reply">
            <textarea maxlength="500" @if(!empty($value->comment)) readonly @endif placeholder="亲，商品是否给力？快分享你的心得吧！" name="info[comment]" rows="6">{{ $value->comment }}</textarea>
            <input type="hidden" name="oid"  value="{{ $value->id }}" />
            <input type="hidden" name="info[type]"  value="{{ $value->type }}" />
            <input type="hidden" name="info[cid]"  value="{{ $value->goodsid }}" />
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <p class="help">10-500字 <span class="crt">还可以输入500字</span></p>
            @if(empty($value->comment))
            <a href="javascript:;" onclick="submitComment({{ $value->goodsid }})" class="ubtn"  >发表评论</a>
            <label><input type="checkbox" value="1" name="anonymous">匿名评价</label>
            @endif
          </td>
        </form>
      </tr>
      @endforeach
      @endif

      <!-- <tr>
        <td class="u-pic"><img src="//placehold.it/1000" alt=""></td>
        <td class="u-title" colspan="2">
          <div class="title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, laborum.</div>
          <div class="date">下单时间：1212-12-12</div>
        </td>
        <td class="u-status">立即评价</td>
      </tr>
      <tr> -->
      <td colspan="4" class="replyed"></td>
    </tr>
  </table>
</div>
</div>

<script type="text/javascript" >

$('.orderreply-body table .reply textarea').on('keyup keydown blur', function () {
  var max = parseInt($(this).attr('maxlength'));
  var len = $(this).val().length;
  var $tip = $(this).siblings('.help').find('.crt');
  if ((max - len) < 0) {
    $tip.html('已超出<b style="color:#ff6000;">'+ (len-max) +'</b>字');
  } else {
    $tip.html('还可以输入'+  (max - len) +'字');
  }
});

function submitComment(id)
{
  $.ajax({
      type: "POST",
      url:"/user/api/ordercomment",
      data:$('#form'+id).serialize(),
      dataType: 'json',
      success: function(msg) {
          alert(msg['tips']);
          window.location.reload();
      },
      error: function(error){
          alert('系统繁忙，请稍候再试');
      }
  });
}
</script>
@include('mine.fragment.focus-lg')
@endsection
