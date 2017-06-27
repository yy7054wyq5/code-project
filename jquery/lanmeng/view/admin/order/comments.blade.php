@extends('admin.base')
@section('content')
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
        .editor-class { width: 800px;}
        .specimage1{
            position: relative;
            overflow: hidden;
            background: #00B7EE;
            border-color: #00B7EE;
            color: #fff;
        }
        .t1{
            position: absolute;
            top: 0;
            left: 0;
            font-size: 20px;
            opacity: 0;
        }
        .t2{
            margin: 5px 0;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <!-- BOX -->
            <div class="box border primary">
                <div class="box-title">
                    <h4><i class="fa fa-table"></i>修改商品信息</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" id="form" onsubmit="return false;" >
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id"  value="{{$lists->id}}" />
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">订单编号</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="cid" readonly="false"  class="form-control"  value="{{$lists->cid}}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">评论内容</label>
                                    <div class="col-sm-4">
                                        <textarea type="text" name="comment"  cols="20" rows="5" class="form-control" >{{$lists->comment}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">回复</label>
                                    <div class="col-sm-4">
                                        <textarea type="text" name="reply" cols="20" rows="5"   class="form-control" >@if(isset($reply->content)){{$reply->content}} @endif </textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <button onclick="store()" class="btn btn-primary">保存</button>
                                        <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
{!!HTML::script('js/jquery-1.11.2.min.js') !!}
{!!HTML::script('super/webuploader/webuploader.js') !!}
{!!HTML::style("super/webuploader/webuploader.css") !!}
{!!HTML::script('common/ueditor/ueditor.config.js')!!}
{!!HTML::script('common/ueditor/ueditor.all.min.js')!!}
{!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js')!!}
{!!HTML::script('super/laydate/laydate.js') !!}


<script type="text/javascript">

    function store()
    {
        $('input[name="batchCode"]').attr("disabled",false);
        $.ajax({
            type: "POST",
            url:"/superman/order/reply",
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
        window.location.href = '/superman/order/ordercomment/'+{{ $lists->cid }};
    }
</script>
