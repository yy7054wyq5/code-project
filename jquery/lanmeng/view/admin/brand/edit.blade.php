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
                    <h4><i class="fa fa-table"></i>修改品牌</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" id="form" onsubmit="return false;" >
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="brandId"  value="{{ $lists->brandId }}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">品牌名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="brandName" value="{{$lists->brandName}}"  class="form-control" />
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">首字母</label>
                            <div class="col-sm-4">
                                <input type="text" name="ucfirst" value="{{$lists->ucfirst}}"  class="form-control"   />
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*为空自动获取品牌名称首字母</font></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort" value="{{$lists->sort}}"  class="form-control"   />
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small form-control-static"><font color="red">*必须为数字</font></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">品牌描述</label>
                            <div class="col-sm-4">
                                <areatext name="brandDesc"   class="form-control"   >{{$lists->brandDesc}}</areatext>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-4">
                                <input type="radio" name="type" @if($lists->type == 1) checked @endif   value="1" /> 普通
                                <input type="radio" name="type" @if($lists->type == 0) checked @endif  value="0"  /> 热门
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-4">
                                <input type="radio" name="status"  @if($lists->status == 1) checked @endif  value="1" /> 下架
                                <input type="radio" name="status" @if($lists->status == 0) checked @endif   value="0"  /> 上架
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">品牌LOGO</label>
                            <div class="col-sm-4">
                                <div id="uploader-demo">
                                    <!--用来存放item-->
                                    <div id="filePicker">选择图片</div>
                                    <input type="hidden" name="imageId"  id="imageId" />
                                    <div id="fileList" class="uploader-list">
                                        @if(array_get($lists, 'imageId'))
                                            <div class="file-item upload-state-done"><img width="150" height="200" src="/superman/image/get/{{array_get($lists, 'imageId')}}"></div>
                                        @endif
                                    </div>
                                </div>
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
@stop
{!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
{!!HTML::script('webuploader/dist/webuploader.js') !!}
{!!HTML::style("webuploader/dist/webuploader.css") !!}


<script type="text/javascript">

        $(function(){
            // 初始化Web Uploader
            process(WebUploader.create({
                displayId:'fileList',
                setid:'#imageId',
                auto: true, // 选完文件后，是否自动上传。
                swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
                server: '/superman/image/upload',   // 文件接收服务端。
                pick: '#filePicker',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
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
                console.log(uploader);
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
                    displayObj.html( $li );
                    var thumbnailWidth = 150;
                    var thumbnailHeight = 150;
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
                            val = respone.content.imageId;
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
            // 当有文件添加进来的时候
            uploader.on( 'fileQueued', function( file ) {
                var $li = $(
                                '<div id="' + file.id + '" class="file-item">' +
                                '<img>' +
                                    //    '<div class="info">' + file.name + '</div>' +
                                '</div>'
                        ),
                        $img = $li.find('img');
                // $list为容器jQuery实例
                $("#fileList").append( $li );
                var thumbnailWidth = 150;
                var thumbnailHeight = 150;
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
                $("#fileList").after("<input type='hidden' name='image' value='"+respone.url+"'/>");
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
        })

    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/brand/edit",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    if(!msg['status']) {
                        setTimeout("reload()", 1200)
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
        location.href = '/superman/brand/index';
    }
</script>