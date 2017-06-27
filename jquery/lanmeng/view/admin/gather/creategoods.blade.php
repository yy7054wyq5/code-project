@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4>
            <i class="fa fa-columns"></i>
            <span class="hidden-inline-mobile">创建产品</span>
        </h4>
    </div>
    <div class="box-body">
        <div class="tabbable header-tabs">
            <ul class="nav nav-tabs">
                <li>
                    <a href="#box_tab5" data-toggle="tab">
                        <span class="hidden-inline-mobile">其他运费</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="#box_tab4" data-toggle="tab">
                        <span class="hidden-inline-mobile">运费选择</span>
                    </a>
                </li> -->
                <li>
                    <a href="#box_tab3" data-toggle="tab">
                        <span class="hidden-inline-mobile">积分赠送</span>
                    </a>
                </li>
                <li>
                    <a href="#box_tab2" data-toggle="tab">
                        <span class="hidden-inline-mobile">规格</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#box_tab1" data-toggle="tab">
                        <span class="hidden-inline-mobile">常规信息</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="box_tab1">
                    <!-- 常规信息 Begin -->
                    @include('admin.gather.baseinfo')
                    <!-- 常规信息 End -->
                </div>
                <div class="tab-pane fade" id="box_tab2">
                    <!-- 规格 Begin -->
                    <form class="form-horizontal" role="form" onsubmit="return false;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">规格值</label>
                            <div class="col-sm-10">
                                <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                                    <thead>
                                        <th>规格值</th>
                                        <th>原价</th>
                                        <th>促销价</th>
                                        <th>可用积分</th>
                                        <th>库存</th>
                                        <th>图片上传</th>
                                        <th>操作</th>
                                    </thead>
                                    <tbody>
                                        <tr data-id="1">
                                            <td><input type="text" name="info[specValue][1]" class="form-control"></td>
                                            <td><input type="text" name="info[sourcePrice][1]" class="form-control"></td>
                                            <td><input type="text" name="info[price][1]" class="form-control"></td>
                                            <td><input type="text" name="info[maxCredits][1]" class="form-control"></td>
                                            <td><input type="text" name="info[inventory][1]" class="form-control"></td>
                                            <td><input style="width:70px;" type="file" onchange="previewImage(this,1)"></td>
                                            <td><button class="btn btn-danger btn-xs" onclick="removebtn(this)">删除</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">相册缩略图</label>
                            <div class="col-sm-8" id="cover">
                                <div style="float:left;"><img src="" style="width: 100px;height: 100px;" id="newImage1" class="img"><input type="hidden" class="imagevalue" id="Image1" name="info[image][1]" value=""></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <a href="javascript:void(0);" onclick="add();">增加</a>
                                <a href="javascript:void(0);" onclick="del();">减少</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" onclick="return store();" class="btn btn-primary">确认</button>
                                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </form>
                    <!-- 规格 End -->
                </div>
                <div class="tab-pane fade" id="box_tab3">
                    <!-- 积分赠送 Begin -->
                    <form class="form-horizontal" role="form" onsubmit="return false;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">积分赠送</label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" placeholder="默认根据产品价格1:1赠送">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">额外赠送积分</label>
                            <div class="col-sm-4">
                                <input type="text" name="info[integral]" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" onclick="return store();" class="btn btn-primary">确认</button>
                                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </form>
                    <!-- 积分赠送 Begin -->
                </div>
                <div class="tab-pane fade" id="box_tab5">
                    <!-- 其他运费 Begin -->
                    <form class="form-horizontal" role="form" onsubmit="return false;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">邮费设置</label>
                            <div class="col-sm-7">
                                @foreach(Config::get('other.dispatch') as $key => $value)
                                <input type="radio" onclick="changeDispatch({{$key}});" name="info[dispatch]" value="{{ $key }}" />{{ $value }}&nbsp;
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group" id="volume" style="display: none;">
                            <label class="col-sm-3 control-label">请输入单件商品体积或质量</label>
                            <div class="col-sm-4">
                                <input type="text" name="info[unit_num]" class="form-control" placeholder="">
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">单位</font></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" onclick="return store();" class="btn btn-primary">确认</button>
                                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </form>
                    <!-- 其他运费 End -->
                </div>
            </div>
        </div>
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
function store(){
    $.ajax({
        type: "POST",
        url:"/superman/gather/storegoods",
        data:$('.form-horizontal').serialize(),
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
    window.location.href = '/superman/gather/list';
}
function addNewImage(num) {
    var html = '<div style="float:left;"><img src="" style="width: 100px;height: 100px;" id="newImage'+num+'" class="img"><input type="hidden" class="imagevalue" id="Image'+num+'" name="info[image]['+num+']" value=""></div>';
    $('#cover').append(html);
}

function add() {
    var num = $("tbody tr").length;
    addNewImage(num);
    var html = '<tr data-id="'+num+'">';
    html += '<td><input type="text" name="info[specValue]['+num+']" class="form-control"></td>';
    html += '<td><input type="text" name="info[sourcePrice]['+num+']" class="form-control"></td>';
    html += '<td><input type="text" name="info[price]['+num+']" class="form-control"></td>';
    html += '<td><input type="text" name="info[maxCredits]['+num+']" class="form-control"></td>';
    html += '<td><input type="text" name="info[inventory]['+num+']" class="form-control"></td>';
    html += '<td><input style="width:70px;" type="file" onchange="previewImage(this, '+num+')"></td>';
    html += '<td><button class="btn btn-danger btn-xs" onclick="removebtn(this)">删除</button></td>';
    html += '</tr>';
    $('tbody').append(html)
}
function del() {
    if ($("tbody tr").length - 1 === 0) {
        return false;
    };
    $("tbody tr:last").remove();
    $("#cover div:last").remove();
}

function changeType(data)
{
    if ($(data).val() == 1) {
        $('#gui').show();
    } else {
        $('#gui').hide();
    }
}

function previewImage(file) {
    var num = $(file).parents('tr').attr('data-id');
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
    /*$.post("/superman/trading/image", { imageurl: img, _token : $("#token").val()}, function(data){
        $('#Image'+num).val(data);
    });*/
    var url = $.ajax({type : "post", url:"/superman/trading/image", data:{imageurl: img, _token : $("#token").val()}, async:false}).responseText;
    url = eval('('+url+')');
    $('#Image'+num).val(url);
}

function removebtn(data)
{
    var num = $(data).parents('tr').index();
    $(data).parents('tr').remove();
    $("#cover").find("div").eq(num).remove();
}

function changeDispatch(id)
{
    if (id == 5 || id == 6) {
        $('#volume').show();
    } else {
        $('#volume').hide();
    }
}
</script>
@stop