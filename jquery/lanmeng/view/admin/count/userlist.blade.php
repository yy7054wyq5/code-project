@extends('admin.base')
@section('content')
<style type="text/css">
    th,td {text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>会员信息</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table id="datatable1"  style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>经销商名称</th>
                        <th>账号</th>
                        <th>所属品牌</th>
                        <th>积分</th>
                        <th>签到次数</th>
                        <th>消费详情</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    @foreach($lists as $value)
                    <tr>
                        <td>{{ $value['company'] }}</td>
                        <td>{{ $value['username'] }}</td>
                        <td>{{ $value['brand'] }}</td>
                        <td>{{ $value['integral'] }}</td>
                        <td>{{ $value['num'] }}</td>
                        <td><a class="btn btn-primary btn-xs" href="/superman/order/speciallist/{{ $value['uid'] }}?type=normal">查看</a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-right">
                        <?php echo $page ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop