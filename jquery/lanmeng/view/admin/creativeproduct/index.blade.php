@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center;  }
        .name{width: 30%;}
        .form-control { width:250px; }
        .editor-class { width:800px;}
    </style>
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
        .editor-class { width: 800px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>创意设计产品</h4>
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
                        <form action="/superman/creativeproduct/index" method="get">
                            <div class="pull-left">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>商品名称:</label>
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1"  class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <label>品牌:</label>
                                    <label>
                                        <select  name="brandId"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @foreach($brandList as $key => $item)
                                                <option value="{{$key}}" >{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label>分类:</label>
                                    <label>
                                        <select  name="categoryId"   class="form-control input-sm" >
                                            <option value="0"  checked="true" >请选择</option>
                                           @foreach($subjectList as $key => $item)
                                            <option value="{{$key}}" >{{$item}}</option>
                                           @endforeach
                                        </select>
                                    </label>
                                    <label>状态:</label>
                                    <label>
                                        <select  name="status"   class="form-control input-sm" >
                                            <option value="-1" checked="true" >请选择</option>
                                            <option value="1" >上架</option>
                                            <option value="0" >下架</option>
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                    &nbsp;&nbsp;
                                    @if(in_array('add', $buttonrole))<a href="/superman/creativeproduct/add" class="btn btn-sm btn-info">新增</a>@endif
                                </div>
                            </div>
                        </form>
                        <div class="clearfix">
                            &nbsp;&nbsp;
                                    <button class="btn btn-sm btn-info" onclick="exports('/superman/creativeproduct/exlists')">导出Excel</button>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table id="datatable1" style="TABLE-LAYOUT: fixed" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="3%"><input type="checkbox"  class="J_checkall"></th>
                        <th width="8%">产品ID</th>
                        <th width="12%">货号</th>
                        <th width="20%">商品名称</th>
                        <th width="10%">主题类别</th>
                        <th width="10%">所属品牌</th>
                        <th width="8%">状态</th>
                        <th width="8%">排序</th>
                        <th width="10%">修改时间</th>
                        <th width="8%">修改人</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(count($lists)>0)
                        @foreach($lists as $key => $value)
                        <tr>
                            <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value->creativeId}}"></td>
                            <td style="WORD-WRAP: break-word" >{{$value->creativeId}}</td>
                            <td style="WORD-WRAP: break-word" >{{$value->goodsId}}</td>
                            <td style="WORD-WRAP: break-word" >{{$value->commodityName}}</td>
                            <td style="WORD-WRAP: break-word" >{{$value->name}}</td>
                            <td style="WORD-WRAP: break-word" >{{$value->brandName}}</td>
                            <td style="WORD-WRAP: break-word" >@if($value->status == 1)上架 @endif
                                @if($value->status == 0) 下架 @endif </td>
                            <td style="WORD-WRAP: break-word" >{{$value->sort}}</td>
                            <td style="WORD-WRAP: break-word" >{{date('Y-m-d H:i',$value->created)}}</td>
                            <td style="WORD-WRAP: break-word" >{{$value->username}}</td>
                            <td style="WORD-WRAP: break-word" >
                                @if(in_array('edit', $buttonrole))<a href="/superman/creativeproduct/edit/{{$value->creativeId}}" class="btn btn-success btn-xs" >修改</a>
                                <a href="/superman/mall/package?type=4&typeId={{$value->creativeId}}" class="btn btn-danger btn-xs" >套餐</a> @else --- @endif
                           </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left">
                            @if(in_array('del', $buttonrole))&nbsp;&nbsp;<button onclick="return store()"  style="margin-top: 10px;"  class="btn btn-primary">批量删除</button>@endif
                            @if(in_array('edit', $buttonrole))&nbsp;&nbsp;<button onclick="change_status()" style="margin-top: 10px;"  class="btn btn-sm btn-primary"  > 批量上架</button>@endif
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
 {!!HTML::script('super/laydate/laydate.js') !!}
 {!!HTML::script('js/admin/export.js') !!}
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
            url:"/superman/creativeproduct/del",
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
            url:"/superman/creativeproduct/status",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    if(msg['status']){
                        setTimeout("reload()", 1200)
                    }
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/creativeproduct/index';
    }
</script>
@stop