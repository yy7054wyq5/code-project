<div class="box-body big">
    <form class="form-horizontal" role="form" onsubmit="return false;">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-sm-2 control-label">品牌</label>
            <div class="col-sm-4">
                <select name="info[brandId]" class="form-control">
                    <option value="">----请选择-----</option>
                    @if($brand)
                    @foreach($brand as $value)
                    <option @if($value->brandId == $info->brandId) selected @endif value="{{ $value->brandId }}">{{ $value->brandName }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">类别</label>
            <div class="col-sm-4">
                <select name="info[categoryId]" class="form-control col-sm-2 province">
                    <option value="">----请选择-----</option>
                    @if($type)
                    @foreach($type as $value)
                    <option @if($value->id == $info->categoryId) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必选</font></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品名称</label>
            <div class="col-sm-4">
                <input type="text" name="info[name]" value="{{ $info->name }}" class="form-control" placeholder="">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品副标题</label>
            <div class="col-sm-4">
                <input type="text" name="info[title]" value="{{ $info->title }}" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品编号</label>
            <div class="col-sm-4">
                <input type="text" name="info[code]" value="{{ $info->code }}" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">排序</label>
            <div class="col-sm-4">
                <input type="text" name="info[sort]" value="{{ $info->sort }}" class="form-control" placeholder="请输入显示排序">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static">(默认为0)</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品图标</label>
            <div class="col-sm-4">
                <input type="file" onchange="preview(this)">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">缩略图</label>
            <div class="col-sm-4" id="coverdiv">
                <div style="float:left;">
                    <img src="{{ $info->imageurl }}" style="width: 100px;height: 100px;" id="divimg" class="img">
                    <input type="hidden" class="imagevalue" id="divimgvalue" name="info[cover]" value="{{ $info->cover }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">状态</label>
            <div class="col-sm-4">
                <select name="info[status]" class="form-control col-sm-2 province">
                    <option @if($info->status == 0) selected @endif value="0">下架</option>
                    <option @if($info->status == 1) selected @endif value="1">上架</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">属性</label>
            <div class="col-sm-4">
                <input type="checkbox" @if($info->recommend == 1) checked @endif name="info[recommend]" value="1">多多推荐
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">团购开始时间</label>
            <div class="col-sm-4">
                <input type="text" value="{{ date('Y-m-d H:i:s', $info->timeStart) }}" name="info[timeStart]" placeholder="团购开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">团购结束时间</label>
            <div class="col-sm-4">
                <input type="text" value="{{ date('Y-m-d H:i:s', $info->timeEnd) }}" name="info[timeEnd]" placeholder="团购结束时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">起订量</label>
            <div class="col-sm-4">
                <input type="text" value="{{ $info->minNumber }}" name="info[minNumber]" class="form-control" placeholder="">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static">(默认为1)</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">最大订购量</label>
            <div class="col-sm-4">
                <input type="text" value="{{ $info->maxNumber }}" name="info[maxNumber]" class="form-control" placeholder="">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static">(不填写即为0，代表不限制)</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品说明</label>
            <div class="col-sm-4">
                <textarea id="container" name="info[describe]" style="width:800px;height:500px;">{{ $info->describe }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
                <button type="submit" onclick="update();" class="btn btn-primary">确认</button>
                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
function preview(file) {
    if (file.files && file.files[0]) {
        var img = document.getElementById('divimg');
        var reader = new FileReader();
        reader.onload = function(evt){
            img.src = evt.target.result;
            upload(evt.target.result);
        }
        reader.readAsDataURL(file.files[0]);
    }
}
function upload(img) {
    $.post("/superman/trading/image", { imageurl: img, _token : $("#token").val()}, function(data){
        $('#divimgvalue').val(data);
    });
}
</script>
