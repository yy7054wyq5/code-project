@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>优惠券领取使用记录</h4>
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
                        <form action="/superman/coupons/list" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <label>
                                <input type="text" name="username" aria-controls="datatable1" placeholder="请输入用户名" class="form-control input-sm" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ""; ?>">
                            </label>
                            <label>
                                <select name="status"  class="form-control input-sm">
                                    <option value="">有效期状态</option>
                                    <option @if(Input::get('status') == '0') selected @endif value="0">未过期</option>
                                    <option @if(Input::get('status') == 1) selected @endif value="1">已过期</option>
                                </select>
                            </label>
                            <label>
                                <select name="freeze"  class="form-control input-sm">
                                    <option value="">冻结状态</option>
                                    <option @if(Input::get('freeze') == '0') selected @endif value="0">正常</option>
                                    <option @if(Input::get('freeze') == 1) selected @endif value="1">已冻结</option>
                                </select>
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    <button class="btn btn-sm btn-info" onclick="window.location.href = '/superman/coupons/exportexceldetail'">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>优惠券码</th>
                        <th>优惠券名称</th>
                        <th>领用用户名</th>
                        <th>领取时间</th>
                        <th>使用时间</th>
                        <th>使用状态</th>
                        <th>有效期状态</th>
                        <th>冻结状态</th>
                        <th>使用订单号</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->id }}"></td>
                        <td>{{ $value->code }}</td>
                        <td>{{ $value->parentname }}</td>
                        <td>{{ $value->username }}</td>
                        <td>{{ $value->receivetime ? date('Y-m-d H:i', $value->receivetime) : '---' }}</td>
                        @if ($value->cstatus == 0)
                        <td>---</td>
                        @else
                        <td>{{ $value->usetime ? date('Y-m-d H:i', $value->usetime) : '---' }}</td>
                        @endif
                        <td>{{ $value->cstatus == 0 ? "未使用" : "已使用" }}</td>
                        <td>{{ $value->endtime < time() ? "已过期" : "未过期" }}</td>
                        <td>{{ $value->freeze == 0 ? "未冻结" : "已冻结" }}</td>
                        <td>{{ $value->ordersn ? $value->ordersn : '---' }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
<script type="text/javascript">
function delCheckItems() {
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要删除选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/coupons/delcouponslist", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}

function reload()
{
    window.location.reload();
}
</script>
@stop