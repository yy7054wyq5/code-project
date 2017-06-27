@extends('layouts.main')
@section('banner')
@endsection
@section('menu')
@endsection
@section('header-search')
<h2 class="header-title">结算中心</h2>
@endsection
@section('content')
  <div class="container">
    <div class="oconfirm" id="oconfirm">
      <div class="oconfirm-header">填写并仔细核对订单信息</div>
      <div class="oconfirm-panel1">
        <div class="panel-tt">确认收货人信息<a class="addAddress" href="javascript:;">新增收货地址</a></div>
        <div class="cont">
          @foreach ($address as $item)
            <label class="item {{$item['status'] ? 'active' : ''}}"
              data-id="{{$item->id}}"
              data-consignee="{{$item->consignee}}"
              data-province="{{$item->province}}"
              data-city="{{$item->city}}"
              data-district="{{$item->district}}"
              data-address="{{$item->address}}"
              data-zipcode="{{$item->zipcode}}"
              data-mobile="{{$item->mobile}}"
              data-phone="{{$item->phone}}">
              <span class="fr">寄送到</span>
              <span>（{{$item -> consignee}} 收）{{$item->fullAddress}} {{$item->mobile}}，{{$item->zipcode}}</span>
              @if ($item['status'])
              <a class="setdefault disabled" href="javascript:;">默认地址</a>
              @else
              <a class="setdefault" href="javascript:;">设置为默认地址</a>
              @endif
              <a class="edit" href="javascript:;">修改本地址</a>
            </label>
          @endforeach
        </div>
      </div>
      <div class="oconfirm-panel2" >
          <!-- 是否是集团用户 1是  0不是 -->
          <input type="hidden" value="{{$isGroup}}" id="user-pay"/>
        <div class="panel-tt">支付方式</div>
        <div class="cont">
          <a href="javascript:;" data-groupid="3" class="item group">集团审核代付</a>
          <a href="javascript:;" data-groupid="2" class="item dealer">经销商审核代付</a>
          <a href="javascript:;" data-groupid="1" class="item direct">直接支付</a>
        </div>
      </div>
      <div class="oconfirm-panel2-pay">
          <div class="panel-tt">在线支付</div>
          <div class="cont">
            <a href="javascript:;" data-id="0" class="item active">支付宝</a>
            <p style="float: left;height: 32px;line-height: 32px;color: red;font-size: 12px;padding-left: 40px;">注：如需增值税专用发票请用企业支付宝付款，个人支付宝付款只开具增值税普通发票</p>
           </div>
      </div>
      <div class="oconfirm-panel3">
        <div class="panel-tt">线下支付</div>
        <div class="cont">
          <div class="item" data-id="1">
            <div class="title">银<br>行<br>转<br>账</div>
            <div class="info">
              <p>账户信息：{{ $account['name'] }}</p>
              <p>开户银行：{{ $account['bank'] }}</p>
              <p>银行账号：{{ $account['account'] }}</p>
            </div>
          </div>
          <div class="item {{ $info->level >= 3 ? '' : 'disabled' }}" data-id="2">
            <div class="title">货<br>到<br>付<br>款</div>
            <div class="info">
              <p>仅对V3（含V3）及以上会员开放</p>
              <p>V3会员单笔限定1000元以内</p>
              <p>V4会员单笔限定2000元以内</p>
              <p>V5会员单笔限定3000元以内</p>
            </div>
          </div>
          <div class="item {{ $info->level >= 4 ? '' : 'disabled' }}" data-id="3">
            <div class="title">货<br>到<br>月<br>结</div>
            <div class="info">
              <p>仅对V4（含V4）以上的会员开放</p>
              <p>达到标准的会员可享受当月所购5000元</p>
              <p>以内商品货款月内结算特权</p>
            </div>
          </div>
        </div>
      </div>
      <div class="oconfirm-panel4">
        <div class="panel-tt">发票信息</div>
        <div class="cont">
          <div data-id="{{ isset($invoice->id) ? $invoice->id : '' }}" class="item active">
            <a href="javascript:;" class="ubtn">增值税发票-明细</a>
            <span class="name">{{ isset($invoice->company) ? $invoice->company : '暂无发票信息' }}</span>
            <a href="javascript:;" data-id="{{ isset($invoice->id) ? $invoice->id : '' }}" class="link edit">编辑</a>
          </div>
        </div>
      </div>
      <div class="oconfirm-panel5">
        <div class="panel-tt">商品清单</div>
        <table>
          <col width="150px">
          <col width="100px">
          <col width="270px">
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
            <?php
$temp    = 0;
$tempnum = 0;
?>
            @if(isset($lists[0]))
            @foreach($lists as $value)
            <?php
$tempCredits = $value->type == 3 ? $value->maxCredits : $value->credits * $value->num;
$temp += $tempCredits;
?>
            <tr>
              <td>{{ $value->code }}</td>
              <td class="u-pic"><img src="{{ $value->imageurl }}" alt=""></td>
              <td class="u-title">
                <div class="title">{{ $value->name }}</div>
                <span class="gray">规格尺寸：{{ $value->spec }}</span>
              </td>
              <td>@if($value->type == 0) 商城 @elseif($value->type == 1) 团购 @elseif($value->type == 2) 车友汇 @elseif($value->type == 3) 预购 @else 商城 @endif</td>
              <td>&yen;{{ $value->type == 3 ? $value->prepayPrice : $value->price }}</td>
              <td>{{ $value->num }}</td>
              <?php
$tempPrice = $value->type == 3 ? $value->prepayPrice : $value->price * $value->num;
$tempnum += $tempPrice;
?>
              <td>&yen;{{ $value->type == 3 ? $value->prepayPrice : $value->price * $value->num }}</td>
              <td data-goodsid="{{ $value['cartid'] }}" data-type="{{ $value['dispatch'] }}" data-unit="{{ $value['unit_num'] }}" data-num="{{ $value->num }}">
              @if(!in_array($value['dispatch'], [1,2,3]))
              <select name="shipid">
                <!-- <option class="auto">请选择配送方式</option> -->
                <option data-id="0" class="auto">快递</option>
                <option data-id="1">EMS</option>
                <option data-id="2">顺丰</option>
              </select>
              <div class="dis">运费：&yen;<span class="dispatch">0</span></div>
              <div class="loadingTxt">获取中，请稍候</div>
              @endif
              {{-- Config::get('other.dispatch')[$value['dispatch']]--}}
              </td>
            </tr>
            @endforeach
            @endif
            <?php Session::put('orderprice', $tempnum);?>
          </tbody>
        </table>
        <div class="expanel">
          <div class="urow">
            <div class="label">补充说明:</div>
            <input type="text" id="exMsg" placeholder="选填：可告诉蓝网您的特殊需求（最多可输入200字）">
          </div>
          <p class="price">订单合计金额：<strong>&yen;{{ $tempnum }}</strong></p>
          <input type="hidden" name="price" value="{{ $tempnum }}">
        </div>
      </div>
      <div class="oconfirm-panel6">
        <div class="item">
          <div class="title">使用积分</div>
          <div class="urow">您目前共有：<em>{{ $info->integral }}</em>积分，本订单可使用<em><?php echo $temp; ?></em>个积分抵扣</div>
          <div class="urow">使用蓝网积分：<input class="ipt" data-max="<?php echo min($temp, $info->integral); ?>" id="j_score_crt" type="text">个 可抵扣：<em id="j_score_trf">&yen;0.00</em></div>
        </div>
        <div class="item">
          <div class="title">使用VIP抵金券</div>
          <div class="urow">优惠券兑换码？<a class="j_entryCodeBtn" href="javascript:;">［点击输入兑换码］</a></div>
          <div class="urow" id="couponCodes">
            请输入兑换码
            <input type="text" class="ipt" maxlength="4">
            -
            <input type="text" class="ipt" maxlength="4">
            -
            <input type="text" class="ipt" maxlength="4">
            -
            <input type="text" class="ipt" maxlength="4">
          </div>
          <div class="urow">可抵扣：<em id="code_save">&yen;0</em></div>
        </div>
        <div class="item">
          <div class="title">使用优惠券</div>
          <div class="tab" id="coupon">
            <div class="tab-hd">
              <a class="active" href="javascript:;">可用优惠券<!--  (2) --></a>
              <a href="javascript:;">不可用优惠券<!--  (0) --></a>
            </div>
            <div class="tab-ct tab-ct1 active">
              <p>此处仅展示符合本次订单商品使用的优惠券<!--<a href="javascript:;">了解优惠券使用规则</a>--></p>
              <table>
                <col width="24px">
                <col width="160px">
                <col width="100px">
                <col width="260px">
                <tr>
                  <th colspan="4">蓝券：</th>
                </tr>
                @if(isset($coupons[0]))
                @foreach($coupons as $value)
                @if($value['useok'] == 0 && $value['vtype'] == 0)
                <tr data-value="{{ $value['code'] }}">
                  <td class="u-ck">
                    <input type="checkbox" class="i-couponId" data-save="{{ $value['value'] }}" value="{{ $value['code'] }}">
                  </td>
                  <td><em>{{ $value['value'] }}</em>元</td>
                  <td>{{ $value['ctype'] == -1 ? "全品类" : "限品类" }}</td>
                  <td>有效期：{{ date('Y-m-d', $value['begintime']) }} 至 {{ date('Y-m-d', $value['endtime']) }}</td>
                </tr>
                @endif
                @endforeach
                @endif
                <tr>
                  <th colspan="4">橙券：</th>
                </tr>
                @if(isset($coupons[0]))
                @foreach($coupons as $value)
                @if($value['useok'] == 0 && $value['vtype'] == 1 && $tempnum >= $value['orderprice'])
                <tr data-value="{{ $value['orderprice'] }}">
                  <td class="u-ck">
                    <input type="checkbox" class="i-couponId" data-save="{{ $value['value'] }}" value="{{ $value['code'] }}">
                  </td>
                  <td><em>{{ $value['value'] }}</em>元</td>
                  <td>{{ $value['ctype'] == -1 ? "全品类" : "限品类" }}</td>
                  <td>有效期：{{ date('Y-m-d', $value['begintime']) }} 至 {{ date('Y-m-d', $value['endtime']) }}</td>
                </tr>
                @endif
                @endforeach
                @endif
              </table>
            </div>
            <div class="tab-ct tab-ct2">
              <p>此处仅展示不符合本次订单商品使用的优惠券<!--<a href="javascript:;">了解优惠券使用规则</a>--></p>
              <table>
                <col width="24px">
                <col width="160px">
                <col width="100px">
                <col width="260px">
                <tr>
                  <th colspan="4">蓝券：</th>
                </tr>
                @if(isset($coupons[0]))
                @foreach($coupons as $value)
                @if($value['useok'] != 0 && $value['vtype'] == 0)
                <tr>
                  <td class="u-ck"></td>
                  <td><em>{{ $value['value'] }}</em>元</td>
                  <td>{{ $value['ctype'] == -1 ? "全品类" : "限品类" }}@if($value['freeze'] == 1) (已冻结) @endif</td>
                  <td>有效期：{{ date('Y-m-d', $value['begintime']) }} 至 {{ date('Y-m-d', $value['endtime']) }}</td>
                </tr>
                @endif
                @endforeach
                @endif
                <tr>
                  <th colspan="4">橙券：</th>
                </tr>
                @if(isset($coupons[0]))
                @foreach($coupons as $value)
                @if(($value['useok'] != 0 && $value['vtype'] == 1) || ($value['useok'] == 0 && $value['orderprice'] > $tempnum))
                <tr>
                  <td class="u-ck"></td>
                  <td><em>{{ $value['value'] }}</em>元</td>
                  <td>{{ $value['ctype'] == -1 ? "全品类" : "限品类" }}@if($value['freeze'] == 1) (已冻结) @endif</td>
                  <td>有效期：{{ date('Y-m-d', $value['begintime']) }} 至 {{ date('Y-m-d', $value['endtime']) }}</td>
                </tr>
                @endif
                @endforeach
                @endif
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="oconfirm-panel7">
        <p>订单总金额：&yen;{{ $tempnum }}</p>
        <p>-抵扣：&yen;<span id="all_save">0.00</span></p>
        <p>+运费：&yen;<span id="dispatch">0.00</span></p>
        <p class="price">实付款：<strong>&yen;<span id="price" data-price="{{ $tempnum }}">{{ $tempnum }}</span></strong></p>
      </div>
      <div class="oconfirm-submit">
        <a class="ubtn" id="submitBtn">提交订单</a>
      </div>

    </div>
  </div>
@endsection

@section('modal')
<!-- 收货地址模态 -->
<div class="modal fade oconfirm-modal" id="modal1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-close" data-dismiss="modal">&times;</div>
      <div class="modal-header">新增收货地址</div>
      <div class="modal-body">
        <form autocomplete="off" novalidate>
          <input type="text" class="hide" name="id">
          <table>
            <tr>
              <td class="llabel"><b>*</b>收货人：</td>
              <td class="cont">
                <input class="ipt" type="text" name="consignee">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>地址：</td>
              <td class="cont">
                <select name="province" class="province">
                  <option value="">--选择省--</option>
                  @foreach($province as $item)
                  <option value="{{$item['id']}}">{{$item['name']}}</option>
                  @endforeach
                </select>
                <select name="city" class="city">
                  <option value="">--选择市--</option>
                </select>
                <select name="district" class="district">
                  <option value="">--选择区--</option>
                </select>
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>详细地址：</td>
              <td class="cont">
                <input class="ipt" type="text" name="address">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>邮编：</td>
              <td class="cont">
                <input class="ipt" type="text" name="zipcode">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>收货人手机：</td>
              <td class="cont">
                <input class="ipt" type="text" name="mobile">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel">固定电话：</td>
              <td class="cont">
                <input class="ipt" type="text" name="phone">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"></td>
              <td class="cont"><button type="submit" class="submit">保存</button></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 发票明细模态 -->
<div class="modal fade oconfirm-modal2" id="modal2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-close" data-dismiss="modal">&times;</div>
      <div class="modal-header">编辑发票信息</div>
      <div class="modal-body">
        <form autocomplete="off" novalidate>
          <input type="hidden" name="id" value="{{isset($invoice->company) ? $invoice->id : ''}}">
          <table>
            <tr>
              <th colspan="4">公司信息</th>
            </tr>
            <tr class="gutter">
              <td colspan="4"></td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>单位名称</td>
              <td class="cont">
                <input type="text" class="ipt" name="company" value="{{ isset($invoice->company) ? $invoice->company : '' }}">
                <div class="help"></div>
              </td>
              <td class="llabel"><b>*</b>公司电话</td>
              <td class="cont">
                <input type="text" class="ipt" name="phone" value="{{ isset($invoice->phone) ? $invoice->phone : '' }}">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>纳税人识别码</td>
              <td class="cont">
                <input type="text" class="ipt" name="taxnum" value="{{ isset($invoice->taxnum) ? $invoice->taxnum : '' }}">
                <div class="help"></div>
              </td>
              <td class="llabel"><b>*</b>开户行</td>
              <td class="cont">
                <input type="text" class="ipt" name="bank" value="{{ isset($invoice->bank) ? $invoice->bank : '' }}">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>公司地址</td>
              <td class="cont">
                <input type="text" class="ipt" name="address" value="{{ isset($invoice->address) ? $invoice->address : '' }}">
                <div class="help"></div>
              </td>
              <td class="llabel"><b>*</b>银行账号</td>
              <td class="cont">
                <input type="text" class="ipt" name="account" value="{{ isset($invoice->account) ? $invoice->account : '' }}">
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <th colspan="4">发票明细</th>
            </tr>
            <tr class="gutter">
              <td colspan="4"></td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>收票人</td>
              <td class="cont">
                <input type="text" name="username" value="{{ isset($invoice->username) ? $invoice->username : '' }}" class="ipt">
                <div class="help"></div>
              </td>
              <td class="llabel"></td>
              <td class="cont"></td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>收票人手机</td>
              <td class="cont">
                <input type="text" name="mobile" value="{{ isset($invoice->mobile) ? $invoice->mobile : '' }}" class="ipt">
                <div class="help"></div>
              </td>
              <td class="llabel"></td>
              <td class="cont"></td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>收票人地址</td>
              <td class="cont" colspan="3">
                <select class="ipt province" name="province">
                  <option value="">--选择省--</option>
                  @foreach($province as $item)
                    <option value="{{$item['id']}}" @if($invoice['province']==$item['id']) selected @endif>{{$item['name']}}</option>
                  @endforeach
                </select>
                <select class="ipt city" name="city">
                  <option value="">--选择市--</option>
                  @if(isset($invoice_city[0]))
                  @foreach($invoice_city as $item)
                  <option value="{{$item['id']}}" @if($invoice['city']==$item['id']) selected @endif>{{$item['name']}}</option>
                  @endforeach
                  @endif
                </select>
                <select class="ipt district" name="dist">
                  <option value="">--选择区--</option>
                  @if(isset($invoice_dist[0]))
                  @foreach($invoice_dist as $item)
                  <option value="{{$item['id']}}" @if($invoice['dist']==$item['id']) selected @endif>{{$item['name']}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="help"></div>
              </td>
            </tr>
            <tr>
              <td class="llabel"><b>*</b>详细地址</td>
              <td class="cont">
                <input type="text" name="adddress"  value="{{ isset($invoice->adddress) ? $invoice->adddress : '' }}" class="ipt">
                <div class="help"></div>
              </td>
              <td class="llabel"></td>
              <td class="cont"></td>
            </tr>
            <tr>
              <td class="llabel"></td>
              <td class="cont" colspan="3">
                <button type="submit" class="submit">保存发票信息</button>
                <span class="muted">温馨提示：发票金额不包括蓝网积分支付部分</span>
              </td>
            </tr>
            <!-- <tr>
              <td class="llabel"></td>
              <td class="cont" colspan="3"><a href="javascript:;" class="link-blue">发票信息相关问题</a></td>
            </tr> -->
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer-scripts')
<script src="/js/validate/jquery.validate.min.js"></script>
<script src="/js/oconfirm.js"></script>
@endsection
