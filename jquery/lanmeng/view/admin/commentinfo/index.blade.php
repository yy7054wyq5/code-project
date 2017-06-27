@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 14px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>评论管理</h4>
            <div class="tools hidden-xs">
                <a href="javascript:;" class="collapse">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <div class="row">
                        <div class="clearfix"></div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table style="TABLE-LAYOUT: fixed"  id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="5%"><input type="checkbox"  class="J_checkall"></th>
                        <th width="7%">系统ID</th>
                        <th width="13%">所属资讯</th>
                        <th width="10%">发表会员</th>
                        <th width="25%">评论内容</th>
                        <th width="5%">置顶</th>
                        <th width="10%">审核</th>
                        <th width="15%">修改时间</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $value -> id }}"></td>
                                <td>{{$value -> id}} </td>
                                <td style="WORD-WRAP: break-word" >{{$value -> infoTitle}} </td>
                                <td>{{$value -> username}} </td>
                                <td style="WORD-WRAP: break-word" >{{$value -> comment}} </td>
                                <td><select name="top"   data-id="{{$value -> id}}"   >
                                        <option value="0" @if($value ->top == 0)  selected="true" @endif >否</option>
                                        <option value="1" @if($value ->top == 1)  selected="true" @endif >是</option>
                                    </select>
                                </td>
                                <td><select  name="status"   data-id="{{$value -> id}}"  >
                                        <option value="0" {{$value-> status == 0 ? "selected":"" }} >未审核</option>
                                        <option value="1" {{$value-> status == 1 ? "selected":"" }} >审核未通过</option>
                                        <option value="2" {{$value-> status == 2 ? "selected":"" }} >审核通过</option>
                                    </select>
                                </td>
                                <td>{{ $value->updated }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left">
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">
                            @if(in_array('del', $buttonrole))&nbsp;&nbsp;<button onclick="return store()" class="btn btn-primary">批量删除</button>@endif
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
                </form>
            </div>
        </div>
    </div>
    {!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
<script type="text/javascript" >
    $(function(){
        //全选
        $(".J_checkall").change(function(){
            $('.J_checkitem').prop("checked",this.checked);
        });

        // 置顶
        $("select[name='top']").change(function(){
            var top = $(this).val();
            var id     = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url:"/superman/commentinfo/top",
                data:{'_token':'{{ csrf_token() }}','id':id,'top':top},
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

        // 审核
        $("select[name='status']").change(function(){

            var status = $(this).val();
            var id     = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url:"/superman/commentinfo/modifystatus",
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
            url:"/superman/commentinfo/del",
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
        location.href = '/superman/commentinfo/index';
    }
</script>
@stop
