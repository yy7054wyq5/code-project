@extends('layouts.main')

@section('banner')
@endsection

@section('content')
  <div class="container">
    <div class="mcart" id="j_mcart">
      <div class="mcart-header"><div class="title">全部商品<span>{{ $count }}</span></div></div>
      <div class="mcart-body">
        <table class="mcart-table">
          <col width="40px">
          <col width="75px">
          <col width="300px">
          <col width="150px">
          <col width="100px">
          <col width="100px">
          <col width="100px">
          <col width="120px">
          <thead>
            <tr class="u-all">
              <th><input class="u-all-ck" type="checkbox"></th>
              <th class="tal">全选</th>
              <th>商品信息</th>
              <th></th>
              <th>频道</th>
              <th>单价</th>
              <th>数量</th>
              <th>总价</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @if($lists)
            @foreach($lists as $key => $temp)
            <tr class="u-cate">
              <td class="tac"><input type="checkbox"></td>
              <td class="title" colspan="8">{{ $temp['type'] }}</td>
            </tr>
            @foreach($temp['info'] as $value)
            <tr data-cart="{{ $value['id'] }}" data-surplus="{{ $value['info']['surplus'] }}" data-status="{{ isset($value['info']['status']) ? $value['info']['status'] : 0 }}" data-type="{{ $value['type'] }}" data-subtype="{{ $value['subtype'] }}" data-spec="{{ $value['spec'] }}" data-goods="{{ $value['goodsid'] }}" data-price="{{ isset($value['info']['price']) ? $value['info']['price'] : '-' }}" class="u-item @if(!isset($value['info']['status']) || $value['info']['status'] == 0) u-item-disabled @endif">
              <td>
                @if(isset($value['info']['status']) && $value['info']['status'] != 0)
                <input type="checkbox" data-cart="{{ $value['id'] }}" autocomplete="off" data-min="{{ $value['info']['minNumber'] }}" data-max="{{ $value['info']['maxNumber'] }}" data-pay="{{ $value['info']['pay'] }}" data-id="{{ $value['goodsid'] }}" data-num="{{ $value['num'] }}" data-spec="{{ $value['spec'] }}" data-subtype="{{ $value['info']['subtype'] }}" data-type="{{ $key }}">
                @else
                <div>已<br>下<br>架</div>
                @endif
              </td>
              <td class="pic"><img src="{{ $value['image'] }}" alt=""></td>
              <td class="title">{{ isset($value['info']['name']) ? $value['info']['name'] : '-' }}</td>
              <td class="type">规格尺寸:{{ isset($value['info']['spec']) ? $value['info']['spec'] : '-' }}</td>
              <td class="pd">{{ isset($value['typename']) ? $value['typename'] : '-' }}</td>
              <td class="price">@if($value['type'] == 3 && $value['subtype'] == 4) {{ (int)$value['info']['price'] }}积分 @elseif($value['type'] == 4 && $value['subtype'] == 3) &yen;{{ $value['info']['prepayPrice'] }} @else &yen;{{ $value['info']['price'] }} @endif</td>
              <td>
                @if(isset($value['info']['status']) && $value['info']['status'] != 0)
                <div class="counter">
                  <div class="counter-minus"></div>
                  <div class="counter-plus"></div>
                  <input type="text" class="counter-num" value="{{ isset($value['num']) ? $value['num'] : '-' }}">
                </div>
                @else
                0
                @endif
              </td>
              <td class="amount">@if($value['type'] == 3 && $value['subtype'] == 4) {{ $value['info']['price'] * $value['num'] }}积分 @elseif($value['type'] == 4 && $value['subtype'] == 3) &yen;{{ $value['info']['prepayPrice'] }} @else &yen;{{ $value['info']['price'] * $value['num'] }} @endif</td>
              <td class="operate">
                <!-- <a href="#">加入关注</a> -->
                <a href="/user/api/delcart?id={{ $value['id'] }}">删除</a>
              </td>
            </tr>
            @endforeach
            @endforeach
            @else
            <tr>
              <td colspan="9" style="padding: 30px 0 100px;text-align: center;">暂无数据</td>
            </tr>
            @endif
          </tbody>
          @if($lists)
          <tfoot>
            <tr class="u-all">
              <td class="tac"><input class="u-all-ck" type="checkbox"></td>
              <td class="tal"><a href="javascript:;">全选</a></td>
              <td class="tal"><a class="delBtn" href="javascript:;">删除</a></td>
              <td colspan="2">已选商品<em id="j_total_num">0</em>件</td>
              <td class="u-amount" colspan="4">
                <span class="llabel">合计（不含运费）：</span>
                <div class="ucol">
                  <span class="price">&yen;<span id="j_total_price">0.00</span></span>
                  <span class="score">积分<em id="j_total_score">0</em></span>
                </div>
                <a href="javascript:;" class="amount">结算</a>
              </td>
            </tr>
          </tfoot>
          @endif
        </table>
      </div>
    </div>
  </div>
@endsection

@section('footer-scripts')
<script>

(function () {

  var $cart = $('#j_mcart');
  var $totalScore = $('#j_total_score');
  var $totalPrice = $('#j_total_price');
  var loading = false;
  // 单选
  $('.u-item :checkbox').on('change', function () {
    if ($(this).is(':checked')) {
      $(this).parents('.u-item').addClass('u-item-checked');
    } else {
      $(this).parents('.u-item').removeClass('u-item-checked');
    }
    amount();
  });

  // 多选－类型
  $('.u-cate :checkbox').on('change', function () {
    $(this).parents('.u-cate').nextUntil('.u-cate').find(':checkbox')
      .prop('checked', $(this).is(':checked')).trigger('change');
  });

  // 多选－全部
  var $ckall = $('.u-all-ck');
  $ckall.on('change', function () {
    $ckall.prop('checked', $(this).is(':checked'));
    $('.u-item :checkbox').prop('checked', $(this).is(':checked')).trigger('change');
  });
  // 默认全选
  $ckall.prop('checked', true).trigger('change');

  // 增加购物量
  $('.counter-plus').on('click', function () {
    if(loading) return;
    loading = true;
    var dataType = $(this).parents('.u-item').attr('data-type');
    var $num = $(this).siblings('.counter-num');
    var num = parseInt($num.val());
    var id = $(this).parents('.u-item').attr('data-cart');
    var price = $(this).parents('.u-item').attr('data-price');
    var type = $(this).parents('.u-item').attr('data-type');
    var $price = $(this).parents('.u-item').find('.amount');
    var stock = parseInt($(this).parents('.u-item').attr('data-surplus'));
    if (num >= stock){
      loading = false;
      return;
    } 
    load($.post('/user/api/setcartnum', {id: id, num: ++num})).done(function (res) {
      if (res.status !== 0) return littleTips(res.tips);
      $num.val(num);
      if(dataType==4) return;
      $price.html(type == 3 ? num * price + '积分' : '&yen;' + (num * price).toFixed(2));
      amount();
    });
  });

  // 减少购物量
  $('.counter-minus').on('click', function () {
    if(loading) return;
    loading = true;
    var dataType = $(this).parents('.u-item').attr('data-type');
    var $num = $(this).siblings('.counter-num');
    var num = parseInt($num.val());
    var id = $(this).parents('.u-item').attr('data-cart');
    var price = $(this).parents('.u-item').attr('data-price');
    var type = $(this).parents('.u-item').attr('data-type');
    var $price = $(this).parents('.u-item').find('.amount');
    if (--num <= 0){
      loading = false;
      return;
    } 
    load($.post('/user/api/setcartnum', {id: id, num: num})).done(function (res) {
      if (res.status !== 0) return littleTips(res.tips);
      $num.val(num);
      if(dataType==4) return;
      $price.html(type == 3 ? num * price + '积分' : '&yen;' + (num * price).toFixed(2));
      amount();
    });
  });

  // 设置购物数量
  $('.counter-num').on('keydown', function () {
    if(loading) return;
     loading = true;
    var dataType = $(this).parents('.u-item').attr('data-type');
    var self = this;
    clearTimeout( $(this).data('timer') );
    $(this).data('timer', setTimeout(function () {
      var $num = $(self);
      var num = parseInt($(self).val());
      var stock = parseInt($(self).parents('.u-item').attr('data-surplus'));
      var id = $(self).parents('.u-item').attr('data-cart');
      var price = $(self).parents('.u-item').attr('data-price');
      var type = $(self).parents('.u-item').attr('data-type');
      var $price = $(self).parents('.u-item').find('.amount');

      if (num !== num || num < 1) {
        num = 1;
      } else if (num > stock) {
        num = stock;
      }

      load($.post('/user/api/setcartnum', {id: id, num: num})).done(function (res) {
        if (res.status !== 0) return littleTips(res.tips);
        $num.val(num);
        if(dataType==4) return;
        $price.html(type == 3 ? num * price + '积分' : '&yen;' + (num * price).toFixed(2));
        amount();
      });

    }, 1000));
  });



  // 批量删除
  $('.u-all .delBtn').on('click', function () {
    var params = $('.u-item :checked').parents('.u-item').map(function () {
      return {
        'id': $(this).attr('data-cart'),
      };
    }).toArray();
    load($.post('/user/api/delsomecart', $.param({info: params}))).done(function (res) {
      if (res.status === 0) window.location.reload();
      else littleTips(res.tips);
    });
  });

  // 批量删除
  $('.u-all .delBtn').on('click', function () {
    var $items = $cart.find('.mcart-table .u-item :checked');
    var params = $items.map(function () {
      return {
        'id': $(this).attr('data-cart'),
      };
    }).toArray();
    load($.post('/user/api/delsomecart', $.param({info: params})))
      .done(function (res) {
        if (res.status === 0) window.location.reload();
        else littleTips(res.tips);
      });
  });

  $('.u-amount .amount').on('click', function () {
    if(loading) return;
    var $items = $cart.find('.mcart-table .u-item :checked');
    if ( !$items.length ) return littleTips('请先选择商品');
    var payment = null;
    var typenum = null;
    var goods = [];
    var pay_cookie = null;
    var type_cookie = null;
    $items.each(function () {
      var cartid = $(this).attr('data-cart');
      var pay = $(this).attr('data-pay');
      var type = $(this).attr('data-type');
      if (payment === null) payment = pay;
      else if (payment !== pay) payment = false;
      goods.push(cartid);
      pay_cookie = pay;
      type_cookie = type;
    });
    if (payment === false) return littleTips('不同类别的产品不能同时结算');
    Cookies.set('order_goods', JSON.stringify(goods), {expires: 1, path: '/'});
    Cookies.set('pay_cookie', pay_cookie, {expires: 1, path: '/'});
    Cookies.set('type_cookie', type_cookie, {expires: 1, path: '/'});
    window.location.href = payment == 4 ? '/oconfirm2' : '/oconfirm';
  });




  // 计算总价
  function amount() {
    var totalScore = 0;
    var totalPrice = 0;
    var len = 0;
    $('.u-item :checked').parents('.u-item').each(function () {
      var num = parseInt($(this).find('.counter-num').val());
      var price = $(this).attr('data-price');
      var type = $(this).attr('data-type');
      if (type == 3) { //积分
        totalScore += price * num;
      } else {
        totalPrice += price * num;
      }
      len += 1;
    });
    $('#j_total_price').html(totalPrice.toFixed(2));
    $('#j_total_score').html(totalScore);
    $('#j_total_num').text(len);
    loading = false;
  }



})();

</script>
@endsection
