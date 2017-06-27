@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center; font-size: 13px;}
        .name{width: 30%;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>执行案例产品</h4>
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
                        <form action="/superman/casetypeproduct/index" method="get">
                            <div class="pull-left">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>案例名称:</label>
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1"  class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <label>品牌:</label>
                                    <label>
                                        <select  name="brandId"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @foreach($brandList as $key => $item)
                                                <option value="{{$key}}" >{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label>分类:</label>
                                    <label>
                                        <select  name="categoryId"   class="form-control input-sm" >
                                            <option value="0" checked="true" >请选择</option>
                                            @foreach($casetype as $key => $item)
                                                <option value="{{$key}}" >{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </label>

                                    <label>状态:</label>
                                    <label>
                                        <select  name="status"   class="form-control input-sm" >
                                            <option value="-1" checked="true" >请选择</option>
                                            <option value="0" >未审核</option>
                                            <option value="1" >审核通过</option>
                                            <option value="2" >审核未通过</option>
                                        </select>
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary">
                                    &nbsp;&nbsp;
                                </div>
                            </div>
                        </form>
                        @if(in_array('del', $buttonrole))
                        <button class="btn btn-sm btn-danger" onclick="delCheckItems();">删除</button>
                        @endif
                        &nbsp;&nbsp;
                        <button class="btn btn-sm btn-info" onclick="exports('/superman/casetypeproduct/exlists')">导出Excel</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <table  style="TABLE-LAYOUT: fixed" id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable dataTable " aria-describedby="datatable1_info">
                        <thead>
                        <tr role="row">
                            <th width="3%"><input type="checkbox" class="checkall"></th>
                            <th width="8%">案例ID</th>
                            <th width="10%" >案例名称</th>
                            <th width="7%" >类别</th>
                            <th width="10%">所属会员</th>
                          <!--  <th width="7%">品牌</th>  -->
                            <th width="7%">附件</th>
                            <th width="10%" >相片总数</th>
                            <th width="7%">积分</th>
                            <th width="8%">浏览量</th>
                            <th width="8%">推荐量</th>
                            <th width="12%">状态</th>
                            <th width="10%">修改时间</th>
                            <th width="8%">修改人</th>
                            <th width="12%">操作</th>
                        </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if(count($lists)>0)
                            @foreach($lists as $key => $value)
                                <tr>
                                    <td align="center"><input type="checkbox" name="check[]" value="{{ $value->caseProductId}}"></td>
                                    <td style="WORD-WRAP: break-word" >{{$value->caseProductId}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->caseName}}</td>
                                    <td style="WORD-WRAP: break-word" > @if(isset($casetype[$value->caseTypeId])) {{$casetype[$value->caseTypeId] }} @else "——" @endif </td>
                                    <td style="WORD-WRAP: break-word">{{$value->username}}</td>
                                   <!-- <td style="WORD-WRAP: break-word">{{--$value->brandName--}}</td> -->
                                    <td style="WORD-WRAP: break-word" >{{$value->enclosure}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->photoTotal}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->integral}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->point}}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->recommendCount}}</td>
                                    <td style="WORD-WRAP: break-word" >@if($value->status == 0)未审核
                                        @elseif($value->status == 1)审核通过
                                        @elseif($value->status == 2)审核未通过
                                        @endif
                                    </td>
                                    <td style="WORD-WRAP: break-word">{!! $value->created ? date('Y-m-d H:i:s',$value->created):'——'!!}</td>
                                    <td style="WORD-WRAP: break-word" >{{$value->updateUser}}</td>
                                    <td>
                                        @if(in_array('edit', $buttonrole))<a href="/superman/casetypeproduct/edit/{{$value->caseProductId}}" class="btn btn-success btn-xs" >修改</a>@else --- @endif
                                        <a href="/superman/casetypeproduct/examine/{{$value->caseProductId}}" class="btn btn-danger btn-xs" >审核</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="13">暂无数据</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <div class="dataTables_paginate paging_bs_full" id="datatable1_paginate">
                                {!!$pager!!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    </script>

{!!HTML::script('uploadify/jquery-1.7.2.min.js') !!}
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
        $.post("/superman/casetypeproduct/dellists", { group: temp,  _token : $("#token").val() } );
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