@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 14px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>信息类别管理</h4>
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
                            <form action="/superman/infotype/index" method="get">
                              <!--  <div class="dataTables_filter" id="datatable1_filter">
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div> -->
                            </form>
                        </div>
                        <div class="clearfix">
                        <!--   &nbsp;&nbsp; <a href="/superman/infotype/add" class="btn btn-sm btn-primary"  >添加</a> -->
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width=25><input type="checkbox"  class="J_checkall"></th>
                        <th>{!! Lang::get("admin.infotype.typeid") !!}</th>
                        <th>{!! Lang::get("admin.infotype.typename")  !!}</th>
                        <th>{!! Lang::get("admin.infotype.modify_time")  !!}</th>
                        <th>{!! Lang::get("admin.manager")!!}</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if ($lists)
                        @foreach ($lists as $value)
                            <tr>
                                <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value->typeid }}"></td>
                                <td>{{ $value->typeid }}</td>
                                <td>{{ $value->type_name }}</td>
                                <td>{{ date('Y-m-d H:i',$value->created)}}</td>
                                <td><a href="/superman/infotype/edit/{{$value->typeid}}" class="btn btn-success btn-xs">修改</a>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                       <!-- <div class="pull-left">
                            &nbsp;&nbsp;<button onclick="return store()" class="btn btn-primary">批量删除</button>
                        </div>  -->
                        <div class="pull-right">
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">
                                {!! $lists->render() !!}
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
            url:"/superman/infotype/del",
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
        location.href = '/superman/infotype';
    }
</script>
@stop