@extends('mine.fragment.layout')


@section('uc-content')
<div class="uc-main-main">
  <div class="uc-invoice" id="j_uc_invoice">
    <div class="uc-invoice-header">
      <div class="title">我的发票</div>
    </div>
    <div class="uc-invoice-body">
      <form autocomplete="off" novalidate>
        <input type="hidden" name="id" id="id" value="{{ $info['id'] }}">
        <table>
          <tr>
            <td colspan="4">
              <div class="title">公司信息</div>
            </td>
          </tr>
          <tr>
            <td class="mlabel"><b>*</b>单位名称</td>
            <td>
              <input type="text" name="company" value="{{ $info['company'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
            <td class="mlabel"><b>*</b>公司电话</td>
            <td>
              <input type="text" name="phone" value="{{ $info['phone'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
          </tr>
          <tr>
            <td class="mlabel"><b>*</b>纳税人识别码</td>
            <td>
              <input type="text" name="taxnum" value="{{ $info['taxnum'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
            <td class="mlabel"><b>*</b>开户行</td>
            <td>
              <input type="text" name="bank" value="{{ $info['bank'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
          </tr>
          <tr>
            <td class="mlabel"><b>*</b>公司地址</td>
            <td>
              <input type="text" name="address" value="{{ $info['address'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
            <td class="mlabel"><b>*</b>银行帐号</td>
            <td>
              <input type="text" name="account" value="{{ $info['account'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <div class="title">发票明细</div>
            </td>
          </tr>
          <tr>
            <td class="mlabel"><b>*</b>收票人</td>
            <td>
              <input type="text" name="username" value="{{ $info['username'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
            <td class="mlabel"></td>
            <td></td>
          </tr>
          <tr>
            <td class="mlabel"><b>*</b>收票人手机</td>
            <td>
              <input type="text" name="mobile" value="{{ $info['mobile'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
            <td class="mlabel"></td>
            <td></td>
          </tr>
          <tr>
            <td class="mlabel"><b>*</b>收票人地址</td>
            <td colspan="3">
              <select class="i-select j_province" name="province">
                <option value="">--选择省--</option>
                @foreach($province as $item)
                <option value="{{ $item['id'] }}" {{ $info['province'] == $item['id'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                @endforeach
              </select>
              <select class="i-select j_city" name="city">
                <option value="">--选择市--</option>
                @if($info['city'])
                @foreach($city as $item)
                <option value="{{ $item['id'] }}" {{ $info['city'] == $item['id'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                @endforeach
                @endif
              </select>
              <select class="i-select j_district" name="dist">
                <option value="">--选择区--</option>
                @if($info['dist'])
                @foreach($district as $item)
                <option value="{{ $item['id'] }}" {{ $info['dist'] == $item['id'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                @endforeach
                @endif
              </select>
              <div class="help"></div>
            </td>
          </tr>
          <tr>
            <td class="mlabel"><b>*</b>详细地址</td>
            <td>
              <input type="text" name="adddress" value="{{ $info['adddress'] }}" class="i-ipt">
              <div class="help"></div>
            </td>
            <td class="mlabel"></td>
            <td></td>
          </tr>
          <tr>
            <td class="mlabel"></td>
            <td>
              <button type="submit" class="submit">保存</button>
            </td>
            <td class="mlabel"></td>
            <td></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
