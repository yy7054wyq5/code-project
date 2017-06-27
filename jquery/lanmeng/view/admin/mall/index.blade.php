@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 14px;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>商品分类</h4>
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
                            <form action="/superman/mall/index" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                            @if(in_array('add', $buttonrole))&nbsp;&nbsp;<a href="/superman/mall/add" class="btn btn-sm btn-primary"  >新增</a>@endif
                        </div>
                    </div>
                </div>
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th>分类名称</th>
                        <th>显示顺序</th>
                        <th>价格区间</th>
                        <th>支付方式</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if ($lists && count($lists)>0)
                        @foreach ($lists as $value)
                            <tr>
                                <td style="text-align: left;" >{{ $value['name'] }}</td>
                                <td>{{ $value['sort'] }}</td>
                                <td>{{ $value['rangePrice'] }}</td>
                                @if($value['payMethod'] == 1)
                                    <td>蓝深-展厅家具</td>
                                @elseif($value['payMethod'] == 2)
                                    <td>旅游产品-悠迪</td>
                                @else
                                    <td>其他的产品-祎策</td>
                                @endif
                                <td>@if(in_array('edit', $buttonrole))<a href="/superman/mall/editcategory/{{ $value['id'] }}" class="btn btn-success btn-xs">修改</a>@endif
                                    @if(in_array('del', $buttonrole))<a href="/superman/mall/delcategory/{{ $value['id'] }}" class="btn btn-danger btn-xs">删除</a>@endif</td>

                            </tr>
                            @if (count($value['subs'])>0)
                                @foreach($value['subs'] as $k=>$v)
                                    <tr>
                                        <td style="text-align: left;" >@if($k+1 == count($value['subs'])) {{ '&nbsp;&nbsp;&nbsp;└─ ' .$v['name'] }} @else {{ '&nbsp;&nbsp;&nbsp;├─ ' .$v['name'] }} @endif</td>
                                        <td>{{ $v['sort'] }}</td>
                                        <td>空</td>
                                        @if($value['payMethod'] == 1)
                                            <td>蓝深-展厅家具</td>
                                        @elseif($value['payMethod'] == 2)
                                            <td>旅游产品-悠迪</td>
                                        @else
                                            <td>其他的产品-祎策</td>
                                        @endif
                                        <td>@if(in_array('edit', $buttonrole))<a href="/superman/mall/editcategory/{{ $v['id'] }}" class="btn btn-success btn-xs">修改</a>@endif
                                            @if(in_array('del', $buttonrole))<a href="/superman/mall/delcategory/{{ $v['id'] }}" class="btn btn-danger btn-xs">删除</a>@endif</td>
                                    </tr>
                                @endforeach
                            @endif
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
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
{!!HTML::script('js/jquery-1.11.2.min.js') !!}
<script type="text/javascript">
    $(function(){
        //全选
        $('.J_checkall').click(function(){
            var J_checkall = $(this).attr('checked');
            $('.J_checkitem').each(function(){
                if(J_checkall == 'checked'){
                    $(this).attr('checked',true);
                }else{
                    $(this).attr('checked',false);
                }
            });
        });
    });
</script>