@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center;}
        .name{width: 30%;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>创意设计主题</h4>
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
                            <div class="dataTables_filter" id="datatable1_filter">
                              @if(in_array('add', $buttonrole))<a href="/superman/creativecategory/add" style="margin-bottom: 10px; margin-left: 20px;" class="btn btn-sm btn-info">新增</a>@endif
                            </div>
                        </div>
                    </div>
                </div>
                <table id="datatable1" style="TABLE-LAYOUT: fixed"  cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="10%" >系统ID</th>
                        <th width="40%" >主题名称</th>
                        <th width="20%" >修改时间</th>
                        <th width="20%" >修改用户</th>
                        <th width="10%" >操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(count($lists)>0)
                    @foreach($lists as $key => $value)
                       <tr>
                           <td style="WORD-WRAP: break-word" >{{$value->categoryId}}</td>
                           <td style="text-align: left; WORD-WRAP: break-word; "  >{{$value->name}}</td>
                           <td style="WORD-WRAP: break-word" >{{$value->created}}</td>
                           <td style="WORD-WRAP: break-word" >{{$value->username}}</td>
                           <td style="WORD-WRAP: break-word" >
                              @if(in_array('edit', $buttonrole))<a href="/superman/creativecategory/edit/{{$value->categoryId}}" class="btn btn-success btn-xs" >修改</a>@else --- @endif
                                  @if(in_array('edit', $buttonrole))<a href="/superman/creativecategory/del/{{$value->categoryId}}" class="btn btn-danger  btn-xs" >删除</a>@else --- @endif
                           </td>
                       </tr>
                           @if(isset($value->sub) && count($value->sub)>0)
                               @foreach($value->sub as $subValue)
                               <tr>
                                   <td style="WORD-WRAP: break-word" >{{$subValue->categoryId}}</td>
                                   <td style="text-align: left; WORD-WRAP: break-word;" >{{$subValue->name}}</td>
                                   <td style="WORD-WRAP: break-word" >{{$subValue->created}}</td>
                                   <td style="WORD-WRAP: break-word" >{{$subValue->username}}</td>
                                   <td style="WORD-WRAP: break-word" >
                                       @if(in_array('edit', $buttonrole))<a href="/superman/creativecategory/edit/{{$subValue->categoryId}}" class="btn btn-success btn-xs" >修改</a>@else --- @endif
                                           @if(in_array('edit', $buttonrole))<a href="/superman/creativecategory/del/{{$subValue->categoryId}}" class="btn btn-danger btn-xs" >删除</a>@else --- @endif
                                   </td>
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
                {!!  $pager !!}
            </div>
        </div>
    </div>
    <script type="text/javascript">
    </script>
@stop