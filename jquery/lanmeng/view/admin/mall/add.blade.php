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
                    <h4><i class="fa fa-table"></i>新增商品分类</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" id="form" onsubmit="return false;" >
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属一级分类</label>
                            <div class="col-sm-4">
                                <select name="parentId" id="parentId" class="form-control"  >
                                    <option value="0">根目录</option>
                                    @foreach($category as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="name"  class="form-control"   />
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort"  class="form-control"/>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必须为数字</font></p>
                            </div>
                        </div>

                        <div class="level1" style="display: block">
                        <div class="form-group">
                            <label for="" class="control-label col-sm-2 required">价格区间设置</label>
                            <div class="col-sm-6">
                                <div class="itinerary form-inline periodprice">
                                    <a href="javascript:;" class="btn btn-primary add periodprice"><i class="fa fa-plus-circle"></i> 添加</a>
                                    <div class="item periodprice">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="rangeStart[]" class="form-control" placeholder="起始价(包含)">
                                            <div class="input-group-addon">至</div>
                                            <input type="text" name="rangeEnd[]" class="form-control" placeholder="截止价(包含)">
                                            <div class="input-group-addon" onclick="javascript:$(this.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                            </div>
                        </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 关联支付方式</label>
                                <div class="col-sm-4">
                                    <select name="payMethod" class="form-control"  >
                                        <option value="1">蓝深-展厅家具</option>
                                        <option value="2">旅游产品-悠迪</option>
                                        <option value="3">其他的产品-祎策</option>
                                    </select>
                                </div>
                            </div>
                        <div class="form-group specadd">
                            <label for="" class="control-label col-sm-2 required">广告链接</label>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                            </div>
                        </div>
                        <div class="form-group spec" data-index="1">
                            <label for="" class="control-label col-sm-2 required"></label>

                            <div class="col-sm-6">
                                <div class="input-group">
                                    <div class="input-group-addon">链接</div>
                                    <input type="text" class="form-control" name="link[]">

                                    <div class="input-group-addon specimage1">链接单图
                                        <div class="t1" id="pickimage1">选择单图</div>
                                    </div>
                                    <input type="hidden" id="adimage1" name="adimage[]">
                                </div>
                                <div id="adimageList1" class="t2"></div>
                            </div>
                        </div>

                      <!--  <div class="form-group spec" data-index="2">
                            <label for="" class="control-label col-sm-2 required"></label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <div class="input-group-addon">链接</div>
                                    <input type="text" class="form-control" name="link[]">
                                    <div class="input-group-addon specimage1">链接单图
                                        <div class="t1" id="pickimage2">选择单图</div>
                                    </div>
                                    <input type="hidden" id="adimage2" name="adimage[]">
                                    {{--<div class="input-group-addon" onclick="javascript:$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>--}}
                                </div>
                                <div id="adimageList2" class="t2"></div>
                            </div>
                        </div> -->

                    <!--    <div class="form-group spec" data-index="3">
                            <label for="" class="control-label col-sm-2 required"></label>

                            <div class="col-sm-6">
                                <div class="input-group">
                                    <div class="input-group-addon">链接</div>
                                    <input type="text" class="form-control" name="link[]">

                                    <div class="input-group-addon specimage1">链接单图
                                        <div class="t1" id="pickimage3">选择单图</div>
                                    </div>
                                    <input type="hidden" id="adimage3" name="adimage[]">
                                    {{--<div class="input-group-addon" onclick="javascript:$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>--}}
                                </div>
                                <div id="adimageList3" class="t2"></div>
                            </div>
                        </div>  -->

                    <!--    <div class="form-group spec" data-index="4">
                            <label for="" class="control-label col-sm-2 required"></label>

                            <div class="col-sm-6">
                                <div class="input-group">
                                    <div class="input-group-addon">链接</div>
                                    <input type="text" class="form-control" name="link[]">

                                    <div class="input-group-addon specimage1">链接单图
                                        <div class="t1" id="pickimage4">选择单图</div>
                                    </div>
                                    <input type="hidden" id="adimage4" name="adimage[]">
                                    {{--<div class="input-group-addon" onclick="javascript:$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>--}}
                                </div>
                                <div id="adimageList4" class="t2"></div>
                            </div>
                        </div>
                        </div>  -->

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button onclick="return store()"  class="btn btn-primary">保存</button>
                                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
{!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
{!!HTML::script('webuploader/dist/webuploader.js') !!}
{!!HTML::style("webuploader/dist/webuploader.css") !!}


<script type="text/javascript">

    $(function(){

        $(document).on('click', '.itinerary .add.periodprice', function () {
            var html = '<div class="item periodprice">' +
                    '<div class="input-group input-group-sm">' +
                    '<input type="text" name="rangeStart[]" class="form-control" placeholder="起始量(包含)">' +
                    '<div class="input-group-addon">至</div>' +
                    '<input type="text" name="rangeEnd[]" class="form-control" placeholder="截止量(包含)">' +
                    '<div class="input-group-addon" onclick="javascript:$(this.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>' +
                    '</div>' +
                    ' </div>';
            $('.itinerary.periodprice').append(html);
        });

        $(document).on('change', '#parentId', function () {
            if ($(this).val() > 0) {
                $('.level1').hide();
            } else {
                $('.level1').show();
            }
        });

        process(WebUploader.create({
            displayId:'adimageList1',
            setid:'#adimage1',
            fileNumLimit : 1,
            auto: true, // 选完文件后，是否自动上传。
            swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
            server: '/superman/image/upload',   // 文件接收服务端。
            pick: '#pickimage1',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
            formData: {'_token': '<?php echo  csrf_token() ?>' },
            accept: {// 只允许选择图片文件。
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        }));

        process(WebUploader.create({
            displayId:'adimageList2',
            setid:'#adimage2',
            fileNumLimit : 1,
            auto: true, // 选完文件后，是否自动上传。
            swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
            server: '/superman/image/upload',   // 文件接收服务端。
            pick: '#pickimage2',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
            formData: {'_token': '<?php echo  csrf_token() ?>' },
            accept: {// 只允许选择图片文件。
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        }));

        process(WebUploader.create({
            displayId:'adimageList3',
            setid:'#adimage3',
            fileNumLimit : 1,
            auto: true, // 选完文件后，是否自动上传。
            swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
            server: '/superman/image/upload',   // 文件接收服务端。
            pick: '#pickimage3',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
            formData: {'_token': '<?php echo  csrf_token() ?>' },
            accept: {// 只允许选择图片文件。
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        }));

        process(WebUploader.create({
            displayId:'adimageList4',
            setid:'#adimage4',
            fileNumLimit : 1,
            auto: true, // 选完文件后，是否自动上传。
            swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
            server: '/superman/image/upload',   // 文件接收服务端。
            pick: '#pickimage4',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
            formData: {'_token': '<?php echo  csrf_token() ?>' },
            accept: {// 只允许选择图片文件。
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        }));
        // 当有文件添加进来的时候
        function process(uploader)
        {
            var displayId = uploader.options.displayId;
            var setId = uploader.options.setid;
            var fileNumLimit = uploader.options.fileNumLimit;
            var displayObj = $('#'+ displayId);
            var setObj = $(setId);
            uploader.on( 'fileQueued', function( file ) {
                var $li = $(
                                '<div id="' + file.id + '" class="file-item">' +
                                '<img>' +
                                    //    '<div class="info">' + file.name + '</div>' +
                                '</div>'
                        ),
                        $img = $li.find('img');
                // $list为容器jQuery实例
                if (fileNumLimit == 1) {
                    displayObj.html( $li );
                } else {
                    displayObj.append( $li );
                }
                var thumbnailWidth = 150;
                var thumbnailHeight = 200;
                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr( 'src', src );
                }, thumbnailWidth, thumbnailHeight );
            });


            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
                        $percent = $li.find('.progress span');

                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<p class="progress"><span></span></p>')
                            .appendTo( $li )
                            .find('span');
                }

                $percent.css( 'width', percentage * 100 + '%' );
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file,respone ) {
                if (fileNumLimit == 1) {
                    setObj.val(respone.content.imageId);
                } else {
                    var val = setObj.val();
                    if  (val) {
                        val += ',' +respone.content.imageId;
                    } else {
                        val = respone.content.imageId;
                    }
                    setObj.val(val)
                }
//               displayObj.after("<input type='hidden' name='image' value='"+respone.url+"'/>");
                $( '#'+file.id ).addClass('upload-state-done');
            });

            // 文件上传失败，显示上传出错。
            uploader.on( 'uploadError', function( file ) {
                var $li = $( '#'+file.id ),
                        $error = $li.find('div.error');

                // 避免重复创建
                if ( !$error.length ) {
                    $error = $('<div class="error"></div>').appendTo( $li );
                }
                $error.text('上传失败');
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).find('.progress').remove();
            });
        }

    });

    /*$(document).on('blur', 'input[name="sort"]', function () {
        $.ajax({
            type: "POST",
            url:"/superman/helpcenter/sortrepeat",
            data:{sort:$(this).val()},
            dataType: 'json',
            success: function(msg) {
                if(msg['status'] == 0){
                    $('.btn').attr('disabled',true);
                    layer.msg(msg['tips']);
                }else{
                    $('.btn').attr('disabled',false);
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
            url:"/superman/mall/addcategory",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips']);
                if (msg.status == 0 && !msg['url']) {
                    setTimeout("reload()", 1000);
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/mall/index';
    }
</script>