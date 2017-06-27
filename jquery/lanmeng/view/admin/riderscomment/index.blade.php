@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; }
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>车友汇评论管理</h4>
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
                            <form action="/superman/riderscomment/index" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                  <!--  <label>评论内容关键词:</label> -->
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入评论内容关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <label>状态:</label>
                                    <label>
                                        <select  name="status"  placeholder="请输入关键词" class="form-control input-sm" >
                                            <option value="-1" >请选择</option>
                                            <option value="3" >未审核</option>
                                            <option value="1" >审核未通过</option>
                                            <option value="2" >审核通过</option>
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        &nbsp;&nbsp;
                        <button class="btn btn-sm btn-info" onclick="exports('/superman/riderscomment/excomment')">导出Excel</button>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width=25><input type="checkbox"  class="J_checkall"></th>
                        <th>评论ID</th>
                        <th>所属产品标题</th>
                        <th>评论人名称</th>
                        <th>评论内容</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value->id}}"></td>
                                <td>{{$value -> id}} </td>
                                <td>{{$value -> commodityTitle}} </td>
                                <td>{{$value -> username}} </td>
                                <td>{{$value -> comment}} </td>
                                <td>
                                    <select name="status" class="satus"  data-id="{{$value -> id}}" >
                                        <option value="0" {!! $value-> status == 0 ? "selected":""   !!} >未审核</option>
                                        <option value="1" {!! $value-> status == 1 ? "selected":""   !!} >审核未通过</option>
                                        <option value="2" {!! $value-> status == 2 ? "selected":""   !!}  >审核通过</option>
                                    </select>
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
                            @if(in_array('del', $buttonrole))&nbsp;&nbsp;<a href="javascript:void(0);" onclick="store()" class="btn btn-sm btn-primary"  >批量删除</a>
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
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
<script type="text/javascript">
    $(function(){
        //全选
        $(".J_checkall").change(function(){
            $('.J_checkitem').prop("checked",this.checked);
        });

        //状态操作
        $(".satus").change(function(){
            var status = $(this).val();
            var id     = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url:"/superman/riderscomment/changestatus",
                data:{'_token':'{{ csrf_token() }}','id':id,'status':status},
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg['tips'])
                    if (!msg['url']) {
                        //   setTimeout("reload()", 1000)
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
            url:"/superman/riderscomment/del",
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
        location.href = '/superman/riderscomment/index';
    }
</script>
@stop
