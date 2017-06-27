@extends('layouts.main')

@section('banner')
@endsection

@section('content')
  <div class="container">
    <div class="oconfirm2">
      <div class="oconfirm2-title">商品清单</div>
      @if($lists)
      <?php $temp = 0; ?>
      @foreach($lists as $value)
      <div class="oconfirm2-item">
        <table>
          <col width="150px">
          <col width="100px">
          <col width="300px">
          <thead>
            <tr>
              <th>编号</th>
              <th>商品图片</th>
              <th>商品名称</th>
              <th>频道</th>
              <th>单价</th>
              <th>数量</th>
              <th>总价</th>
              <th>配送</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $value->code}}</td>
              <td class="u-pic"><img src="{{ $value->imageurl }}" alt=""></td>
              <td class="u-title">
                <div class="title">{{ $value->name}}</div>
                <span class="gray">{{ $value->brand }}</span>
              </td>
              <td>创库</td>
              <td class="fwb">{{ $value->price }}积分</td>
              <td>{{ $value->num }}</td>
              <td data-score="{{ $value->price * $value->num }}" class="orange score">{{ $value->price * $value->num }}积分</td>
              <?php $temp += $value->price * $value->num; ?>
              <td>-</td>
            </tr>
          </tbody>
        </table>
        <div class="kv-title">主KV信息添加</div>
        <div class="kv-cont">
          <div class="kv-row">
            <div class="label">主标题</div>
            <div class="cont"><input class="i-title" type="text"><i>0/30</i></div>
          </div>
          <div class="kv-row">
            <div class="label">副标题</div>
            <div class="cont"><input class="i-subtitle" type="text"><i>0/30</i></div>
          </div>
          <div class="kv-row">
            <div class="label">活动详情</div>
            <div class="cont"><input class="i-activity" type="text"><i>0/30</i></div>
          </div>
          <div class="kv-row">
            <div class="label">经销商详情</div>
            <div class="cont"><input class="i-dealer" type="text"><i>0/30</i></div>
          </div>
        </div>
      </div>
      @endforeach
      @endif

      <div class="oconfirm2-expanel">
        <div class="urow">
          <div class="label">补充说明：</div>
          <input id="ordermsg" type="text" placeholder="选填：可告诉蓝网您的特殊需求（最多可输入200字）">
          <span class="counter"></span>
        </div>
        <div class="total"><b>订单合计积分：</b><strong><?php echo $temp; ?></strong>积分</div>
      </div>
      <?php Session::put('orderprice', $temp); ?>
      <div class="oconfirm2-amount">
        <p>您目前共有<em>{{ $info->integral }}</em>积分，本订单至少需用<em><?php echo $temp; ?></em>积分</p>
        <div class="total"><b>实付款：</b><strong><?php echo $temp; ?></strong>积分</div>
      </div>
      <div class="oconfirm2-submit">
        <button class="submit" type="submit">提交订单</button>
      </div>
    </div>
  </div>
@endsection


@section('footer-scripts')
<script>
(function () {

  // 字数限制
  $('.oconfirm2-item .kv-row .cont input').on('keyup keydown blur', function () {
    var len = $(this).val().length;
    $(this).siblings('i').text((len > 30 ? 30 : len)  + '/30');
    if (len > 30) {
      $(this).val( $(this).val().substring(0, 30) );
    }
  });

  // 补充说明字数
  $('.oconfirm2-expanel .urow input').on('keyup keydown blur', function () {
    var val = $(this).val();
    if (val.length > 200) {
      $(this).val(val.substring(0, 200));
    }
  });


  // 提交订单
  $('.oconfirm2-submit .submit').on('click', function () {
    var data = {
      orderprice: [],
      title: [],
      subtitle: [],
      activity: [],
      dealer: [],
      message: $('#ordermsg').val()
    };
    $('.oconfirm2-item').each(function () {
      data.orderprice.push($(this).find('table .score').attr('data-score'));
      data.title.push($(this).find('.i-title').val());
      data.subtitle.push($(this).find('.i-subtitle').val());
      data.activity.push($(this).find('.i-activity').val());
      data.dealer.push($(this).find('.i-dealer').val());
    });

    load($.post('/user/api/creativeorder', $.param(data)))
      .done(function (res) {
        if (res.status === 0) {
          window.location.href = res.content.ordersn;
        } else {
          littleTips(res.tips);
        }
      });
  });

})();
</script>
@endsection
