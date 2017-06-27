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
                    <h4><i class="fa fa-table"></i>新增帮助文章</h4>
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
                            <label class="col-sm-2 control-label">分类名称</label>
                            <div class="col-sm-4">
                                <select id="select-type"  class="form-control" >
                                    @foreach($typeList as $item)
                                        <option value="{{$item->typeId}}" >{{$item->typeName}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="typeId"      class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">文章标题</label>
                            <div class="col-sm-4">
                                <input type="text" name="articleTitle"  placeholder="请输入文章标题"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">显示顺序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort"  placeholder="请输入显示顺序"  class="form-control" />
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必须为数字</font></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">内容</label>
                            <div class="col-sm-4">
                                <textarea type="text" name="articleContent"  id="container"  style="width: 800px; height: 500px;  "></textarea>
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
{!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
{!!HTML::script('common/ueditor/ueditor.config.js') !!}
{!!HTML::script('common/ueditor/ueditor.all.js') !!}
{!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js') !!}

<script type="text/javascript" >

    var ue = UE.getEditor('container');
    $(function(){
        //类别名称
        $("input[name='typeId']").val($("#select-type").val());
        $("#select-type").change(function(){
            $("input[name='typeId']").val($(this).val());
        });
    });

   /* $(document).on('blur', 'input[name="sort"]', function () {
        $.ajax({
            type: "POST",
            url:"/superman/helpcenter/sortrepeat",
            data:{sort:$(this).val()},
            dataType: 'json',
            success: function(msg) {
                if(msg['status'] == 0){
                    layer.msg(msg['tips']);
                }
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    });*/

    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/helpcenter/add",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    if(!msg['status']){
                        setTimeout("reload()", 1200);
                    }
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/helpcenter/index';
    }
</script>
