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
                            <form method="get" action="/superman/mall/list" >
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>商品标题:</label>
                                    <label>
                                        <input type="text" name="commodityName" aria-controls="datatable1" placeholder="请输入商品标题" class="form-control input-sm" value="<?php echo isset($_GET['commodityName']) ? $_GET['commodityName'] : ""; ?>">
                                    </label>

                                    <label>品牌名称:</label>
                                    <label>
                                        <select  name="brandId"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @foreach($brandList as $item)
                                                <option value="{{$item->brandId}}" @if(array_get($_GET, 'brandId') == $item->brandId) selected @endif>{{$item->brandName}}</option>
                                            @endforeach
                                        </select>
                                    </label>

                                    <label>状态:</label>
                                    <label>
                                        <select  name="status"   class="form-control input-sm" >
                                            <option value="-1" checked="true" >请选择</option>
                                            <option value="1" @if(array_get($_GET, 'status') == 1) selected @endif>上架</option>
                                            <option value="0" @if(!is_null(array_get($_GET, 'status')) &&array_get($_GET, 'status') == 0) selected @endif>下架</option>
                                        </select>
                                    </label>
                                    <label>分类:</label>
                                    <label>
                                            <select name="parentCategoryId" id="parentCategoryId" class="form-control" >
                                                <option value="0" checked="true" >请选择一级分类</option>
                                                @foreach($categoryList as $item)
                                                    <option value="{{$item->id}}" @if(array_get($_GET, 'parentCategoryId') == $item->id) selected @endif>{{$item->name}}</option>
                                                @endforeach
                                            </select>

                                        <select name="categoryId" id="categoryId" class="form-control" >
                                            <option value="0" >请选择</option>
                                            @if(isset($childCategories) && count($childCategories) >0)
                                                @foreach($childCategories as $childCategory)
                                                    <option value="{{$childCategory['id']}}" @if(array_get($_GET, 'categoryId') == $childCategory['id']) selected @endif>{{$childCategory['name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                            @if(in_array('add', $buttonrole))&nbsp;&nbsp;<a href="/superman/mall/addcommodity" class="btn btn-sm btn-primary" >新增</a>@endif
                            &nbsp;&nbsp;
                            <button class="btn btn-sm btn-info" onclick="exports('/superman/mall/exlists')">导出Excel</button>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table id="datatable1" style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="5%"><input type="checkbox"  class="J_checkall"></th>
                        <th width="10%">商品编号</th>
                        <th width="7%">产品ID</th>
                        <th width="8%">商品名称</th>
                        <th width="10%">所属类别</th>
                        <th width="8%">所属品牌</th>
                        <th width="5%">状态</th>
                        <th width="5%">排序</th>
                        <th width="10%">修改时间</th>
                        <th width="7%">修改人</th>
                        <th width="15%">操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($commodities)>0)
                        @foreach ($commodities as $value)
                            <tr>
                                <td align="center"><input type="checkbox" name="commodityIds[]" class="J_checkitem" value="{{ $value['id']}}"></td>
                                <td style="WORD-WRAP: break-word" >{{$value['code'] }} </td>
                                <td style="WORD-WRAP: break-word" >{{ $value['tag'] == 1 ? $value['oldId'] : $value['id'] }}</td>
                                <td style="WORD-WRAP: break-word" >{{$value['name'] }}</td>
                                <td style="WORD-WRAP: break-word" >{{$value['category']['name'] }}</td>
                                <td style="WORD-WRAP: break-word" >{{$value['brand']['brandName'] }}</td>
                                <td style="WORD-WRAP: break-word" >@if($value['status'] == 1)上架@else下架@endif</td>
                                <td style="WORD-WRAP: break-word" >{{$value['sort']}}</td>
                                <td style="WORD-WRAP: break-word" >{{$value['updated']}} </td>
                                <td style="WORD-WRAP: break-word" >{{$value['userInfo']['username']}} </td>
                                <td style="WORD-WRAP: break-word" >@if(in_array('edit', $buttonrole))<a href="/superman/mall/editcommodity/{{$value['id']}}" class="btn btn-success btn-xs" >修改</a>@endif
                                    <a href="javascript:void(0)" onclick="copyCommodity({{$value['id']}})"  class="btn btn-danger btn-xs" >复制</a>
                                    @if(in_array('edit', $buttonrole))<a href="/superman/mall/package?type=1&typeId={{$value['id']}}" class="btn btn-success btn-xs" >延展套餐</a>@endif
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
                    <?php echo $pager ?>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left" >
                            @if(in_array('del', $buttonrole))&nbsp;&nbsp;<a href="javascript:void(0);" onclick="batchDel()"  class="btn btn-sm btn-primary"  >批量删除</a>
                            @endif
                            @if(in_array('edit', $buttonrole))&nbsp;&nbsp;<a href="javascript:void(0)" onclick="batchStatusOn()" class="btn btn-sm btn-primary"  > 批量上架</a>
                            @endif
                        </div>
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
@stop
{!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
<script type="text/javascript">
    $(function(){
        //全选
        $(".J_checkall").change(function(){
            $('.J_checkitem').prop("checked",this.checked);
        });

        //  二级分类
        $("#parentCategoryId").change(function(){
            $.ajax({
                type: "GET",
                url:"/superman/mall/childcategory",
                data:{'categoryId':$(this).val(),'_token':'{{csrf_token()}}'},
                dataType: 'json',
                success: function(msg) {
                    console.log(msg);
                    if (msg.status == 0){
                        var html = '<option value="0" >请选择</option>';
                        for(var i=0;i<msg['content']['categories'].length;i++){
                            html += '<option value="'+msg['content']['categories'][i]['mallCategoryId']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                        }
                        $("#categoryId").html(html);
                        console.log(html);
                    }

                }
            });
        })
    });
    function batchDel()
    {
        $.ajax({
            type: "POST",
            url:"/superman/mall/batchdelete",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (msg.status ==0 && !msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function batchStatusOn()
    {
        $.ajax({
            type: "POST",
            url:"/superman/mall/batchstatuson",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (msg.status ==0 && !msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }


    function copyCommodity(commodityId)
    {
        $.ajax({
            type: "POST",
            url:"/superman/mall/copycommodity",
            data:{'commodityId':commodityId, '_token': $('#token').val()},
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (msg.status ==0 && !msg['url']) {
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
        location.href = '/superman/mall/list';
    }
</script>
