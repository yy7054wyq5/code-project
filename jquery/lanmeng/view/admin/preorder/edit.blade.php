{!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
{!!HTML::script('webuploader/dist/webuploader.js') !!}
{!!HTML::style("webuploader/dist/webuploader.css") !!}

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
                    <h4><i class="fa fa-table"></i>编辑预定商品分类</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <form class="form-horizontal" id="form" onsubmit="return false;" >
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">常规信息</a></li>
                    {{--<li id="adv" ><a href="#ios" data-toggle="tab">广告位</a></li>--}}
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="home">
                        <div class="box-body">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <input type="hidden" name="categoryId"  value="{{ $category->id }}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"> 关联支付方式</label>
                                    <div class="col-sm-4">
                                        <select name="payMethod" class="form-control"  >
                                            <option value="1" @if($category->payMethod == 1) selected="selected" @endif>蓝深-展厅家具</option>
                                            <option value="2" @if($category->payMethod == 2) selected="selected" @endif>旅游产品-悠迪</option>
                                            <option value="3" @if($category->payMethod == 3) selected="selected" @endif>其他的产品-祎策</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">分类名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="name" value="{{$category->name}}"    class="form-control"   />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">排序</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="sort" value="{{$category->sort}}"  class="form-control"   />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必须为数字</font></p>
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
                    </div>
                    <div class="tab-pane fade" id="ios">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button onclick="return store()" class="btn btn-primary">保存</button>
                                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@stop
{!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
{!!HTML::script('webuploader/dist/webuploader.js') !!}
{!!HTML::style("webuploader/dist/webuploader.css") !!}


<script type="text/javascript">

    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/preorder/edit",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (msg.status == 0 && !msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/preorder/category';
    }
</script>