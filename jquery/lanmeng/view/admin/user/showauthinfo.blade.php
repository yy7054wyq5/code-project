@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>认证资料</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body big">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">认证类型</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" placeholder="{{ $group }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">品牌</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" placeholder="{{ $brand ? $brand : "暂未选择品牌" }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">公司名称</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" placeholder="{{ $info->company ? $info->company : "暂未输入公司名称" }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">公司所在地</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" placeholder="{{ $info->cityname }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">税务登记号</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" placeholder="{{ $info->taxnum ? $info->taxnum : "暂未输入税务登记号" }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">开户行</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" placeholder="{{ $info->bank ? $info->bank : "暂未选择开户银行" }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">开户账号</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" placeholder="{{ $info->account ? $info->account : "暂未输入开户账户" }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">证书图片</label>
                <div class="col-sm-8">
                    <div style="float:left;"><img src="{{ $ctax }}" style="width: 100px;height: 100px;" class="img"><br/><button class="btn btn-xs btn-primary" onclick="showImage('{{ $ctax }}')">税务登记</button></div>
                    <div style="float:left;"><img src="{{ $clicense }}" style="width: 100px;height: 100px;" class="img"><br/><button class="btn btn-xs btn-primary" onclick="showImage('{{ $clicense }}')">营业执照</button></div>
                    <div style="float:left;"><img src="{{ $ocode }}" style="width: 100px;height: 100px;" class="img"><br/><button class="btn btn-xs btn-primary" onclick="showImage('{{ $ocode }}')">组织结构</button></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <a class="btn btn-primary" href="/superman/user/auth/{{ $id }}">更多资料</a>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function showImage(url)
{
    var img = new Image();
    img.src = url;
    var width = img.width;
    var height = img.height;
    if (img.width > 1280) {
        var temp = 1280 / img.width;
        width = img.width * temp;
    }
    if (img.height > 600) {
        var temp = 600 / img.height;
        height = img.height * temp;
    }
    layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        area: [width+20+'px', height+20+'px'],
        skin: 'layui-layer-nobg', //没有背景色
        shadeClose: true,
        closeBtn: true,
        content: '<div><img src="'+url+'"></div>'
    });
}
</script>
@stop