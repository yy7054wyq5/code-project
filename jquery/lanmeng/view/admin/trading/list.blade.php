@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>供求信息</h4>
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
                        <form action="/superman/trading/list" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <label>
                                <select style="width: 120px;" class="form-control input-sm" name="type">
                                    <option value="">请选择交易类型</option>
                                    <option @if(Input::get('type') == 1) selected @endif value="1">出售</option>
                                    <option @if(Input::get('type') === '0') selected @endif value="0">求购</option>
                                </select>
                            </label>
                            <label>
                                <select style="width: 120px;" class="form-control input-sm" name="status">
                                    <option value="">请选择状态</option>
                                    <option @if(Input::get('status') === '0') selected @endif value="0">进行中</option>
                                    <option @if(Input::get('status') == 1) selected @endif value="1">已结束</option>
                                </select>
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    @if(in_array('add', $buttonrole))
                    <a href="/superman/trading/create" class="btn btn-sm btn-info">新增供求信息</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('edit', $buttonrole))
                    <a href="/superman/trading/hotcity" class="btn btn-sm btn-success">热门城市</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('edit', $buttonrole))
                    <a href="/superman/trading/hotcar" class="btn btn-sm btn-success">热门车型</a>
                    @endif
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-info" onclick="exports('/superman/trading/exlists')">导出Excel</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" style="TABLE-LAYOUT: fixed"   cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th width="3%" ><input type="checkbox" class="checkall"></th>
                        <th width="5%" >帖子名称</th>
                        <th width="5%" >交易类型</th>
                        <th width="5%" >所属会员</th>
                        <th width="5%" >所属品牌</th>
                        <th width="5%" >所属车型</th>
                        <th width="5%" >价格</th>
                        <th width="5%" >总数</th>
                        <th width="5%" >帖子状态</th>
                        <th width="5%" >发帖时间</th>
                        <th width="5%" >修改时间</th>
                        <th width="5%" >修改人</th>
                        <th width="5%" >操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td style="WORD-WRAP: break-word" ><input type="checkbox" name="check[]" value="{{ $value->id }}"></td>
                        <td style="WORD-WRAP: break-word" >{{ $value->title }}</td>
                        <td style="WORD-WRAP: break-word" >@if($value->type == 0) 求购 @else 出售 @endif</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->username }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->brand }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->cartype }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->price }}</td>
                        <td style="WORD-WRAP: break-word" >{{ $value->num }}</td>
                        <td style="WORD-WRAP: break-word" >@if($value->status == 0) 进行中 @else 已结束 @endif</td>
                        <td style="WORD-WRAP: break-word" >@if($value->created) {{ date('Y-m-d H:i', $value->created) }} @else ---- @endif </td>
                        <td style="WORD-WRAP: break-word" >@if($value->updated != '0000-00-00 00:00:00'){{ $value->updated }} @else ---- @endif </td>
                        <td style="WORD-WRAP: break-word" >{{ $value->modify }}</td>
                        <td style="WORD-WRAP: break-word" >@if(in_array('edit', $buttonrole))<a class="btn btn-success btn-xs" href="/superman/trading/edit/{{ $value->id }}">修改</a>@else --- @endif</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="14">暂无数据</td>
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
function delCheckItems() {
    var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    layer.confirm('您确定要删除选中的内容么？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/superman/trading/dellist", { group: temp,  _token : $("#token").val() } );
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