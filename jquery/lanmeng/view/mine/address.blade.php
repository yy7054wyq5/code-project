@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-address" id="j_uc_address">
    <div class="uc-address-header">
      <div class="title">收货地址管理</div>
    </div>
    <div class="uc-address-body">
      <div class="row-a">
        <a href="javascript:;" class="btn-new">新增收货地址</a>
        <span>您已经创建了{{ $count }}个收货地址，最多可创建5个</span>
      </div>
      <div class="alist">
        @foreach($address as $item)
        <div class="item{{$item->status ? ' active' : ''}}"
          data-id="{{$item->id}}"
          data-consignee="{{$item->consignee}}"
          data-province="{{$item->province}}"
          data-city="{{$item->city}}"
          data-district="{{$item->district}}"
          data-address="{{$item->address}}"
          data-zipcode="{{$item->zipcode}}"
          data-mobile="{{$item->mobile}}"
          data-phone="{{$item->phone}}">
          <a href="javascript:;" class="btn-del">删除</a>
          <div class="side">
            <a href="javascript:;" class="btn-dft">默认地址</a>
            <a href="javascript:;" class="btn-edit">编辑</a>
          </div>
          <ul>
            <li><span class="lab">收货人：</span>{{$item->consignee}}</li>
            <li><span class="lab">地址：</span>{{$item->fullAddress}}</li>
            <li><span class="lab">邮编：</span>{{$item->zipcode}}</li>
            <li><span class="lab">手机：</span>{{$item->mobile}}</li>
            <li><span class="lab">固定电话：</span>{{$item->phone}}</li>
          </ul>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection

@section('modal')
<div class="modal fade uc-modal uc-modal-address" id="j_modal1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-close" data-dismiss="modal">&times;</div>
      <div class="modal-header">新增收货人</div>
      <div class="modal-body">
        <form autocomplete="off" novalidate>
          <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
          <input type="hidden" name="id">
          <table>
            <tr>
              <td class="mlabel"><b>*</b>收货人：</td>
              <td>
                <input type="text" class="i-ipt" name="consignee">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="mlabel"><b>*</b>地址：</td>
              <td>
                <select class="i-select j_province" name="province">
                  <option value="">--选择省--</option>
                  @if($province)
                  @foreach($province as $value)
                  <option value="{{ $value->id }}">{{ $value->name }}</option>
                  @endforeach
                  @endif
                </select>
                <select class="i-select j_city" name="city">
                  <option value="">--选择市--</option>
                </select>
                <select class="i-select j_district" name="district">
                  <option value="">--选择区--</option>
                </select>
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="mlabel"><b>*</b>详细地址：</td>
              <td>
                <input type="text" class="i-ipt" name="address">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="mlabel"><b>*</b>邮编：</td>
              <td>
                <input type="text" class="i-ipt" name="zipcode">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="mlabel"><b>*</b>收货人手机：</td>
              <td>
                <input type="text" class="i-ipt" name="mobile">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="mlabel">固定电话：</td>
              <td>
                <input type="text" class="i-ipt" name="phone">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="mlabel"></td>
              <td>
                <button type="submit" class="submit">保存收货人信息</button>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="j_modal2">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">确认要删除该条数据吗？</div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">取消</button>
        <button class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="j_modal3">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">确认要将本条数据设置为默认吗？</div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">取消</button>
        <button class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>
@endsection
