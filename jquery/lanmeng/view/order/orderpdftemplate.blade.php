<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>报价单</title>
</head>
<body>
<style>
  body{
    margin: 0;
    padding: 30px;
  }
  table{
    border-collapse:collapse;
    border-spacing:0;
    font-size: 8px;
    width: 100%;
  }
  table td,table th{
    border: 1px solid #000;
    padding: 10px;
    width: 12.5%;
    line-height: 1.5;
  }
  table .bg{
    background: #c0c0c0;
  }
  table .fwb{
    font-weight: bold;
  }
  table .tac{
    text-align: center;
    padding: 0;
  }
  table .tar{
    text-align: right;
  }
  table .title{
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    padding: 15px 0 10px;
  }
  table .subtitle{
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    padding: 15px 0 10px;
  }
  table .tts td{
    text-align: center;
    font-weight: bold;
  }
  table .thd{
    text-align: right;
    border-width: 0 0 1px 0;
  }
</style>

  <table>
    <tr>
      <td class="thd" colspan="8">订单号: {{ $base->ordersn }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 日期:{{ date('Y-m-d H:i:s', $base->created) }}</td>
    </tr>
    <tr>
      <td class="title" colspan="8">报价单</td>
    </tr>
    <tr>
      <td class="subtitle" colspan="8">经销商信息</td>
    </tr>
    <tr>
      <td class="fwb" colspan="3">经销商名：{{ isset($incoice) ? $incoice->company : '' }}</td>
      <td colspan="5">收货地址： {{ isset($incoice) ? $incoice->province : '' }}&nbsp;{{ isset($incoice) ? $incoice->city : '' }}&nbsp;{{ isset($incoice) ? $incoice->dist : '' }}&nbsp;{{ isset($incoice) ? $incoice->address : '' }}</td>
    </tr>
    <tr>
      <td colspan="2">联系人：{{ isset($incoice) ? $incoice->username : '' }}</td>
      <td colspan="3">联系方式（公司电话）：{{ isset($incoice) ? $incoice->phone : '' }}</td>
      <td colspan="3">税务登记号：{{ isset($incoice) ? $incoice->taxnum : '' }}</td>
    </tr>
    <tr>
      <td colspan="3">开户行：{{ isset($incoice) ? $incoice->bank : '' }}</td>
      <td colspan="5">开户行帐号：{{ isset($incoice) ? $incoice->account : '' }}</td>
    </tr>
    <tr>
      <td class="bg tac" colspan="8">以上信息必须填写完成，将作为发货、开票依据，请认真填写、仔细核对！（非常重要）</td>
    </tr>
    <tr>
      <td class="subtitle" colspan="8">供应商信息</td>
    </tr>
    <tr>
      <td colspan="3">供应商名：{{ isset($company['name']) ? $company['name'] : '' }}</td>
      <td colspan="5">地址：{{ isset($company['address']) ? $company['address'] : '' }}</td>
    </tr>
    <tr>
      <td colspan="3">联系人：{{ isset($company['username']) ? $company['username'] : '' }}</td>
      <td colspan="5">联系方式：{{ isset($company['phone']) ? $company['phone'] : '' }}</td>
    </tr>
    <tr>
      <td colspan="8">账户信息：开户行：{{ isset($company['bank']) ? $company['bank'] : '' }}&nbsp;&nbsp;账号：{{ isset($company['account']) ? $company['account'] : '' }}</td>
    </tr>
    <tr>
      <td class="bg" colspan="8"></td>
    </tr>
    <tr class="tts">
      <td>商品名称</td>
      <td>货号</td>
      <td>尺寸</td>
      <td>材质</td>
      <td>单价（元）</td>
      <td>数量</td>
      <td>金额</td>
      <td>备注</td>
    </tr>
    @if($detail)
    @foreach($detail as $value)
    <tr>
      <td style="width:40%;" class="tac">{{ $value['goodsname'] }}</td>
      <td style="width:10%;" class="tac">{{ $value['goodsnum'] }}</td>
      <td style="width:10%;" class="tac">{{ $value['specs'] }}</td>
      <td style="width:5%;" class="tac"></td>
      <td style="width:10%;" class="tac">{{ $value['price'] }}</td>
      <td style="width:10%;" class="tac">{{ $value['num'] }}</td>
      <td style="width:10%;" class="tac">{{ sprintf("%.2f", ($value['price'] * $value['num'])) }}</td>
      <td style="width:5%;" class="tac"></td>
    </tr>
    @endforeach
    @endif
    <tr>
      <td class="tar" colspan="8">
        <b>商品总金额：&yen;{{ $base->orderprice }}</b><br>
        <b>运费：&yen;{{ sprintf("%.2f", $base->freight) }}</b><br>
        <b>安装费：&yen;{{ sprintf("%.2f", $base->install) }}</b><br>
        <b>积分抵扣：&yen;{{ sprintf("%.2f", ($base->integral / 50)) }}</b><br>
        <b>优惠券抵扣：&yen;{{ sprintf("%.2f", ($base->coupons + $base->vipcode)) }}</b><br>
        @if(($base->orderprice + $base->freight + $base->install - ($base->integral / 50) - $base->coupons - $base->vipcode - $base->price) > 0)
        <b>优惠折扣：&yen;{{ sprintf("%.2f", ($base->orderprice - ($base->integral / 50) - $base->coupons - $base->vipcode - $base->price)) }}</b><br>
        @endif
        <b>应付金额：&yen;{{ sprintf("%.2f", ($base->price + $base->freight + $base->install)) }}</b><br>
      </td>
    </tr>
    <tr>
      <td colspan="8"><b>备注：</b></td>
    </tr>
    <tr>
      <td colspan="8"><b>签章确认：</b></td>
    </tr>
    <tr>
      <td class="bg" colspan="8"></td>
    </tr>
    <tr>
      <td colspan="8">订购说明：{{ !empty($base->message) ? $base->message : '' }}</td>
    </tr>
  </table>

</body>
</html>
