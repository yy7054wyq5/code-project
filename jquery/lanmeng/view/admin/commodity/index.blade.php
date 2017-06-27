@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 14px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>商品管理</h4>
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
                            <form action="/superman/commodity/index" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>品牌名称:</label>
                                    <label>
                                        <input type="text" name="brandName" aria-controls="datatable1" placeholder="请输入品牌名称" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <label>商品标题:</label>
                                    <label>
                                        <input type="text" name="commodityName" aria-controls="datatable1" placeholder="请输入商品标题" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <label>状态:</label>
                                    <label>
                                        <select  name="status"   class="form-control input-sm" >
                                            <option value="-1" checked="true" >请选择</option>
                                            <option value="1" >上架</option>
                                            <option value="0" >下架</option>
                                        </select>
                                    </label>
                                    <label>分类:</label>
                                    <label>
                                        <select  name="categoryId"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @foreach($categoryList as $item)
                                               <option value="{{$item->categoryId}}" >{{$item->categoryName}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                            @if(in_array('add', $buttonrole))&nbsp;&nbsp;<a href="/superman/commodity/add" class="btn btn-sm btn-primary"  >新增</a>@endif
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width=25><input type="checkbox"  class="J_checkall"></th>
                        <th>商品编号</th>
                        <th>产品ID</th>
                        <th>商品名称</th>
                        <th>所属类别</th>
                        <th>所属品牌</th>
                        <th>状态</th>
                        <th>修改时间</th>
                        <th>修改人</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value->commodityId}}"></td>
                                <td>{{$value->commodityId }} </td>
                                <td>{{$value ->productId }}</td>
                                <td>{{$value ->commodityName }}</td>
                                <td>{{$value ->categoryName }} </td>
                                <td>{{$value -> brandName}}</td>
                                <td>@if($value->status == 1)上架@else下架@endif</td>
                                <td>{{ $value->created }}</td>
                                <td>{{$value ->username}} </td>
                                <td>@if(in_array('edit', $buttonrole))<a href="/superman/commodity/edit/{{$value->commodityId}}" class="btn btn-success btn-xs" >修改</a>@endif
                                    <a href="javascript:void(0);" data-id="{{$value->commodityId}}"   class="btn btn-success btn-xs copy " >复制</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left" >
                            @if(in_array('del', $buttonrole))&nbsp;&nbsp;<a href="javascript:void(0);" onclick="store()"  class="btn btn-sm btn-primary"  >批量删除</a>@endif
                            @if(in_array('edit', $buttonrole))
                            &nbsp;&nbsp;<a href="javascript:void(0)" onclick="change_status()" class="btn btn-sm btn-primary"  > 批量上架</a>
                            @endif
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

        $('.copy').on('click',function(){
             $.ajax({
             type: "POST",
             url:"/superman/commodity/copy",
             data:{'_token':'<?php echo csrf_token() ?>','id':$(this).attr('data-id')},
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
        });
    });
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/commodity/del",
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

    function change_status()
    {
        $.ajax({
            type: "POST",
            url:"/superman/commodity/status",
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
        location.href = '/superman/commodity/index';
    }
</script>
@stop
