@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
        .editor-class { width: 800px;}
    </style>
    <div class="row">
        <div class="col-md-12">
            <!-- BOX -->
            <div class="box border primary">
                <div class="box-title">
                    <h4><i class="fa fa-table"></i>修改创意设计主题</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" id="form" onsubmit="return false;" >
                        <input type="hidden" name="categoryId"  value="{{ $lists->id }}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属主题</label>
                            <div class="col-sm-4">
                                <select name="parentId" class="form-control">
                                    <option>请选择</option>
                                    <option value="0" >一级主题</option>
                                    @if(isset($parentSubject) && !empty($parentSubject))
                                        @foreach($parentSubject as $key => $value)
                                            <option value="{{$key}}" @if($lists->parentId ==  $key) selected @endif >{{$value}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">主题名称</label>
                            <div class="col-sm-4">
                                {!!Form::text('name',$lists->name,['class'=>'form-control','placeholder'=>'请输入主题名称'])!!}
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
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
        </div>
    </div>

{!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
<script type="text/javascript" >
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/creativecategory/edit",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    if(!msg['status']){
                        setTimeout("reload()", 1100)
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
        location.href = '/superman/creativecategory/index';
    }
</script>
@stop