@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>评论管理</h4>
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
                        <form action="/superman/gather/comment" method="get">
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
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="javascript:window.location.reload();">删除</button>
                    @endif
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-info" onclick="exports('/superman/gather/excomment')">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>系统ID</th>
                        <th>评论人</th>
                        <th>评论内容</th>
                        <th>审核状态</th>
                        <th>置顶状态</th>
                        <th>审核人</th>
                        <th>审核时间</th>
                        <th>置顶</th>
                        <th>审核</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->id }}"></td>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->username }}</td>
                        <td>{{ $value->comment }}</td>
                        <td>@if($value->status == 0) 未审核 @elseif ($value->status == 1) 审核未通过 @else 审核通过 @endif</td>
                        <td>@if($value->top == 0) 未置顶 @else 已置顶 @endif</td>
                        <td>{{ $value->auditor ? $value->auditor : '---' }}</td>
                        <td>{{ $value->audittime == 0 ? '---' : date('Y-m-d H:i', $value->audittime) }}</td>
                        <td>@if(in_array('edit', $buttonrole)) <a href="/superman/gather/top/{{ $value->id }}?status=1" class="btn btn-primary btn-xs">置顶</a>&nbsp;<a href="/superman/gather/top/{{ $value->id }}?status=0" class="btn btn-danger btn-xs">取消</a>@else --- @endif</td>
                        <td>@if(in_array('edit', $buttonrole)) <a href="/superman/gather/status/{{ $value->id }}?status=2" class="btn btn-success btn-xs">通过</a>&nbsp;<a class="btn btn-danger btn-xs" href="/superman/gather/status/{{ $value->id }}?status=1">驳回</a>@else --- @endif</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/commentbatchdel.js') !!}
{!!HTML::script('common/checkall.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
@stop