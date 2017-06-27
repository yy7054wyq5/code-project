@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; }
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>商品管理 </h4>
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
                            <form action="/superman/riders/index" method="get">
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
                            &nbsp;&nbsp; <a href="/superman/riders/add" class="btn btn-sm btn-primary"  >新增</a>
                        @endif
                        &nbsp;&nbsp;
                        <button class="btn btn-sm btn-info" onclick="exports('/superman/riders/exlists')">导出Excel</button>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="3%"><input type="checkbox"  class="J_checkall"></th>
                        <th width="7%">产品ID</th>
                        <th width="8%" >商品编号</th>
                        <th width="22%">商品名称</th>
                        <th width="8%">所属类别</th>
                        <th width="8%">所属品牌</th>
                        <th width="5%">状态</th>
                        <th width="8%" >修改时间</th>
                        <th width="8%">修改人</th>
                        <th width="12%">操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value -> ridersId }}"></td>
                                <td>{{$value -> ridersId}}</td>
                                <td>{{$value -> commodityId}}</td>
                                <td>{{$value -> commodityName}}</td>
                                <td>{{ $value->type == 1 ? "主题游" : "说走就走"}}</td>
                                <td>{{$value->brandName}}</td>
                                <td><select  name="status"  id="satus" data-id="{{$value -> ridersId}}"  >
                                        <option value="1" {!! $value->status == 1?'selected':'' !!} >上架</option>
                                        <option value="0" {!! $value->status == 0?'selected':'' !!} >下架</option>
                                    </select>
                                </td>
                                <td>{{$value->created}}</td>
                                <td>{{$value->username}}</td>
                                <td>@if(in_array('edit', $buttonrole))<a href="/superman/riders/edit/{{$value->ridersId}}" class="btn btn-success btn-xs" >修改</a>@endif
                                    <a href="javascript:void(0)" data-id="{{$value->ridersId}}" class="btn  btn-xs  btn-primary copy" >复制</a>
                                    @if(in_array('edit', $buttonrole))<a href="/superman/mall/package?type=3&typeId={{$value->ridersId}}" class="btn btn-danger btn-xs" >套餐</a>@endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                    </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left">
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">
                                @if(in_array('del', $buttonrole))&nbsp;&nbsp; <a href="javascript:void(0)" onclick="store()" class="btn btn-sm btn-primary"  >批量删除</a>@endif
                                @if(in_array('edit', $buttonrole))&nbsp;&nbsp; <a href="javascript:void(0)"  onclick="Changestatus()" class="btn btn-sm btn-primary"  >批量上架</a>@endif
                            </div>
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
        $('.copy').on('click',function(){
            $.ajax({
                type: "POST",
                url:"/superman/riders/copy",
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
        })
    });

    /**
     * 批量删除
     */
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/riders/del",
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
    /**
     * 批量上架
     */
     function Changestatus()
     {
         $.ajax({
             type: "POST",
             url:"/superman/riders/changestatus",
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
        location.href = '/superman/riders/index';
    }
</script>
@stop
