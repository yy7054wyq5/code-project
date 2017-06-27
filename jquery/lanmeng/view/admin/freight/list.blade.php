@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>运费模板列表</h4>
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
                        <form action="/superman/freight/list" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="javascript:window.location.reload();">刷新</button>
                    &nbsp;&nbsp;
                    @if(in_array('add', $buttonrole))
                    <a class="btn btn-sm btn-primary" href="/superman/freight/add">新增</a>
                    @endif
                    &nbsp;&nbsp;
                    @if(in_array('del', $buttonrole))
                    <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th><input type="checkbox" class="checkall"></th>
                        <th>模板名称</th>
                        <th>计价方式</th>
                        <th>起计量</th>
                        <th>累加量</th>
                        <th>快递方式</th>
                        <th>包含城市</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if (isset($lists[0]))
                    @foreach ($lists as $value)
                    <tr>
                        <td><input type="checkbox" name="check[]" value="{{ $value['id'] }}"></td>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ $value['type'] }}</td>
                        <td>{{ $value['startnum'].'('.$value['unit'].')' }}</td>
                        <td>{{ $value['accnum'].'('.$value['unit'].')' }}</td>
                        <td>{{ $value['express'] }}</td>
                        <td>{{ $value['city'] }}<button onclick="showCity({{ $value['id'] }})" class="btn btn-xs btn-info">more</button></td>
                        <td><a class="btn btn-xs btn-primary" href="/superman/freight/edit/{{ $value['id'] }}">修改</a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php //echo $page ?>
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
        $.post("/superman/freight/delmulti", { group: temp,  _token : $("#token").val() } );
        layer.msg('操作成功,1s后本页将自动刷新');
        setTimeout("reload()", 1000);
    });
}

function reload()
{
    window.location.reload();
}

function showCity(id)
{
    $.post("/superman/freight/allcity", {id: id, _token : $("#token").val()}, function(data){
        var table = '<table class="table table-striped table-hover table-bordered">';
        $.each(data['content'], function (index, val) {
            table += "<tr><td class='name'>"+val.name+"</td><td>";
            $.each(val.sub, function (i, v) {
                table += v.name+"&nbsp;";
            });
            table += "</td></tr>";
        });
        table += "</table>";
        layer.open({
            type: 1,
            title: "配送范围",
            skin: 'layui-layer-rim', //加上边框
            area: ['700px', '320px'], //宽高
            content: table
        });
    }, "json");
}
</script>
@stop