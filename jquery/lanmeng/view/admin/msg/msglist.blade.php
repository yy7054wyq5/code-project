@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
.name{width: 30%;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>意见反馈</h4>
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
                    <form action="/superman/msg/list" method="get">
                    <div class="pull-left">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                    </div>
                    </form>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>系统ID</th>
                        <th>联系人</th>
                        <th>联系方式</th>
                        <th>邮箱</th>
                        <th>公司名称</th>
                        <th>提交日期</th>
                        <th>留言详情</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->id }}"></td>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->username }}</td>
                        <td>{{ $value->linktype }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->company }}</td>
                        <td>{{ date('Y-m-d H:i', $value->created) }}</td>
                        <td><a href="javascript:void(0)" onclick="show({{ $value }});">查看详细</a></td>
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
function show(content) {
    var html = '<table class="table table-striped table-hover table-bordered">';
    html += "<tr><td class='name'>所属品牌</td><td>";
    html += content.brand;
    html += "</td></tr>";
    html += "<tr><td class='name'>公司名称</td><td>";
    html += content.company;
    html += "</td></tr>";
    html += "<tr><td class='name'>姓名</td><td>";
    html += content.username;
    html += "</td></tr>";
    html += "<tr><td class='name'>联系方式</td><td>";
    html += content.linktype;
    html += "</td></tr>";
    html += "<tr><td class='name'>E-mail</td><td>";
    html += content.email;
    html += "</td></tr>";
    html += "<tr><td class='name'>留言内容</td><td>";
    html += content.content;
    html += "</td></tr>";
    html += "</table>";
    layer.open({
        type: 1,
        title: "留言详细",
        skin: 'layui-layer-rim', //加上边框
        area: ['700px', '320px'], //宽高
        content: html
    });
}
</script>
@stop