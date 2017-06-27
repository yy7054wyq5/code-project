@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>专题内容添加</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">调研题目</label>
                <div class="col-sm-4">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="bbs[qid]" value="{{ $id }}">
                    <input type="text" name="bbs[title]" placeholder="请输入调研题目" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">题目类型</label>
                <div class="col-sm-4">
                    <input type="radio" name="bbs[type]" value="0" />单选
                    <input type="radio" name="bbs[type]" value="1" />多选
                    <input type="radio" name="bbs[type]" value="2" />问答
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示顺序</label>
                <div class="col-sm-4">
                    <input type="text" name="bbs[sort]" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">是否显示</label>
                <div class="col-sm-4">
                    <input type="radio" name="bbs[status]" value="0" />显示
                    <input type="radio" name="bbs[status]" value="1" />隐藏
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">选项</label>
                <div class="col-sm-4" id="option">
                    <div>
                        <input type="text" name="bbs[option][]" placeholder="请输入选项" class="form-control" /><br/>
                    </div>
                    <div>
                        <input type="text" name="bbs[option][]" placeholder="请输入选项" class="form-control" /><br/>
                    </div>
                    <div>
                        <input type="text" name="bbs[option][]" placeholder="请输入选项" class="form-control" /><br/>
                    </div>
                    <div>
                        <input type="text" name="bbs[option][]" placeholder="请输入选项" class="form-control" /><br/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <a href="javascript:void(0);" onclick="add();">增加题目</a>
                    <a href="javascript:void(0);" onclick="del();">减少题目</a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button onclick="return store()" class="btn btn-primary">保存</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function store() {
    $.ajax({
        type: "POST",
        url:"/superman/interact/storespecial",
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
function reload() {
    location.href = '/superman/interact/special/{{ $id }}';
}

function add() {
    var html = '<div><input type="text" name="bbs[option][]" placeholder="请输入选项" class="form-control" /><br/></div>';
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