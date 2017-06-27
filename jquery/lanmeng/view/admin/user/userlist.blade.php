@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>用户列表</h4>
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
                        <form action="/superman/account/user" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入用户名称" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <label>
                                <input type="text" name="company" aria-controls="datatable1" placeholder="请输入公司名称" class="form-control input-sm" value="<?php echo isset($_GET['company']) ? $_GET['company'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    @if(in_array('add', $buttonrole))
                    <a href="/superman/account/createuser" class="btn btn-sm btn-info">新增</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(\Illuminate\Support\Facades\Session::get('user.adminusergroup') == 39)
                        <a href="/superman/account/add-relation" class="btn btn-sm btn-info">新增关联</a>
                        &nbsp;&nbsp;
                    @endif
                    @if(in_array('edit', $buttonrole))
                    <!-- <a href="/superman/account/syncuser" class="btn btn-sm btn-info">用户同步</a> -->
                    @endif
                    @if(in_array('edit', $buttonrole))
                    <!-- <a href="javascript:;" onclick="activationUser();" class="btn btn-sm btn-info">用户激活</a> -->
                    @endif
                    <button class="btn btn-sm btn-info" onclick="window.location.href = '/superman/account/exportexceluser'">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1"  style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="3%" ><input type="checkbox" class="checkall"></th>
                        <th width="7%" >用户ID</th>
                        <th width="8%" >用户名称</th>
                        <th width="8%" >公司名称</th>
                        <th width="7%" >联系人</th>
                        <th width="8%" >Email</th>
                        <th width="10%" >Tel</th>
                        <th width="10%" >积分</th>
                        <th width="8%" >所属角色</th>
                        <th width="10%" >添加时间</th>
                        @if($isGroup == \App\Model\User::$groupGroup)
                        <th width="7%">状态</th>
                        @endif
                        <th width="26%" >操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value->uid }}"></td>
                        <td style="WORD-WRAP: break-word" >{{ $value->uid }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->username }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->company }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->realname }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->email }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->mobile }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->integral }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->groupname}}</td>
                        <td style="WORD-WRAP: break-word" >{{ date('Y-m-d H:i', $value->ucreated) }}</td>
                        @if($isGroup == \App\Model\User::$groupGroup)
                        <td style="WORD-WRAP: break-word" >{{\App\Model\UserInfo::$relationArr[$value->relationStatus]}}</td>
                        @endif
                        <td style="WORD-WRAP: break-word" >
                            @if(in_array('edit', $buttonrole))<a class="btn btn-success btn-xs" href="/superman/account/edituser/{{ $value->uid }}">修改</a>&nbsp;<a class="btn btn-info btn-xs" href="/superman/user/auth/{{ $value->uid }}">更多资料</a>@else --- @endif
                            @if(in_array('examine', $buttonrole))
                                @if($value->relationType ==2)
                                    @if($value->relationStatus == \App\Model\UserInfo::$NotVerificationAdmin)
                                       <a class="btn  btn-xs btn-primary " href="/superman/account/to-examine/{{ $value->uid }}">同意</a>
                                       &nbsp;<a class="btn btn-danger btn-xs" href="/superman/account/to-reject/{{ $value->uid }}">驳回</a>
                                    @endif
                                @endif
                                    @if(\Illuminate\Support\Facades\Session::get('user.adminusergroup') == \App\Model\User::$groupGroup  && $value->relationStatus == \App\Model\UserInfo::$RelationSuccess)
                                    @if(in_array('nobind', $buttonrole))
                                    <a class="btn  btn-xs btn-primary " href="/superman/account/relieve-relation/{{ $value->uid }}">解除绑定</a>
                                    @endif
                                    @endif </td>
                            @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan=" @if($isGroup == \App\Model\User::$groupGroup) 12 @else 11 @endif">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-left" style="margin-top: 10px;">
                        @if(in_array('del', $buttonrole))
                            <button class="btn btn-primary" onclick="delCheckItems();">批量删除</button>
                        @endif
                    </div>
                    <div class="pull-right">
                        <?php echo $page ?>
                    </div>
                </div>
            </div>
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
        $.post("/superman/account/delnormaluser", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}
function reload()
{
    window.location.reload();
}
function activationUser()
{
    $.post("/bbs/activation.php", {_token : $("#token").val() } );
    layer.msg("激活操作成功,1s后本页将自动刷新");
    setTimeout("reload()", 1000);
}
</script>
@stop