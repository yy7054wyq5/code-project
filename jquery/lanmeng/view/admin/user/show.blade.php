@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>用户列表</h4>
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
                        <form action="/superman/account/user" method="get">
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
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>用户ID</th>
                        <th>用户名称</th>
                        <th>姓名</th>
                        <th>Email</th>
                        <th>Tel</th>
                        <th>所属角色</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->uid }}"></td>
                        <td>{{ $value->uid }}</td>
                        <td>{{ $value->username }}</td>
                        <td>{{ $value->realname }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->mobile }}</td>
                        <td>{{ $value->groupname }}</td>
                        <td>{{ date('Y-m-d H:i', $value->created) }}</td>
                        <td><a href="/superman/user/auth/{{ $value->uid }}">查看</a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="9">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
@stop