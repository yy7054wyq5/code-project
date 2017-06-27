@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
    </style>
    <div class="row">
        <div class="col-md-12">
            <!-- BOX -->
            <div class="box border primary">
                <div class="box-title">
                    <h4><i class="fa fa-table"></i>新增公告</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <form class="form-horizontal" onsubmit="return false;" id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-4">
                                <input type="text" name="title"  placeholder="请输入标题"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">推荐</label>
                            <div class="col-sm-4">
                                <input type="radio" name="recommend"  value="1" /> 推荐
                                <input type="radio" name="recommend" checked="checked"  value="0"  /> 不推荐
                            </div>
                           <!-- <div class="col-sm-4">
                                <font color="#dc143c" >注：推荐到商城左上角</font>
                            </div> -->
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-4">
                                <input type="radio" name="show" checked="checked"  value="1" /> 显示
                                <input type="radio" name="show"  value="0"  /> 隐藏
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">内容</label>
                            <div class="col-sm-4">
                                <textarea type="text" id="container"  name="content"   style="width: 800px; height: 500px;  "></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button onclick="return store()" class="btn btn-primary">保存</button>
                                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

{!!HTML::script('common/ueditor/ueditor.config.js')!!}
{!!HTML::script('common/ueditor/ueditor.all.min.js')!!}
{!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js')!!}

<script type="text/javascript" >
    var ue = UE.getEditor('container');
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/notice/add",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/notice/index';
    }
</script>
