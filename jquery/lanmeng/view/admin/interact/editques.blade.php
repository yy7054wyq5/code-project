@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>互动调研修改</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">主题名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="ques[qid]" value="{{ $info->qid }}">
                    <input type="text" name="ques[title]" value="{{ $info->title }}" placeholder="请输入主题名称" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">背景介绍</label>
                <div class="col-sm-4">
                    <textarea id="container" name="ques[content]" style="width:800px;height:500px;">{{ $info->content }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示在总首页</label>
                <div class="col-sm-4">
                    <input type="checkbox" name="ques[home]" @if($info->home == 1) checked @endif value="1"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示顺序</label>
                <div class="col-sm-4">
                    <input type="text" name="ques[sort]" value="{{ $info->sort }}" placeholder="请输入顺序编号" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*仅限数字</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">有效时间</label>
                <div class="col-sm-3">
                    <input type="text" name="ques[begintime]" value="{{ date('Y-m-d H:i', $info->begintime) }}" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                </div>
                <div class="col-sm-3">
                    <input type="text" name="ques[endtime]" value="{{ date('Y-m-d H:i', $info->endtime) }}" placeholder="结束时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                </div>
                <div class="col-sm-2">
                    <p class="text-muted small form-control-static"><font color="red">*(必填)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">是否显示</label>
                <div class="col-sm-4">
                    <input name="ques[status]" @if($info->status == 0) checked @endif type="radio" value="0" />显示
                    <input name="ques[status]"  @if($info->status == 1) checked @endif type="radio" value="1" />隐藏
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button onclick="return update()" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
{!!HTML::script('common/ueditor/ueditor.config.js') !!}
{!!HTML::script('common/ueditor/ueditor.all.js') !!}
{!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
<script type="text/javascript">
var ue = UE.getEditor('container');
</script>
<script type="text/javascript">
function update()
{
    $.ajax({
        type: "POST",
        url:"/superman/interact/updateques",
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
function reload()
{
    location.href = '/superman/interact/survey';
}
</script>
@stop