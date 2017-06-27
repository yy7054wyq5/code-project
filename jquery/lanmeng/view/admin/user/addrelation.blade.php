@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{text-align: center;}
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4><i class="fa fa-table"></i>邦定经销商</h4>
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
                            <form action="/superman/account/add-relation" method="get">
                                <div class="dataTables_filter" id="datatable1_filter">
                                    <label>
                                        <input type="text" name="keyword" aria-controls="datatable1" placeholder="请输入经销商名称" class="form-control input-sm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>">
                                    </label>
                                    <input type="submit" value="搜索" class="btn btn-sm btn-primary" />
                                    &nbsp;&nbsp;
                                    <a href="/superman/account/user"  class="btn btn-sm btn-primary" >返回</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table id="datatable1" style="TABLE-LAYOUT: fixed" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                    <thead>
                    <tr role="row">
                        <th width="5%" ><input type="checkbox" class="checkall"></th>
                        <th width="20%" >用户ID</th>
                        <th width="35%" >经销商名称</th>
                        <th width="30%" >公司名称</th>
                        <th width="15%" >操作</th>
                    </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if(count($lists)>0)
                            @foreach($lists as $key => $value)
                            <tr>
                                <td style="WORD-WRAP: break-word" ><input type="checkbox" name="check[]" value="{{$value->uid}}"></td>
                                <td style="WORD-WRAP: break-word" >{{$value->uid}}</td>
                                <td style="WORD-WRAP: break-word" >{{$value->username}}</td>
                                <td style="WORD-WRAP: break-word" >{{$value->realname}}</td>
                                <td style="WORD-WRAP: break-word" ><a class="btn  btn-xs btn-primary " href="/superman/account/admin-to-relation/{{ $value->uid }}">绑定</a></td>
                            </tr>
                            @endforeach
                         @else
                            <tr>
                                <td colspan="5">暂无数据</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left" style="margin-top: 10px;">
                            @if(in_array('del', $buttonrole))
                                <button class="btn btn-primary" onclick="delCheckItems();">批量删除</button>
                            @endif
                        </div>
                        <div class="pull-right">
                            <?php echo $page ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!!HTML::script('common/checkall.js') !!}
    <script type="text/javascript">
        $(document).ready(function() {
            layer.config({
                extend: 'extend/layer.ext.js'
            });
        });
        function cancelAuth(id) {
            layer.prompt({title: '请输入驳回理由', formType: 2}, function(text){
                $.post("/superman/account/changeauthstatus?uid="+id+"&type=2&desc="+text, {_token : $("#token").val() } );
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