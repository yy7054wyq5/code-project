@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; }
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>聚惠广告管理 </h4>
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
                            <form action="/superman/juadvertisement/index" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    &nbsp;&nbsp;<label>广告位置:</label>
                                    <label>
                                        <select  name="position"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @foreach($position as $key => $item)
                                                <option value="{{$key}}" >{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                            @if(in_array('add', $buttonrole))&nbsp;&nbsp; <a href="/superman/juadvertisement/add" class="btn btn-sm btn-primary"  >新增</a>@endif
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table style="TABLE-LAYOUT: fixed" id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="5%"><input type="checkbox"  class="J_checkall"></th>
                        <th width="5%">ID</th>
                        <th width="15%" >广告标题</th>
                        <th width="15%" >广告位置</th>
                        <th width="10%">广告原价</th>
                        <th width="10%">广告现价</th>
                        <th width="18%" >跳转链接</th>
                        <th width="7%" >图片</th>
                        <th width="10%" >操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{$value->advId }}"></td>
                                <td>{{$value ->advId}} </td>
                                <td style="WORD-WRAP: break-word" >{{$value ->title}} </td>
                                <td style="WORD-WRAP: break-word" > @if(isset($position[$value->position])){{$position[$value->position]}} @endif</td>
                                <td style="WORD-WRAP: break-word" >{{$value ->originalPrice}}</td>
                                <td style="WORD-WRAP: break-word" >{{$value ->presentPrice}}</td>
                                <td style="WORD-WRAP: break-word" >{{$value ->link}} </td>
                                <td style="WORD-WRAP: break-word" ><img src="/superman/image/get/{{$value->imageId}}"  style="width: 50px; height: 50px;" /> </td>
                                <td style="WORD-WRAP: break-word" >@if(in_array('edit', $buttonrole))<a href="/superman/juadvertisement/edit/{{$value->advId}}" class="btn btn-success btn-xs" >修改</a>@endif
                                    @if(in_array('del', $buttonrole))<a href="/superman/juadvertisement/delone/{{$value->advId}}" class="btn btn-danger btn-xs" >删除</a>@endif
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
            url:"/superman/infoadvertisement/del",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    setTimeout("reload()", 1200)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/juadvertisement';
    }
</script>
@stop
