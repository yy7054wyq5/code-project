@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
.name{width: 30%;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>产品管理</h4>
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
                    <form action="/superman/gather/list" method="get">
                    <div class="pull-left">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                    </div>
                    </form>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    @if(in_array('add', $buttonrole))
                    <a href="/superman/gather/creategoods" class="btn btn-sm btn-info">新增</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('edit', $buttonrole))
                    <button class="btn btn-sm btn-primary" onclick="changeStatus(1);">上架</button>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="changeStatus(0);">下架</button>
                    @endif
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-info" onclick="exports('/superman/gather/exlists')">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="3%"><input type="checkbox" class="checkall"></th>
                        <th width="10%">产品ID</th>
                        <th width="10%">原始ID</th>
                        <th width="10%">商品编号</th>
                        <th width="10%">排序编号</th>
                        <th width="10%">商品名称</th>
                        <th width="10%">所属类别</th>
                        <th width="10%">所属品牌</th>
                        <th width="8%">状态</th>
                        <th width="10%">团购状态</th>
                        <th width="10%">修改人</th>
                        <th width="10%">修改时间</th>
                        <th width="13%">操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(isset($lists[0]))
                    @foreach($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->id }}"></td>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->oldId }}</td>
                        <td>{{ $value->code }}</td>
                        <td>{{ $value->sort }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->category }}</td>
                        <td>{{ $value->brand }}</td>
                        <td>{{ $value->status == 0 ? "下架" : "上架" }}</td>
                        <td>
                            @if($value->state == 0)未开始@elseif($value->state == 1)
                                <select  name="state"   data-id="{{$value->id}}"  >
                                    <option value="1" {{$value->state == 1 ? "selected":"" }} >正在进行</option>
                                    <option value="2" {{$value->state == 2 ? "selected":"" }} >已结束</option>
                                </select>
                            @else已结束@endif
                        </td>
                        <td>{{ $value->modify ? $value->modify : '---' }}</td>
                        <td>{{ $value->updated }}</td>
                        <td>@if(in_array('edit', $buttonrole))<a class="btn btn-primary btn-xs" href="/superman/gather/edit/{{ $value->id }}">修改</a>&nbsp;<a class="btn btn-success btn-xs" href="/superman/mall/package?type=2&typeId={{ $value->id }}">延展套餐</a>@else --- @endif</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="12">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
<script type="text/javascript">
    $(function(){
        $("select[name='state']").change(function(){
            var commodityId = $(this).data('id');
            $.ajax({
                type: "POST",
                url:"/superman/gather/updatestate",
                data:{'commodityId':commodityId, 'toState': $(this).val()},
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg['tips']);
                    if (!msg['url']) {
                        setTimeout("reload()", 1000)
                    };
                },
                error: function(error){
                    layer.msg("操作失败")
                }
            });
        });
    });

function delCheckItems() {
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要删除选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/gather/dellist", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}

function reload()
{
    window.location.reload();
}

function changeStatus(status)
{
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    var word = status == 1 ? "上架" : "下架";
    $.post("/superman/gather/changestatus", { status: status, group : temp, _token : $("#token").val() } );
    layer.msg(word+'成功,1s后本页将自动刷新');
    setTimeout("reload()", 1000);
}
</script>
@stop