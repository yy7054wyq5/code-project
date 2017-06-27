@extends('admin.base')
@section('content')
    {!!HTML::script('uploadify/jquery-1.7.2.js')!!}
    {!!HTML::script('uploadify/jquery.uploadify-3.1.min.js')!!}
    {!!HTML::style('uploadify/uploadify.css')!!}
    <style type="text/css">
        .uploadify .uploadify-button{
            background: #00b7ee;
            border: 0;
            font-size: 12px;
            padding: 0;
        }
        .uploadify:hover .uploadify-button{
            background: #00a2d4;
        }
    </style>
    <div class="box border primary">
        <div class="box-title">
            <h4>
                <i class="fa fa-columns"></i>
                <span class="hidden-inline-mobile"> 修改执行案例产品 </span>
            </h4>
        </div>
        <div class="box-body">
            <div class="tabbable header-tabs">
                        <!-- 基础信息 Begin -->
                        <form class="form-horizontal" id="form" onsubmit="return false;">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="caseProductId"  value="{{ $lists->caseProductId }}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例名称</label>
                                <div class="col-sm-4">
                                    <input type="text" name="caseName" value="{{$lists->caseName}}"  placeholder="请输入案例名称" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例分类</label>
                                <div class="col-sm-4">
                                    <select name="caseTypeId" class="form-control">
                                        @foreach($categoryList as $key => $value)
                                            <option value="{{$key}}" {!! $lists->caseTypeId == $key ? "selected" : "" !!} >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例附件</label>
                                <div class="col-sm-4">
                                    <input type="text" name="enclosure" value="{{$lists->enclosure}}"  placeholder="请输入案例附件" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例排序</label>
                                <div class="col-sm-4">
                                    <input type="text" name="sort" value="{{$lists->sort}}" placeholder="请输入排序" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例显示</label>
                                <div class="col-sm-4">
                                    <input name="showNew" value="1" @if($lists->showNew == 1) checked @endif type="checkbox" />最新
                                    <input name="showHot" value="1" @if($lists->showHot == 1) checked @endif type="checkbox" />热门
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例浏览量</label>
                                <div class="col-sm-4">
                                    <input type="text" name="point" value="{{$lists->point}}" placeholder="请输入案例浏览量" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例推荐量</label>
                                <div class="col-sm-4">
                                    <input type="text" name="recommendCount" value="{{$lists->recommendCount}}" placeholder="请输入案例推荐量" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">封面图标</label>
                                <div class="col-sm-4">
                                    <div id="uploader-demo">
                                        <!--用来存放item-->
                                        <br/>
                                        <div id="filePicker">选择单图片</div>
                                        <input type="hidden" name="coverId"  id="imageId" value="{{$lists->coverId}}"/>
                                        <div id="albumList1" class="uploader-list">
                                            @if(array_get($lists, 'coverId'))
                                                <div class="file-item upload-state-done"><img width="150" height="200" src="/superman/image/get/{{array_get($lists, 'coverId')}}"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nospec"  >
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">案例相册</label>
                                    <div class="col-sm-4">
                                        <div id="uploader-demo">
                                            <!--用来存放item-->
                                            <div id="albumPicker"  >选择多图</div>
                                            <input type="hidden" name="imageId"  value=" @if(count($albumpicsList)>0) {!! (is_array($albumpicsList)) ? implode(',',$albumpicsList) : ''  !!} @endif" id="albumpics"/>
                                            <div id="albumList" class="uploader-list">
                                                @if(!empty($albumpicsList))
                                                    @if(is_array($albumpicsList))
                                                        @foreach($albumpicsList as $image)
                                                            <div class="file-item upload-state-done"><img width="150" height="200" src="/superman/image/get/{{$image}}"></div>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传附件</label>
                                <div class="col-sm-4">
                                    <div id="uploader" class="wu-example">
                                        <div id="thelist" class="uploader-list"></div>
                                        <a id="upload_file_btn"></a><span class="tips"></span>
                                        <input type="hidden" name="enclosureId"  value="@if(isset($lists->enclosure)){{$lists->enclosure}} @endif "  id="fileID1"/>
                                        <p class="filename">@if(isset($lists->realname)) {{$lists->realname}}&nbsp;&nbsp;<a href="/files/downloadfiletemp/{{ $lists->id }}">下载素材</a> @endif</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <span class="tips">支持RAR\ZIP\PDF\DOC\XLS格式文件，单个文件不超过4G，如上传多个附件，请压缩成一个附件上传，单个文件不超过4G</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">案例图文描述</label>
                                <div class="col-sm-4">
                                    <textarea id="container" name="content"  style="width:800px;;height:500px;">{{$lists->content}}</textarea>
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
                        <!-- 基础信息 End -->
            </div>
        </div>
    </div>
    {!!HTML::script('super/webuploader/webuploader.js') !!}
    {!!HTML::style("super/webuploader/webuploader.css") !!}
    {!!HTML::script('common/ueditor/ueditor.config.js')!!}
    {!!HTML::script('common/ueditor/ueditor.all.min.js')!!}
    {!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js')!!}
    {!!HTML::script('super/laydate/laydate.js') !!}
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        var flag = 0;
        $(function(){
            /**
             * 上传附件的通用方法（除上传素材）
             */
            $("#upload_file_btn").uploadify({
                'height'        : 38,
                'width'         : 82,
                'buttonText'    : '选择文件',
                'swf'           : '/uploadify/uploadify.swf',
                'uploader'      : '/files/upload',
                'auto'          : true,
                'multi'         : false,
                'buttonClass'  : 'btn btn-primary',
                'removeCompleted':true,
                'cancelImg'     : '/uploadify/uploadify-cancel.png',
                'fileTypeExts'  : '*.rar;*.zip;*.pdf;*.doc;*.docx;*.xls;*.xlsx;*.pptx;',
                'fileSizeLimit' : '4092MB',
                'onUploadSuccess':function(file,res,response){
                    //console.log(file);//文件属性
                    var data = JSON.parse(res);
                    if(data.tips===undefined){
                        data.tips = '上传失败,data.tips返回为'+data.tips;
                    }
                    $('.filename').html(file.name+'<span class=\"red-font\">'+data.tips+'</span>');
                    $('#fileID1').val(data.content.fileId);
                },
                //加上此句会重写onSelectError方法【需要重写的事件】
                'overrideEvents': ['onSelectError', 'onDialogClose'],
                //返回一个错误，选择文件的时候触发
                'onSelectError':function(file, errorCode, errorMsg){
                    switch(errorCode) {
                        case -110:
                            littleTips("文件 ["+file.name+"] 大小超出系统限制的" + jQuery('#upload_file_btn').uploadify('settings', 'fileSizeLimit') + "大小！");
                            break;
                        case -120:
                            littleTips("文件 ["+file.name+"] 大小异常！");
                            break;
                        case -130:
                            littleTips("文件 ["+file.name+"] 类型不正确！");
                            break;
                    }
                }
            });
        })
        // 上传附件
        process(WebUploader.create({
            displayId:'fileList',
            setid:'#fileId',
            //  fileNumLimit : 1,
            auto: true, // 选完文件后，是否自动上传。
            swf: '/webuploader/dist/Uploader.swf', // swf文件路径
            server: '/superman/files/upload',   // 文件接收服务端。
            pick: '#enclosurePicker',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
            formData: {'_token': '<?php echo  csrf_token() ?>' },
             accept: {
                 title: 'text',
                 extensions: 'pdf,doc,docx,xls,rar,zip,xlsx',
                 mimeTypes: 'application/*'
             }
        }));

        $('input[name="isSpec"]').change(function(){
            $val = $(this).val();
            if ($val == 0){
                $('.nospec').show();
                $('.isspec').hide();
            } else {
                $('.nospec').hide();
                $('.isspec').show();
            }
        });

        $('.btn.btn-info.batchCode').click(function(){
            $.ajax({
                type: "GET",
                url:"/superman/preorder/resetbatchcode",
                data:{'_token':'{{csrf_token()}}'},
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg.tips);
                    if (msg.status == 0) {
                        $('input[name="batchCode"]').val(msg.content.batchCode);
                        $('input[name="orderCommodityBatchId"]').val(msg.content.orderCommodityBatchId);
                    }
                }
            });
        });
        process(WebUploader.create({
            displayId:'albumList1',
            setid:'#imageId',
            // fileNumLimit : 1,
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

        process(WebUploader.create({
            displayId:'albumList',
            setid:'#albumpics',
            auto: true, // 选完文件后，是否自动上传。
            swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
            server: '/superman/image/upload',   // 文件接收服务端。
            pick: '#albumPicker',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
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
                if(displayId == 'albumList'){
                    if(flag == 0){
                        displayObj.html( "" );
                        flag ++;
                    }
                    displayObj.append( $li );
                }else{
                    displayObj.html( $li );
                }
                var thumbnailWidth = 150;
                var thumbnailHeight = 150;
                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                if(setId != "#fileId") {
                    uploader.makeThumb(file, function (error, src) {
                        if (error) {
                            $img.replaceWith('<span>不能预览</span>');
                            return;
                        }

                        $img.attr('src', src);
                    }, thumbnailWidth, thumbnailHeight);
                }
            });
            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id );
                $percent = $li.find('.progress .progress-bar');

                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo( $li ).find('.progress-bar');
                }

                $li.find('p.state').text('上传中');

                $percent.css( 'width', percentage * 100 + '%' );
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file,respone ) {
                if (fileNumLimit == 1) {
                    setObj.val(respone.content.imageId);
                } else {
                    var val = setObj.val();
                    if(setId == '#albumpics'){
                        if(flag == 1){
                            setObj.val(null);
                            val = null;
                            flag ++;
                        }
                        if  (val) {
                            val += ',' +respone.content.imageId;
                        } else {
                            val = respone.content.imageId;
                        }
                    }else{
                        val = respone.content.imageId;
                    }
                    setObj.val(val);
                }
                if(respone.content.filename){
                    $("#fileList").html(respone.content.filename);
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
        function store()
        {
            $.ajax({
                type: "POST",
                url:"/superman/casetypeproduct/edit",
                data:$('#form').serialize(),
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg['tips'])
                    if (!msg['url']) {
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
            location.href = '/superman/casetypeproduct/index';
        }
    </script>
@stop