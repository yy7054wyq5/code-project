@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>管理员列表</h4>
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
                        <form action="/superman/account/list" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入用户名称" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    @if(in_array('add', $buttonrole))
                    <a href="/superman/account/create" class="btn btn-sm btn-info">新增</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" style="TABLE-LAYOUT: fixed" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="5%" ><input type="checkbox" class="checkall"></th>
                        <th width="10%" >用户ID</th>
                        <th width="10%" >用户名称</th>
                        <th width="10%" >姓名</th>
                        <th width="15%" >Email</th>
                        <th width="10%" >Tel</th>
                        <th width="10%" >所属角色</th>
                        <th width="15%" >添加时间</th>
                        <th width="10%" >修改</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->uid }}"></td>
                        <td style="WORD-WRAP: break-word" >{{ $value->uid }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->username }}</td>
                        <td style="WORD-WRAP: break-word" >@if($value->usergroup == \App\Model\User::$groupLogistics && $value->realname) {{ Config::get('logistics')[$value->realname] }} @else {{ $value->realname }} @endif</td>
                        <td style="WORD-WRAP: break-word" >@if($value->email){{ $value->email }} @else ————@endif </td>
                        <td style="WORD-WRAP: break-word" >@if($value->mobile){{ $value->mobile }} @else ————@endif </td>
                        <td style="WORD-WRAP: break-word" >{{ $value->groupname }}</td>
                        <td style="WORD-WRAP: break-word" >{{ date('Y-m-d H:i', $value->created) }}</td>
                        <td style="WORD-WRAP: break-word" >
                            @if(in_array('edit', $buttonrole))<a class="btn btn-success btn-xs" href="/superman/account/edit/{{ $value->uid }}">修改</a>@else --- @endif</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="9">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
<script type="text/javascript">
function delCheckItems() {
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要删除选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/account/dellist", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setInterval("reload()", 1000);
    });
}

function reload()
{
    window.location.reload();
}
</script>
@stop