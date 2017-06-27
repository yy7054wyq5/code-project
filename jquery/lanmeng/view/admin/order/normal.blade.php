@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>普通订单</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-left">
                        <form action="/superman/order/normal" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入订单号" class="form-control input-sm" value="{{ Input::get('keyword') }}">
                            </label>
                            <label>
                                <select style="width: 120px;" class="form-control input-sm" name="usergroup">
                                    <option value="">请选择会员类型</option>
                                    <option @if(Input::get('usergroup') == 9) selected @endif value="9">普通会员</option>
                                    <option @if(Input::get('usergroup') == 6) selected @endif value="6">经销商</option>
                                    <option @if(Input::get('usergroup') == 7) selected @endif value="7">区域分销商</option>
                                    <option @if(Input::get('usergroup') == 8) selected @endif value="8">合作伙伴</option>
                                </select>
                            </label>
                            <label>
                                <input type="text" name="consignee" aria-controls="datatable1" placeholder="收货人" style="width: 80px;" class="form-control input-sm" value="{{ Input::get('consignee') }}">
                            </label>
                            <label>
                                <input type="text" name="company" aria-controls="datatable1" placeholder="公司名称" class="form-control input-sm" value="{{ Input::get('company') }}">
                            </label>
                            <label>
                                <input type="text" name="account" aria-controls="datatable1" placeholder="账号" style="width: 80px;" class="form-control input-sm" value="{{ Input::get('account') }}">
                            </label>
                            <label>
                                <select style="width: 120px;" class="form-control input-sm" name="status">
                                    <option value="">请选择订单状态</option>
                                    <option @if(Input::get('status') == '0') selected @endif value="0">等待付款</option>
                                    <option @if(Input::get('status') == 1) selected @endif value="1">待发货</option>
                                    <option @if(Input::get('status') == 2) selected @endif value="2">已发货</option>
                                    <option @if(Input::get('status') == 3) selected @endif value="3">已完成</option>
                                    <option @if(Input::get('status') == 4) selected @endif value="4">已取消</option>
                                </select>
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('edit', $buttonrole))
                    <button class="btn btn-sm btn-primary" onclick="showLogistics();">分发</button>
                    @endif
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-info" onclick="showDate('/superman/order/exportexcel/0')">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="2%" ><input type="checkbox" class="checkall"></th>
                        <th width="7%" >订单编号</th>
                        <th width="5%" >账号</th>
                        <th width="5%" >公司</th>
                        <th width="6%" >收货人</th>
                        <th width="7%" >订单金额</th>
                        <th width="7%" >积分抵扣</th>
                        <th width="5%" >运费</th>
                        <th width="6%" >安装费</th>
                        <th width="7%" >支付方式</th>
                        <th width="6%" >收款方</th>
                        <th width="5%" >状态</th>
                        <th width="7%" >物流单号</th>
                        <th width="7%" >下单时间</th>
                        <th width="8%" >操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(isset($lists[0]))
                    @foreach($lists as $value)
                    <tr>
                    <td style="WORD-WRAP: break-word" ><input type="checkbox" name="check[]" value="{{ $value->orderid }}"></td>
                    <td style="WORD-WRAP: break-word" >{{ $value->ordersn }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->username }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->company }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->consignee }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->orderprice }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->ointegral / 50 }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->freight }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->install }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->pay }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->receive }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->status }}</td>
                    <td style="WORD-WRAP: break-word" >{{ $value->logistics ? $value->logistics : '---' }}</td>
                    <td style="WORD-WRAP: break-word" >{{ date('Y-m-d H:i', $value->ocreated) }}</td>
                    <td style="WORD-WRAP: break-word" >@if(in_array('edit', $buttonrole))<button class="btn btn-xs btn-info" @if($value->statuscode == 0 && $value->paycode == 0) disabled @endif onclick="payconfirm('{{ $value->ordersn }}');">发货</button>@endif&nbsp;<a class="btn btn-success btn-xs" href="/superman/order/show/{{ $value->ordersn }}">详细</a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="15">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
{!!HTML::script('js/admin/order.js') !!}
<script type="text/javascript">
function payconfirm(ordersn)
{
    $.ajax({
        type: "POST",
        url:"/superman/order/confirm/"+ordersn,
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
    window.location.reload();
}

function delCheckItems() {
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要删除选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/order/delorder", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}
</script>
@stop