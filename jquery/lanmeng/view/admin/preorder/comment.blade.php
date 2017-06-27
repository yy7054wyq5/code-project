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
                    <div class="clearfix">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-sm btn-info" onclick="exports('/superman/preorder/excomment')">导出Excel</button>
                    </div>
                </div>
            </div>
            <form class="form-horizontal" onsubmit="return false;" id="form">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <table id="datatable1" style="TABLE-LAYOUT: fixed"   cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="3%"  ><input type="checkbox"  class="J_checkall"></th>
                        <th width="7%"  >系统ID</th>
                        <th width="7%"  >所属产品</th>
                        <th width="10%"  >发表会员</th>
                        <th width="20%"  >评论内容</th>
                        <th width="5%"  >置顶</th>
                        <th width="10%"  >审核</th>
                        <th width="10%"  >修改时间</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (count($comments)>0)
                        @foreach ($comments as $comment)
                            <tr>
                                <td align="center"><input type="checkbox" name="id[]" class="J_checkitem" value="{{ $comment['id'] }}"></td>
                                <td style="WORD-WRAP: break-word" >{{$comment['id']}} </td>
                                <td style="WORD-WRAP: break-word" >{{$comment['commodityInfo']['name']}} </td>
                                <td style="WORD-WRAP: break-word" >{{$comment['userInfo']['username']}} </td>
                                <td style="WORD-WRAP: break-word" >{{$comment['comment']}} </td>
                                <td style="WORD-WRAP: break-word" ><select name="top"   data-id="{{$comment['id']}}"   >
                                        <option value="0" {{$comment['top'] == 0 ? "selected":"" }} >否</option>
                                        <option value="1" {{$comment['top'] == 1 ? "selected":"" }}  >是</option>
                                    </select>
                                </td>
                                <td style="WORD-WRAP: break-word" ><select  name="status"   data-id="{{$comment['id']}}"  >
                                        <option value="0" {{$comment['status'] == 0 ? "selected":"" }} >未审核</option>
                                        <option value="1" {{$comment['status'] == 1 ? "selected":"" }} >审核未通过</option>
                                        <option value="2" {{$comment['status'] == 2 ? "selected":"" }} >审核通过</option>
                                    </select>
                                </td>
                                <td style="WORD-WRAP: break-word" >{{ $comment['updated'] }}</td>
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
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
        <?php echo $page?>
    </div>
    </div>
@stop
{!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
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
//                        setTimeout("reload()", 1000)
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
        location.href = '/superman/preorder/comment';
    }
</script>