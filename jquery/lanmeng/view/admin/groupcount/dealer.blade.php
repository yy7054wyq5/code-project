@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>经销商信息报表</h4>
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
                        <form action="/superman/groupcount/dealer" method="get">
                        <div class="dataTables_filter" id="datatable1_filter">
                            <label>
                                <input type="text" name="account" aria-controls="datatable1" placeholder="经销商账号" class="form-control input-sm" value="{{ Input::get('account') }}">
                            </label>
                            <label>
                                <input type="text" name="email" aria-controls="datatable1" placeholder="邮箱" class="form-control input-sm" value="{{ Input::get('email') }}">
                            </label>
                            <label>
                                <input type="text" name="phone" aria-controls="datatable1" placeholder="电话" class="form-control input-sm" value="{{ Input::get('phone') }}">
                            </label>
                            <label>
                                <input type="text" name="company" aria-controls="datatable1" placeholder="经销商公司名称" class="form-control input-sm" value="{{ Input::get('company') }}">
                            </label>
                            <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                        </div>
                        </form>
                    </div>
                    &nbsp;&nbsp;
                    <div class="clearfix"></div>
                </div>
            </div>
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <thead>
                    <tr role="row">
                        <th>经销商名称</th>
                        <th>所属品牌</th>
                        <th>经销商账号</th>
                        <th>电话</th>
                        <th>积分数量</th>
                        <th>VIP等级</th>
                        <th>上传案例数</th>
                        <th>上传素材数</th>
                        <th>供求平台发布数</th>
                        <th>订单数</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if($lists)
                    @foreach($lists as $value)
                    <tr>
                        <td><a href="/superman/user/auth/{{ $value['uid'] }}?type=group">{{ $value['company'] }}</a></td>
                        <td>{{ $value['bname'] }}</td>
                        <td>{{ $value['username'] }}</td>
                        <td>{{ $value['phone'] ? $value['phone'] : '---' }}</td>
                        <td>{{ $value['integral'] }}</td>
                        <td>{{ $value['level'] }}</td>
                        <td>{{ $value['case'] }}</td>
                        <td>{{ $value['material'] }}</td>
                        <td>{{ $value['trading'] }}</td>
                        <td><a href="/superman/order/speciallist/{{ $value['uid'] }}">{{ $value['order'] }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <?php echo $page ?>
        </div>
    </div>
</div>
{!!HTML::script('super/laydate/laydate.js') !!}
@stop