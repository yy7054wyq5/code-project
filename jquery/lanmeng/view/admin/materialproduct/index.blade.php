@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center;}
        .name{width: 30%;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>官方素材产品</h4>
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
                        <form action="/superman/materialproduct/index" method="get">
                            <div class="pull-left">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>素材标题:</label>
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
                                    <label>状态:</label>
                                    <label>
                                        <select  name="status"   class="form-control input-sm" >
                                            <option value="-1" checked="true" >请选择</option>
                                            <option value="0" >未审核</option>
                                            <option value="1" >审核通过</option>
                                            <option value="2" >审核未通过</option>
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                    &nbsp;&nbsp;
                                    @if(in_array('add', $buttonrole))
                                    <a href="/superman/materialproduct/add" class="btn btn-sm btn-info">新增</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <div class="clearfix">
                            &nbsp;&nbsp;
                                    <button class="btn btn-sm btn-info" onclick="exports('/superman/materialproduct/exlists')">导出Excel</button>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <table style="TABLE-LAYOUT: fixed" id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                        <thead>
                        <tr role="row">
                            <th width="3%"><input type="checkbox"  class="J_checkall"></th>
                            <th width="3%">ID</th>
                            <th width="5%">名称</th>
                            <th width="6%">所属分类</th>
                            <th width="6%">上传会员</th>
                            <th width="6%">所属品牌</th>
                            <th width="6%">所属车型</th>
                            <th width="6%">附件链接</th>
                            <th width="6%">所需积分</th>
                            <th width="4%">状态</th>
                            <th width="4%">排序</th>
                            <th width="6%">修改时间</th>
                            <th width="6%">修改人</th>
                            <th width="4%">操作</th>
                        </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if(count($lists)>0)
                            @foreach($lists as $key => $value)
                                <tr>
                                    <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value->materialId}}"></td>
                                    <td style="WORD-WRAP: break-word" >{{$value->materialId}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->materialName}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->categoryName}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->username}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->brandName}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->carmodelName}}</td>
                                    <td style="WORD-BREAK:break-all; ">{{$value->attachmentName}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->integral}}</td>
                                    <td style="WORD-WRAP: break-word" >
                                              @if($value->status == 0) 未审核
                                              @elseif($value->status == 1) 审核通过
                                              @elseif($value->status == 2) 审核未通过
                                              @endif
                                    </td>
                                    <td style="WORD-WRAP: break-word" >{{$value->sort}}</td>
                                    <td style="WORD-WRAP: break-word" >{!! $value->created ? date('Y-m-d H:i:s',$value->created) :"——" !!}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->updateUser}}</td>
                                    <td>
                                        @if(in_array('edit', $buttonrole))
                                        <a href="/superman/materialproduct/edit/{{$value->materialId}}" class="btn btn-success btn-xs" >修改</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="13">暂无数据</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left">
                            @if(in_array('del', $buttonrole))
                            &nbsp;&nbsp;<button onclick="storedel()" style="margin-top: 10px;" class="btn btn-primary">批量删除</button>
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
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
<script type="text/javascript">
    $(function(){
        //全选
        $(".J_checkall").change(function(){
            $('.J_checkitem').prop("checked",this.checked);
        });
        // 审核
        $("select[name='status']").change(function(){
            var status = $(this).val();
            var id     = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url:"/superman/materialproduct/changestatus",
                data:{'_token':'{{ csrf_token() }}','id':id,'status':status},
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
    })

    function storedel()
    {
        $.ajax({
            type: "POST",
            url:"/superman/materialproduct/del",
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
        location.href = '/superman/materialproduct/index';
    }
</script>
@stop