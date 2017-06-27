@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;text-align: center;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>帮助分类</h4>
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
                        </div>
                        <div class="clearfix">
                        </div>
                    </div>
                </div>
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th>系统ID</th>
                        <th>分类名</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if ($lists)
                        @foreach ($lists as $value)
                            <tr>
                                <td width="10%">{{ $value->typeId }}</td>
                                <td width="80%">{{ $value->typeName }}</td>
                                <td width="15%">@if(in_array('edit', $buttonrole))<a href="/superman/helptype/edit/{{$value->typeId}}" class="btn btn-success btn-xs"  >修改</a>@endif</td>
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