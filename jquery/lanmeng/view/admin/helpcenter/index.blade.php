@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;text-align: center;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>帮助文章</h4>
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
                            <form action="/superman/helpcenter/index" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入关键词" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="clearfix">
                            @if(in_array('add', $buttonrole))&nbsp;&nbsp;<a href="/superman/helpcenter/add" class="btn btn-sm btn-primary"  >新增</a>@endif
                        </div>
                    </div>
                </div>
                <table id="datatable1" style="TABLE-LAYOUT: fixed" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="10%" >文章编号</th>
                        <th width="30%" >文章标题</th>
                        <th width="30%" >文章类型</th>
                        <th width="15%" >排序</th>
                        <th width="15%" >操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if ($lists)
                        @foreach ($lists as $value)
                            <tr>
                                <td style="WORD-WRAP: break-word" >{{ $value->articleId}}</td>
                                <td style="WORD-WRAP: break-word" >{{ $value->articleTitle }}</td>
                                <td style="WORD-WRAP: break-word" >{{ $value->typeName }}</td>
                                <td style="WORD-WRAP: break-word" >{{ $value->sort}}</td>
                                <td style="WORD-WRAP: break-word" >@if(in_array('edit', $buttonrole))<a href="/superman/helpcenter/edit/{{$value->articleId}}" class="btn btn-success btn-xs"  >修改</a>@endif
                                   @if(in_array('del', $buttonrole)) <a href="/superman/helpcenter/del/{{$value->articleId}}" class="btn btn-danger btn-xs"  >删除</a>@endif</td>
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
                                <?php echo $pager ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop