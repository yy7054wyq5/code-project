@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center;}
        .name{width: 30%;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>创意设计分类</h4>
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
                                    @if(in_array('add', $buttonrole))&nbsp;&nbsp;<a href="/superman/materialcategory/add" class="btn btn-sm btn-primary"  >新增</a>@endif
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th>系统ID</th>
                        <th>分类名称</th>
                        <th>上级分类</th>
                        <th>分类顺序</th>
                          <th>操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(count($lists)>0)
                        @foreach($lists as $key => $value)
                            <tr>
                                <td>{{$value->categoryId}}</td>
                                <td>{{$value->categoryName}}</td>
                                <td>——</td>
                                <td>{{$value->sort}}</td>
                                <td>@if(in_array('edit', $buttonrole))<a href="/superman/mall/edit/{{$value->categoryId}}" class="btn btn-success btn-xs">修改</a>@endif
                                    @if(in_array('del', $buttonrole))<a href="/superman/mall/del/{{$value->categoryId}}" class="btn btn-danger btn-xs">删除</a>@endif</td>
                            </tr>

                        @if (count($value->sub)>0)
                            @foreach((array)$value->sub as $v)
                                <tr>
                                    <td>{{$v->categoryId}}</td>
                                    <td>{{$v->categoryName}}</td>
                                    <td>{{$v->parentName}}</td>
                                    <td>{{$v->sort}}</td>
                                    <td>@if(in_array('edit', $buttonrole))<a href="/superman/materialcategory/edit/{{$v->categoryId}}" class="btn btn-success btn-xs">修改</a>@endif
                                       @if(in_array('del', $buttonrole)) <a href="/superman/materialcategory/del/{{$v->categoryId}}" class="btn btn-danger btn-xs">删除</a>@endif</td>
                                </tr>
                            @endforeach
                        @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">暂无数据</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <?php //echo $page ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    </script>
@stop