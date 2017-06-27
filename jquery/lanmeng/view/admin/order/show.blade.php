@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>订单详情</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body big">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-sm-2 control-label">订单编号</label>
                <div class="col-sm-4">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>{{ $baseinfo->ordersn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">订单金额</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">    
                                <td>订单总价</td>
                                @if($baseinfo->type == 4)
                                <td>{{ sprintf("%.2f", ($baseinfo->price + $baseinfo->freight + $baseinfo->install + $baseinfo->coupons + $baseinfo->vipcode + $baseinfo->integral / 50)) }}<!-- {{ $baseinfo->order_price }} --></td>
                                @else
                                <td>{{ $baseinfo->order_price }}</td>
                                @endif
                            </tr>
                            <tr data-id="1">    
                                <td>{{ $baseinfo->type == 4 ? '订金' : '支付' }}金额</td>
                                @if($baseinfo->type == 4)
                                <td>{{ sprintf("%.2f", ($baseinfo->price)) }}</td>
                                @else
                                <!-- {{ sprintf('%.2f', $baseinfo->order_price -  $baseinfo->coupons - $baseinfo->vipcode - ($baseinfo->integral / 50)) }} -->
                                <td><input type="text" value="{{ $baseinfo->price }}" name="order[price]" class="form-control"  @if($groupType == $configGroupType ) readOnly="true"  @endif ></td>
                                @endif
                            </tr>
                            @if($baseinfo->type == 4)
                            <tr data-id="1">    
                                <td>成交阶梯价</td>
                                <td><?php echo $baseinfo->ladder ?></td>
                            </tr>
                            @foreach($info as $value)
                            <tr data-id="1">    
                                <td>二次支付价格</td>
                                <td>【{{ $value['goodsname'] }}】二次支付金额：{{ $value['finalpay'] }}</td>
                            </tr>
                            <tr data-id="1">    
                                <td>支付金额</td>
                                <td><input type="text" value="{{ $baseinfo->order_price }}" name="order[price]" class="form-control"></td>
                            </tr>
                            @endforeach
                            @endif
                            <tr data-id="1">
                                <td>使用积分</td>
                                <td>{{ $baseinfo->integral }}积分,价值￥{{ $baseinfo->integral / 50 }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>优惠券抵扣</td>
                                <td>{{ $baseinfo->coupons }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>抵金券抵扣</td>
                                <td>{{ $baseinfo->vipcode }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>运费</td>
                                <td><input type="text" name="order[freight]" value="{{ $baseinfo->freight }}" class="form-control" @if($groupType == $configGroupType ) readOnly="true"  @endif ></td>
                            </tr>
                            <tr data-id="1">
                                <td>安装费</td>
                                <td><input type="text" name="order[install]" value="{{ $baseinfo->install }}" class="form-control" @if($groupType == $configGroupType ) readOnly="true"  @endif ></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">订单状态</label>
                <div class="col-sm-4">
                    @if($baseinfo->type == 4)
                    <select class="form-control" name="order[status]"  >
                        @if($groupType == $configGroupType )
                            <option @if($baseinfo->status == 2) selected @endif value="2">已发货</option>
                        @else
                            <option @if($baseinfo->status == 0) selected @endif value="0"   >等待付款</option>
                            <option @if($baseinfo->status == 5) selected @endif value="5"  >已付定金，待付尾款</option>
                            <option @if($baseinfo->status == 1) selected @endif value="1" >已付款待发货</option>
                            <option @if($baseinfo->status == 2) selected @endif value="2">已发货</option>
                            <option @if($baseinfo->status == 3) selected @endif value="3"  >已完成</option>
                            <option @if($baseinfo->status == 4) selected @endif value="4"  >订单取消</option>
                            <option @if($baseinfo->status == 6) selected @endif value="6"  >已退定金</option>
                        @endif
                    </select>
                    @else
                    <select class="form-control" name="order[status]"   >
                        @if($groupType == $configGroupType )
                            <option @if($baseinfo->status == 2) selected @endif value="2">已发货</option>
                        @else
                            <option @if($baseinfo->status == 0) selected @endif value="0"   >等待付款</option>
                            <option @if($baseinfo->status == 5) selected @endif value="5"  >已付定金，待付尾款</option>
                            <option @if($baseinfo->status == 1) selected @endif value="1" >已付款待发货</option>
                            <option @if($baseinfo->status == 2) selected @endif value="2">已发货</option>
                            <option @if($baseinfo->status == 3) selected @endif value="3"  >已完成</option>
                            <option @if($baseinfo->status == 4) selected @endif value="4"  >订单取消</option>
                            <option @if($baseinfo->status == 6) selected @endif value="6"  >已退定金</option>
                        @endif
                    </select>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">物流公司</label>
                <div class="col-sm-4">
                    <select name="order[logcom]" class="form-control"   >
                        <option value="">请选择物流公司</option>
                        @if($logistics)
                        @foreach($logistics as $key => $value)
                        <option value="{{ $key }}" @if($key == $baseinfo->logcom) selected @endif>{{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">@if(strlen($baseinfo->logcom) > 5) 请选择修改物流公司信息，原信息内容为：{{ $baseinfo->logcom }} @endif</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">物流单号</label>
                <div class="col-sm-4">
                    <input type="text" name="order[logistics]" value="{{ $baseinfo->logistics }}" class="form-control"   >
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">注：请输入连续的物流单号，单号之外的其他信息请不要输入,如：xxxxxxxxxx</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">收款方</label>
                <div class="col-sm-4">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>{{ $baseinfo->receiveway }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">支付方式</label>
                <div class="col-sm-4">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>@if($baseinfo->pay == 0) 在线支付 @else 线下付款 @endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">下单时间</label>
                <div class="col-sm-4">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>{{ date('Y-m-d H:i:s', $baseinfo->created) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">产品信息</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            @if(isset($info[0]))
                            @foreach($info as $value)
                            <tr data-id="1">
                                <td>产品标题</td>
                                <td>{{ $value['goodsname'] }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>产品图标</td>
                                <td><a href="/commodity/detail/{{ $value['goodsid'] }}"><img style="width:100px;height:100px;" src="{{ $value['imageurl'] }}"></a></td>
                            </tr>
                            <tr data-id="1">
                                <td>产品单价</td>
                                <td>{{ $value['price'] }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>购买数量</td>
                                <td>{{ $value['num'] }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>产品规格</td>
                                <td>{{ $value['specs'] }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>产品总价</td>
                                <td>{{ $value['totalprice'] }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>配送方式</td>
                                <td>@if($value['shipid'] == 0) 快递 @elseif($value['shipid'] == 1) EMS @elseif($value['shipid'] == 2) 平邮 @else 默认 @endif</td>
                            </tr>
                            <tr style="height:10px;"></tr>
                            @endforeach
                            @else
                            <tr data-id="1">
                                <td colspan="2">暂无数据</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">下单人信息</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>下单用户</td>
                                <td>{{ $baseinfo->user }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>下单公司名称</td>
                                <td>{{ $baseinfo->company ? $baseinfo->company : '---' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>公司地址</td>
                                <td>{{ $baseinfo->address ? $baseinfo->address : '---' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">收货人信息</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>收货人</td>
                                <td>{{ $baseinfo->receive->consignee }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>详细地址</td>
                                <td>{{ $baseinfo->receive->province }} {{ $baseinfo->receive->city }} {{ $baseinfo->receive->district }} {{ $baseinfo->receive->address }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>邮编</td>
                                <td>{{ $baseinfo->receive->zipcode }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>手机号码</td>
                                <td>{{ $baseinfo->receive->mobile }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>固定电话</td>
                                <td>{{ $baseinfo->receive->phone }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">开票信息</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>(<font color="red">公司信息</font>)单位名称</td>
                                <td>{{ isset($incoice->company) ? $incoice->company : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="red">公司信息</font>)公司电话</td>
                                <td>{{ isset($incoice->phone) ? $incoice->phone : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="red">公司信息</font>)纳税人识别码</td>
                                <td>{{ isset($incoice->taxnum) ? $incoice->taxnum : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="red">公司信息</font>)开户行</td>
                                <td>{{ isset($incoice->bank) ? $incoice->bank : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="red">公司信息</font>)公司地址</td>
                                <td>{{ isset($incoice->address) ? $incoice->address : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="red">公司信息</font>)银行账号</td>
                                <td>{{ isset($incoice->account) ? $incoice->account : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="blue">发票信息</font>)收票人</td>
                                <td>{{ isset($incoice->username) ? $incoice->username : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="blue">发票信息</font>)收票人手机</td>
                                <td>{{ isset($incoice->mobile) ? $incoice->mobile : '暂无' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="blue">发票信息</font>)收票人地址</td>
                                <td>{{ isset($incoice->province) ? $incoice->province : '---' }}&nbsp;{{ isset($incoice->city) ? $incoice->city : '---' }}&nbsp;{{ isset($incoice->dist) ? $incoice->dist : '---' }}</td>
                            </tr>
                            <tr data-id="1">
                                <td>(<font color="blue">发票信息</font>)详细地址</td>
                                <td>{{ isset($incoice->adddress) ? $incoice->adddress : '暂无' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">补充说明</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td>{{ $baseinfo->message }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">报价单</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            <tr data-id="1">
                                <td><a target="_blank" href="/orderpdf/{{ $baseinfo->ordersn }}" class="ubtn">点击查看</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">物流信息</label>
                <div class="col-sm-8">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <tbody>
                            @if($logisticsdetail)
                            @foreach($logisticsdetail as $value)
                            <tr data-id="1">
                                <td>{{ $value->datetime }}</td>
                                <td>{{ $value->remark }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr data-id="1">
                                <td>对不起，没有查到信息！</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="submit" onclick="return update();" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function update()
{
    $.ajax({
        type: "POST",
        url:"/superman/order/updateorderdetail/{{ $baseinfo->ordersn }}",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips']);
            if (msg['status'] == 0) {
                setTimeout("reload()", 1000)
            }
        },
        error: function(error){
            layer.msg("操作失败");
        }
    });
}
function reload()
{
    window.location.href = document.referrer;
}
</script>
@stop