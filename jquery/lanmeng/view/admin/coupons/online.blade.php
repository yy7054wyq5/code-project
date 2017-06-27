@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>线上优惠券</h4>
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
                        <form action="/superman/coupons/online" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
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
                    @if(in_array('add', $buttonrole))
                    <a href="/superman/coupons/addonline" class="btn btn-sm btn-info">新增</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('edit', $buttonrole))
                    <button class="btn btn-sm btn-info" onclick="changeStatus(1);">冻结</button>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-info" onclick="changeStatus(0);">解冻</button>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    <button class="btn btn-sm btn-info" onclick="window.location.href = '/superman/coupons/exportexcel/0'">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>系统ID</th>
                        <th>优惠券名称</th>
                        <th>数量</th>
                        <th>类型</th>
                        <th>有效期状态</th>
                        <th>优惠券金额</th>
                        <th>状态</th>
                        <th>领取链接</th>
                        <!-- <th>预览</th> -->
                        <th>优惠券</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->id }}"></td>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->num }}</td>
                        <td>{{ $value->type == 1 ? "橙券" : "蓝券"}}</td>
                        <td>{{ $value->endtime < time() ? "已过期" : "未过期" }}</td>
                        <td>{{ $value->price }}</td>
                        <td>{{ $value->status == 0 ? "正常" : "冻结" }}</td>
                        <td><a href="javascript:;" data-clipboard-text="http://<?php echo $_SERVER['HTTP_HOST']?>/coupons/getcp/{{ base64_encode($value->id) }}" class="copyBtn btn btn-success btn-xs">复制</a></td>
                        <!-- <td><a href="/coupons/get/{{ $value->id }}" class="btn btn-success btn-xs">查看</a></td> -->
                        <td><a href="/superman/coupons/showlist/{{ $value->id }}" class="btn btn-primary btn-xs">优惠券列表</a></td>
                        <td>@if(in_array('edit', $buttonrole))<a href="/superman/coupons/editonline/{{ $value->id }}" class="btn btn-success btn-xs">修改</a>&nbsp;&nbsp;<a href="/superman/coupons/put/{{ $value->id }}" class="btn btn-info btn-xs">发放</a>@else --- @endif</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="11">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
{!!HTML::script('common/copy/ZeroClipboard.min.js') !!}
<script type="text/javascript">
function delCheckItems() {
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要删除选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/coupons/dellist", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}

function changeStatus(status)
{
    var type = status == 1 ? "冻结" : "解冻";
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要'+type+'选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/coupons/changestatus", { group: temp, type : status, _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}

function reload()
{
    window.location.reload();
}

var clip = new ZeroClipboard( $('.copyBtn') );
clip.on('aftercopy', function (evt) {
  layer.msg('复制成功:<br>' + evt.data['text/plain'])
});

</script>
@stop
