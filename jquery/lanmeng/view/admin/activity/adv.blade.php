@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>活动广告管理</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body big">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="info[id]" value="{{ $id }}">
            @if ($type)
            @foreach ($type as $key => $value)
            <h3>分类：{{ $value->name }}</h3>
            @for($i = 1; $i <= 10; $i++)
            <h5>第{{ $i }}个广告位</h5>
            <hr>
            <div>
            <div class="form-group">
                <label class="col-sm-2 control-label">广告标题</label>
                <div class="col-sm-4">
                    <input type="text" name="info[{{$key+1}}][{{$i}}][title]" class="form-control" value="{{ isset($lists[$key+1][$i]['title']) ? $lists[$key+1][$i]['title'] : '' }}" placeholder="请输入广告标题">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">广告原价</label>
                <div class="col-sm-4">
                    <input type="text" name="info[{{$key+1}}][{{$i}}][oldprice]" class="form-control" value="{{ isset($lists[$key+1][$i]['oldprice']) ? $lists[$key+1][$i]['oldprice'] : '' }}" placeholder="请输入广告原价">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">广告现价</label>
                <div class="col-sm-4">
                    <input type="text" name="info[{{$key+1}}][{{$i}}][price]" class="form-control" value="{{ isset($lists[$key+1][$i]['price']) ? $lists[$key+1][$i]['price'] : '' }}" placeholder="请输入广告现价">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">广告链接</label>
                <div class="col-sm-4">
                    <input type="text" value="{{ isset($lists[$key+1][$i]['url']) ? $lists[$key+1][$i]['url'] : '' }}" name="info[{{$key+1}}][{{$i}}][url]" class="form-control" placeholder="亲输入广告链接">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">广告图片</label>
                <div class="col-sm-4">
                    <input type="file" onchange='previewImage(this, "{{$key+1}}{{$i}}")'>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必传(上传图片不能超过{{ get_cfg_var('upload_max_filesize') }})</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">缩略图</label>
                <div class="col-sm-4" id="cover">
                    <img src="{{ isset($lists[$key+1][$i]['imageurl']) ? $lists[$key+1][$i]['imageurl'] : '' }}" style="width: 170px;height: 130px;" id="newImage{{$key+1}}{{$i}}" class="img"><input type="hidden" class="imagevalue" id="Image{{$key+1}}{{$i}}" name="info[{{$key+1}}][{{$i}}][icon]" value="{{ isset($lists[$key+1][$i]['icon']) ? $lists[$key+1][$i]['icon'] : '' }}">
                </div>
            </div>
            </div>
            @endfor
            @endforeach
            @endif
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
        url:"/superman/activity/storeadv",
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
    window.location.href = '/superman/activity/list';
}

function previewImage(file, num) {
    if (file.files[0]['size'] / 1024 / 1024 > {{ (int)get_cfg_var('upload_max_filesize') }}) {
        layer.msg("上传图片最大不能超过系统限制{{ get_cfg_var('upload_max_filesize') }}");
        return false;
    }
    if (file.files && file.files[0]) {
        var img = document.getElementById('newImage'+num);
        var reader = new FileReader();
        reader.onload = function(evt){
            img.src = evt.target.result;
            uploadImage(evt.target.result, num);
        }
        reader.readAsDataURL(file.files[0]);
    }
}
function uploadImage(img, num) {
    var url = $.ajax({type : "post", url:"/superman/trading/image", data:{imageurl: img, _token : $("#token").val()}, async:false}).responseText;
    url = eval('('+url+')');
    $('#Image'+num).val(url);
}
</script>
@stop