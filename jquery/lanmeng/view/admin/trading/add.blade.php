@extends('admin.base')
@section('content')
{!!HTML::style('common/multiple/multi-select.css')!!}
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>新增供求信息</h4>
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
                <label class="col-sm-2 control-label">帖子类型</label>
                <div class="col-sm-4">
                    <select class="form-control" name="info[type]">
                        <option value="0">求购</option>
                        <option value="1">出售</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">标题</label>
                <div class="col-sm-4">
                    <input type="text" name="info[title]" class="form-control" placeholder="请输入标题">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">品牌选择</label>
                <div class="col-sm-4">
                    <select class="form-control" id="brand" onchange="getCar();" name="info[brand]">
                        <option value="">请选择品牌</option>
                        @if($brand)
                        @foreach($brand as $value)
                        <option value="{{ $value->brandId }}" data-id="{{ $value->brandId }}">{{ $value->brandName }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">车型选择选择</label>
                <div class="col-sm-4">
                    <div class='hero-multiselect'>
                        <select multiple id="car" name="info[car][]">
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">请选择出厂日期</label>
                <div class="col-sm-4">
                    <input type="text" name="info[factorytime]" placeholder="出厂日期" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">省市选择</label>
                <div class="col-sm-4">
                    <select class="form-control" onchange="getCity();" id="province" name="info[province]">
                        <option value="">---请选择---</option>
                        @if($province)
                        @foreach($province as $value)
                        <option value="{{ $value->id }}" data-id="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选(必填)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">地区选择</label>
                <div class="col-sm-4">
                    <select class="form-control" id="city" name="info[city]">
                        <option value="">---请选择---</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选(必填)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">详细地址</label>
                <div class="col-sm-4">
                    <input type="text" name="info[address]" placeholder="请填写详细地址" class="form-control">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选(必填)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">联系人</label>
                <div class="col-sm-4">
                    <input type="text" name="info[linkname]" placeholder="请填写联系人" class="form-control">
                </div>
                <!-- <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选(必填)</font></p>
                </div> -->
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">手机号</label>
                <div class="col-sm-4">
                    <input type="text" name="info[mobile]" class="form-control" placeholder="请输入手机号码">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-sm-2 control-label">固定电话</label>
                <div class="col-sm-4">
                    <input type="text" name="info[phone]" class="form-control" placeholder="请输入固话号码">
                </div>
            </div> -->
            <div class="form-group">
                <label class="col-sm-2 control-label">状态</label>
                <div class="col-sm-4">
                    <select class="form-control" name="info[status]">
                        <option value="0">进行中</option>
                        <option value="1">已结束</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">单价</label>
                <div class="col-sm-4">
                    <input type="text" name="info[price]" onKeyUp="javascript:checkInput(this);" onMouseDown="javascript:checkInput(this);" class="form-control" placeholder="请输入单价">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填(仅限数字)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">数量</label>
                <div class="col-sm-4">
                    <input type="text" name="info[num]" onKeyUp="javascript:checkInput(this);" onMouseDown="javascript:checkInput(this);" class="form-control" placeholder="请输入数量">
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填(仅限数字)</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">成色</label>
                <div class="col-sm-4">
                    <select class="form-control" name="info[quality]">
                        <option value="1">一成新</option>
                        <option value="2">两成新</option>
                        <option value="3">三成新</option>
                        <option value="4">四成新</option>
                        <option value="5">五成新</option>
                        <option value="6">六成新</option>
                        <option value="7">七成新</option>
                        <option value="8">八成新</option>
                        <option value="9">九成新</option>
                        <option value="10">全新</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-sm-2 control-label">上传图片</label>
                <div class="col-sm-4">
                    <input type="file" onchange='previewImage(this)'>
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必传</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">缩略图</label>
                <div class="col-sm-4" id="cover">
                </div>
            </div> -->
            <div class="form-group">
                <label class="col-sm-2 control-label">详细介绍</label>
                <div class="col-sm-4">
                    <textarea id="container" name="info[content]" style="width:800px;;height:500px;"></textarea>
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
{!!HTML::script('common/multiple/jquery.multi-select.js') !!}
<script type="text/javascript">
var $user = $('#car').multiSelect();
</script>
{!!HTML::script('common/ueditor/ueditor.config.js') !!}
{!!HTML::script('common/ueditor/ueditor.all.js') !!}
{!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js') !!}
{!!HTML::script('super/laydate/laydate.js') !!}
<script type="text/javascript">
var ue = UE.getEditor('container');
</script>
<script type="text/javascript">
var num = 1;
function store()
{
    $.ajax({
        type: "POST",
        url:"/superman/trading/store",
        data:$('#form').serialize(),
        dataType: 'json',
        success: function(msg) {
            layer.msg(msg['tips']);
            if (msg['status'] == 0) {
                setTimeout("reload('/superman/trading/list')", 1000)
            }
        },
        error: function(error){
            layer.msg("操作失败");
        }
    });
}
function reload(url)
{
    window.location.href = url;
}

function addNewImage() {
    var html = '<div style="float:left;"><img src="" style="width: 100px;height: 100px; display:none;" id="newImage'+num+'" class="img"><input type="hidden" class="imagevalue" id="Image'+num+'" name="image[]" value=""><br/><a href="javascript:void();" id="set'+num+'" onclick="setCover('+num+')">设为封面</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void();" onclick="delImg(this, '+num+')">删除</a></div>';
    $('#cover').append(html);
}

function previewImage(file) {
    addNewImage();
    if (file.files && file.files[0]) {
        var img = document.getElementById('newImage'+num);
        var reader = new FileReader();
        reader.onload = function(evt){
            img.src = evt.target.result;
            $('#newImage'+num).show();
            uploadImage(evt.target.result,num);
            num++;
        }
        reader.readAsDataURL(file.files[0]);
    }
}
function uploadImage(img,num) {
    $.post("/superman/trading/image", { imageurl: img, _token : $("#token").val()}, function(data){
        $('#Image'+num).val(data);
    });
}

function delImg(content, id) {
    if (confirm('您确定要删除此图片?')) {
        $(content).parent('div').remove();
    } else {
        return false;
    }
}

function setCover(id) {
    //$('#Image'+id).val();
    $('#cover').html($('#cover').html().replace(/封面|设为封面/ig, '设为封面'));
    $('.imagevalue').attr("name",'image[]');
    $('#set'+id).text('封面');
    $('#Image'+id).attr("name",'info[cover]');
}

/**
 * 检测输入值是否为数字
 * @return {[type]} [description]
 */
function checkInput(word) {
    if (isNaN(word.value)) {
        alert("抱歉，仅支持数字类型");
    }
}

function getCity()
{
    var pid = $("#province option:selected").attr('data-id');
    $.post("/superman/trading/city", {id: pid, _token : $("#token").val()}, function(data){
      var t = '';
      $.each(data['content'], function () {
        t += '<option value="'+ this.id +'">'+ this.name +'</option>';
      });
      $("#city").empty();
      $("#city").append(t);
    }, "json");
}

function getCar()
{
    var pid = $("#brand option:selected").attr('data-id');
    $.post("/superman/trading/car", {id: pid, _token : $("#token").val()}, function(data){
      var t = '';
      $.each(data['content'], function () {
        t += '<option value="'+ this.carmodelName +'">'+ this.carmodelName +'</option>';
      });
      $user.html(t).multiSelect('refresh');
    }, "json");
}
</script>
@stop