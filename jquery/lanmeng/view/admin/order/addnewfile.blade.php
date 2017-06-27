@extends('admin.base')
@section('content')
<link rel="stylesheet" type="text/css" href="/uploadify/uploadify.css">
<script type="text/javascript" src="/uploadify/jquery.uploadify-3.1.min.js"></script>
<style type="text/css">
    .uploadify .uploadify-button{
        border: 0;
        padding: 0;
    }
    .uploadify:hover .uploadify-button{
        background-color: #4b739a;
    }
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>素材文件添加</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">素材名称</label>
                <div class="col-sm-4">
                    <input type="hidden" name="ordersn" value="{{ $ordersn }}">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="text" name="info[name]" placeholder="请输入素材名称" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">素材文件</label>
                <div class="col-sm-4">
                    <tr>
                        <td colspan="4" class="upload_btn_box file">
                            <a id="upload_file_btn"></a>
                            <input type="hidden" name="info[fileId]" id="fileID">
                            <p class="filename"></p>
                        </td>
                    </tr>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">支持RAR\ZIP\PDF\DOC\XLS格式文件，单个文件不超过4G；如上传多个附件，请压缩成一个附件上传，单个文件不超过4G</font></p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="submit" onclick="return store();" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function store()
{
    $.ajax({
        type: "POST",
        url:"/superman/order/upload",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips']);
            if (msg['status'] == 0) {
                setTimeout("reload()", 1000)
            }
        },
        error: function(error){
            layer.msg("操作失败");
        }
    });
}

function reload(url)
{
    window.location.href = '/superman/order/creativefiles/{{ $ordersn }}';
}

$("#upload_file_btn").uploadify({
    'width' : '85',
    'height' : '32',
    'buttonText'    : '选择文件',
    'swf'           : '/uploadify/uploadify.swf',
    'uploader'      : '/files/upload',
    'auto'          : true,
    'multi'         : false, 
    'buttonClass' : 'btn btn-primary',
    'removeCompleted':true,
    'cancelImg'     : '/uploadify/uploadify-cancel.png',
    'fileTypeExts'  : '*.rar;*.zip;*.pdf;*.doc;*.docx;*.xls;*.xlsx;',
    'fileSizeLimit' : '4096MB',
    'onUploadSuccess':function(file,res,response){
        //console.log(file);//文件属性
        var data = JSON.parse(res);
        if(data.tips===undefined){
            data.tips = '上传失败,data.tips返回为'+data.tips;
        }
        else{
            $('#fileID').val(data.content.fileId);
        }
      //  $('.filename').html(file.name+'<span class=\"red-font\">'+data.tips+'</span>');
        $('.filename').html(data.content.filename+'<span class=\"red-font\">'+data.tips+'</span>');
    },
    //加上此句会重写onSelectError方法【需要重写的事件】
    'overrideEvents': ['onSelectError', 'onDialogClose'],
    //返回一个错误，选择文件的时候触发
    'onSelectError':function(file, errorCode, errorMsg){
        switch(errorCode) {
            case -110:
                littleTips("文件 ["+file.name+"] 大小超出系统限制的" + jQuery('#upload_file_btn').uploadify('settings', 'fileSizeLimit') + "大小！");
                break;
            case -120:
                littleTips("文件 ["+file.name+"] 大小异常！");
                break;
            case -130:
                littleTips("文件 ["+file.name+"] 类型不正确！");
                break;
        }
    }
});
</script>
@stop