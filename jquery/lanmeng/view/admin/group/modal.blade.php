@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
        .editor-class { width: 800px;}
    </style>
    <div class="row">
        <div class="col-md-12">
            <!-- BOX -->
            <div class="box border primary">
                <div class="box-title">
                    <h4><i class="fa fa-table"></i>新增品牌</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
            <form class="form-horizontal" id="form" onsubmit="return false;">
                <div class="box-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="{{$orderid}}">
                    <div class="form-group">
                        <label class="col-sm-2 ">支付方式</label>
                        <div class="col-sm-4">
                            <select name="grouppay" class="form-control">
                                <option value="0" checked="true" >请选择</option>
                                @if(count($payModelArr))
                                    @foreach($payModelArr as $key => $value)
                                    <option value="{{$key}}" @if($currectMethod == $key) selected="selected" @endif>{{$value}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary" onclick="return update()" >保存</button>
                            <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                        </div>
                    </div>
               </div>
            </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function update() {
            $.ajax({
                type: "POST",
                url:"/superman/group/pay-model",
                data:$('#form').serialize(),
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg['tips']);
                    if (msg['status'] == 0) {
                        setTimeout("reload()", 1000);
                    };
                },
                error: function(error){
                    layer.msg("操作失败");
                }
            });
        }
        function reload() {
            location.href = '/superman/group/orderpaymentlist';
        }
    </script>
@stop
