@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 14px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i></h4>
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
                            <form action="/superman/msg/list" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>品牌名:</label>
                                    <label>
                                        <input type="text" name="brandName" aria-controls="datatable1" placeholder="请输入品牌名" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <label>商品分类:</label>
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入商品分类" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <label>审核状态:</label>
                                    <label>
                                        <select  name="status"  placeholder="请输入关键词" class="form-control input-sm" >
                                            <option value="0" >已审核</option>
                                            <option value="1" >未审核</option>
                                        </select>
                                    </label>

                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                            @if(in_array('add', $buttonrole))&nbsp;&nbsp;<a href="/superman/infolist/add" class="btn btn-sm btn-primary"  >添加</a>@endif
                        </div>
                    </div>
                </div>
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th>系统ID</th>
                        <th>所属产品</th>
                        <th>发表会员</th>
                        <th>评论内容</th>
                        <th>留言状态</th>
                        <th>修改时间</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td>{{$value -> commentId}} </td>
                                <td>{{$value -> brandId}} </td>
                                <td>{{$value -> userId}} </td>
                                <td>{{$value -> content}} </td>
                                <td>{{ $value-> status }}</td>
                                <td>{{ $value->updated }}</td>
                                <td>@if(in_array('edit', $buttonrole))<a href="infolist/edit/{{$value->commentId}}" class="btn btn-success btn-xs" >修改</a>@endif
                                    @if(in_array('del', $buttonrole))<a href="infolist/del/{{$value->commentId}}" class="btn btn-danger btn-xs" >删除</a>@endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
<script type="text/javascript" >
    $(function(){
        //刷新
        $('#J_refresh').live('click', function(){
            $('#J_rframe iframe:visible')[0].contentWindow.location.reload();
        });
    })
</script>
@stop