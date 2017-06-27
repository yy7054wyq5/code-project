@extends('admin.base')
@section('content')
    <div class="box border primary">
        <div class="box-title">
            <h4>
                <i class="fa fa-columns"></i>
                <span class="hidden-inline-mobile"> 执行案例产品审核 </span>
            </h4>
        </div>
        <div class="box-body">
            <div class="tabbable header-tabs">
                <!-- 基础信息 Begin -->
                <form class="form-horizontal" id="form" onsubmit="return false;">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="caseProductId"  value="{{ $lists->caseProductId }}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">案例名称</label>
                        <div class="col-sm-4">
                            <input type="text" name="caseName" readonly="true" value="{{$lists->caseName}}"   class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">案例审核</label>
                        <div class="col-sm-4">
                            <select name="status" class="form-control">
                                <option value="0" @if($lists->status == 0)  selected="true" @endif >未审核</option>
                                <option value="1" @if($lists->status == 1)  selected="true"  @endif >审核通过</option>
                                <option value="2" @if($lists->status == 2) selected="true" @endif  >审核未通过</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">案例赠送积分</label>
                        <div class="col-sm-4">
                            <input type="text" name="integral" value="@if($lists->integral){{$lists->integral}}@else 50 @endif" placeholder="请输入起订量" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">审核未通过原因</label>
                        <div class="col-sm-4">
                            <textarea name="reason"  class="form-control" >{{$lists->reason}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button onclick="return store();" id="button" class="btn btn-primary">保存</button>
                            <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                        </div>
                    </div>
                </form>
                <!-- 基础信息 End -->
            </div>
        </div>
    </div>
    {!!HTML::script('common/ueditor/ueditor.config.js') !!}
    {!!HTML::script('common/ueditor/ueditor.all.js') !!}
    {!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js') !!}
    {!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
    {!!HTML::script('webuploader/dist/webuploader.js') !!}
    {!!HTML::style("webuploader/dist/webuploader.css") !!}
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        $(document).ready(function(){
            $('.form-control').bind('input propertychange', function() {
                $("#button").attr("disabled", false);
            });
        })

        function store()
        {
            $("#button").attr("disabled", true);
            $.ajax({
                type: "POST",
                url:"/superman/casetypeproduct/examine",
                data:$('#form').serialize(),
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg['tips'])
                    if (msg['status'] == 0) {
                        setTimeout("reload()", 1000);
                    };
                },
                error: function(error){
                    layer.msg("网络错误，请稍候再试");
                }
            });
        }
        function reload()
        {
            location.href = '/superman/casetypeproduct/index';
        }
    </script>
@stop