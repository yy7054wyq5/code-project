@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>互动社区</h4>
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
                        <form action="/superman/interact/bbs" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    @if(in_array('add', $buttonrole))
                    <a href="/superman/interact/create" class="btn btn-sm btn-info">新增</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>系统ID</th>
                        <th>文章标题</th>
                        <th>添加人</th>
                        <th>添加时间</th>
                        <th>修改</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->id }}"></td>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->title }}</td>
                        <td>{{ $value->user }}</td>
                        <td>{{ date('Y-m-d H:i', $value->created) }}</td>
                        <td><a href="{{ $value->url }}" target="_blank" class="btn btn-primary btn-xs">跳转</a>&nbsp;@if(in_array('edit', $buttonrole))<a href="/superman/interact/edit/{{ $value->id }}" class="btn btn-success btn-xs">修改</a>@endif</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6">暂无数据</td>
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
        $.post("/superman/interact/delbbs", { group: temp,  _token : $("#token").val() } );
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