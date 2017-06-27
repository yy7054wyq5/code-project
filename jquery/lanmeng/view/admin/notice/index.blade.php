@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; }
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>公告管理</h4>
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
                            <form action="/superman/notice/index" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                        @if(in_array('add', $buttonrole))
                            &nbsp;&nbsp;<a href="/superman/notice/add" class="btn btn-sm btn-primary"  >新增</a>
                            @endif
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <table style="TABLE-LAYOUT: fixed"  id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <thead>
                        <tr role="row">
                            <th width="5%"><input type="checkbox"  class="J_checkall"></th>
                            <th width="8%">信息ID</th>
                            <th width="30%">标题</th>
                            <th width="8%">推荐</th>
                            <th width="8%">状态</th>
                            <th width="10%">修改时间</th>
                            <th width="10%">修改人</th>
                            <th width="10%">修改操作</th>
                        </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if (count($lists)>0)
                            @foreach ($lists as $value)
                                <tr>
                                    <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value -> id }}"></td>
                                    <td>{{$value -> id}} </td>
                                    <td style="WORD-WRAP:break-word">{{$value -> title}} </td>
                                    <td>@if($value -> recommend)推荐@else不推荐@endif</td>
                                    <td>@if($value-> show == 1)显示@else隐藏@endif</td>
                                    <td>{{ $value-> created }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td>@if(in_array('edit', $buttonrole))<a href="/superman/notice/edit/{{$value->id}}" class="btn btn-success btn-xs" >修改</a>
                                    @endif
                                      <!--  <a href="/superman/notice/delone/{{$value->id}}" class="btn btn-danger btn-xs" >删除</a> -->
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">暂无数据</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left">
                            @if(in_array('del', $buttonrole))&nbsp;&nbsp;<button onclick="return store()" class="btn btn-primary">批量删除</button>@endif
                        </div>
                        <div class="pull-right">
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">
                                   {!! $pager !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
<script type="text/javascript">
    $(function(){
        //全选
        $(".J_checkall").change(function(){
            $('.J_checkitem').prop("checked",this.checked);
        });
    });
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/notice/del",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/notice/index';
    }
</script>
@stop