@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>活动新增</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body big">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-sm-2 control-label">模板选择</label>
                <div class="col-sm-4">
                    <select class="form-control" name="info[templetid]">
                        <option value="1">2L16</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">活动名称</label>
                <div class="col-sm-4">
                    <input type="text" name="info[name]" class="form-control" placeholder="请输入标题">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">活动背景图</label>
                <div class="col-sm-4">
                    <input type="file" onchange='previewImage(this)'>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必传(上传图片不能超过{{ get_cfg_var('upload_max_filesize') }})</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">缩略图</label>
                <div class="col-sm-4" id="cover">
                    <img src="" style="width: 100px;height: 100px;" id="newImage" class="img"><input type="hidden" class="imagevalue" id="Image" name="info[back]" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">头部广告</label>
                <div class="col-sm-4" id="cover">
                    <div>
                        <input type="text" name="info[top][]" placeholder="请输入第一个链接" class="form-control" /><br/>
                    </div>
                    <div>
                        <input type="text" name="info[top][]" placeholder="请输入第二个链接" class="form-control" /><br/>
                    </div>
                    <div>
                        <input type="text" name="info[top][]" placeholder="请输入第三个链接" class="form-control" /><br/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">分类管理</label>
                <div class="col-sm-4" id="option">
                    <div>
                        <input type="text" name="info[option][]" placeholder="请输入分类" class="form-control" /><br/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <a href="javascript:void(0);" onclick="add();">增加分类</a>
                    <a href="javascript:void(0);" onclick="del();">减少分类</a>
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
        url:"/superman/activity/storeact",
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

function reload()
{
    window.location.href = '/superman/activity/list';
}

function previewImage(file) {
    if (file.files[0]['size'] / 1024 / 1024 > {{ (int)get_cfg_var('upload_max_filesize') }}) {
        layer.msg("上传图片最大不能超过系统限制{{ get_cfg_var('upload_max_filesize') }}");
        return false;
    }
    if (file.files && file.files[0]) {
        var img = document.getElementById('newImage');
        var reader = new FileReader();
        reader.onload = function(evt){
            img.src = evt.target.result;
            uploadImage(evt.target.result);
        }
        reader.readAsDataURL(file.files[0]);
    }
}
function uploadImage(img) {
    var url = $.ajax({type : "post", url:"/superman/trading/image", data:{imageurl: img, _token : $("#token").val()}, async:false}).responseText;
    url = eval('('+url+')');
    $('#Image').val(url);
}

function add() {
    var html = '<div><input type="text" name="info[option][]" placeholder="请输入分类" class="form-control" /><br/></div>';
    $('#option').append(html)
}
function del() {
    if ($('#option').children().length - 1 === 0) {
        return false;
    };
    $("#option div:last").remove();
}
</script>
@stop