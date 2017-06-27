@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center;}
     </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>资讯管理</h4>
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
                            <form action="/superman/infolist/index" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>&nbsp;&nbsp;
                                    <label>信息分类</label>
                                    <label>
                                        <select name="categoryId" class="form-control input-sm" >
                                            <option value="0" >请选择</option>
                                            @foreach($infoCategory as $key => $item)
                                              <option value="{{$item['typeid']}}" @if(isset($_GET['categoryId']) && $_GET['categoryId'] == $item['typeid'])  selected  @endif>{{$item['type_name']}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                            @if(in_array('add', $buttonrole))&nbsp;&nbsp;<a href="/superman/infolist/add" class="btn btn-sm btn-primary"  >新增</a>
                            &nbsp;&nbsp;<a href="/superman/infotype/index" class="btn btn-sm btn-primary"  >信息类别管理</a>@endif
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <thead>
                        <tr role="row">
                            <th width="3%"><input type="checkbox"  class="J_checkall"></th>
                            <th width="8%">{!! Lang::get("admin.infolist.infoId") !!}</th>
                            <th width="26%">{!! Lang::get("admin.infolist.infoTitle")  !!}</th>
                            <th width="10%">{!! Lang::get("admin.infolist.infoType")  !!}</th>
                            <th width="10%">{!! Lang::get("admin.infolist.modifyTime")  !!}</th>
                            <th width="8%">{!! Lang::get("admin.infolist.modifyPerson")  !!}</th>
                            <th width="10%">修改操作</th>
                        </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if (count($lists)>0)
                            @foreach ($lists as $value)
                                <tr>
                                    <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value -> infoId }}"></td>
                                    <td>{{$value -> infoId}} </td>
                                    <td>{{$value -> infoTitle}} </td>
                                    <td>{{$value -> type_name}} </td>
                                    <td>{{ $value-> created }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td>@if(in_array('edit', $buttonrole))<a href="/superman/infolist/edit/{{$value->infoId}}" class="btn btn-success btn-xs" >修改</a>@endif
                                        <a href="/infor/detail/{{$value->infoId}}" class="btn btn-xs btn-primary">预览</a>
                                        @if(in_array('del', $buttonrole))<a href="/superman/infolist/delone/{{$value->infoId}}" class="btn btn-danger btn-xs" >删除</a>@endif
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
            url:"/superman/infolist/del",
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
        location.href = '/superman/infolist/index';
    }
</script>
@stop