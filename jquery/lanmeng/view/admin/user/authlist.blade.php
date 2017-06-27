@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>认证管理</h4>
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
                        <form action="/superman/account/authlist" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <label>
                                <select class="form-control input-sm" name="status">
                                    <option value="">请选择审核状态</option>
                                    <option value="0" @if(Input::get('status') === '0') selected @endif>等待审核</option>
                                    <option value="1" @if(Input::get('status') == 1) selected @endif>审核通过</option>
                                    <option value="2" @if(Input::get('status') == 2) selected @endif>审核未通过</option>
                                </select>
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    @if(in_array('del', $buttonrole))
                    &nbsp;&nbsp;
                    <!-- <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button> -->
                    @endif
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-info" onclick="exports('/superman/account/exauth')">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" style="TABLE-LAYOUT: fixed" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="5%" ><input type="checkbox" class="checkall"></th>
                        <th width="10%" >用户ID</th>
                        <th width="10%" >会员名</th>
                        <th width="10%" >所属品牌</th>
                        <th width="10%" >经销商名称</th>
                        <th width="10%" >状态</th>
                        <th width="15%" >客户申请时间</th>
                        <th width="15%" >审核时间</th>
                        <th width="15%" >操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td style="WORD-WRAP: break-word" ><input type="checkbox" name="check[]" value="{{ $value->uid }}"></td>
                        <td style="WORD-WRAP: break-word" >{{ $value->uid }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->username }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->userinfo->brand }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->userinfo->company }}</td>
                        <td style="WORD-WRAP: break-word" >@if($value->userinfo->status == 0) 等待审核 @elseif($value->userinfo->status == 1) 审核通过 @elseif($value->userinfo->status == 2) 审核未通过 @else 填写资料 @endif</td>
                        <td style="WORD-WRAP: break-word" >{{date('Y-m-d H:i:s',$value['userinfo']['created'])}}</td>
                        <td style="WORD-WRAP: break-word" >@if($value['auditTime']){{date('Y-m-d H:i:s',$value['auditTime'])}} @else ---- @endif</td>
                        <td style="WORD-WRAP: break-word" >@if(in_array('edit', $buttonrole))<a class="btn btn-success btn-xs" href="/superman/account/changeauthstatus?uid={{ $value->uid }}&type=1">通过</a>&nbsp;<a class="btn btn-danger btn-xs" href="javascript:;" onclick="cancelAuth({{ $value->uid }})">驳回</a>@endif @if(in_array('show', $buttonrole)) &nbsp;<a class="btn btn-primary btn-xs" href="/superman/account/showauthinfo/{{ $value->uid }}">查看</a> @endif</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page; ?>
        </div>
    </div>
</div>
{!!HTML::script('common/checkall.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
{!!HTML::script('js/admin/export.js') !!}
<script type="text/javascript">
$(document).ready(function() {
    layer.config({
        extend: 'extend/layer.ext.js'
    });
}); 
function cancelAuth(id) {
    layer.prompt({title: '请输入驳回理由', formType: 2}, function(text){
        $.post("/superman/account/changeauthstatus?uid="+id+"&type=2&desc="+text, {_token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}

function reload()
{
    window.location.reload();
}
</script>
@stop