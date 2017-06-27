@extends('admin.base')
@section('content')
    {!!HTML::script('uploadify/jquery-1.7.2.js')!!}
    {!!HTML::script('uploadify/jquery.uploadify-3.1.min.js')!!}
    {!!HTML::style('uploadify/uploadify.css')!!}
    {!!HTML::style('common/multiple/multi-select.css')!!}
    {!!HTML::script('common/multiple/jquery.multi-select.js') !!}
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
                <span class="hidden-inline-mobile">新增官方素材产品</span>
            </h4>
        </div>
        <div class="box-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="box_tab1">
                        <!-- 基础信息 Begin -->
                        <form class="form-horizontal" id="form" onsubmit="return false;">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">品牌选择</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="brand" onchange="getCar();" name="brandId">
                                        <option value="-1" >&nbsp;&nbsp;请选择&nbsp;&nbsp;</option>
                                        @foreach($brandList as $key => $value)
                                            <option value="{{$key}}"  data-id="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                 <!--   <p class="text-muted small form-control-static"><font color="red">*必选</font></p> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">车型选择选择</label>
                                <div class="col-sm-4">
                                    <div class='hero-multiselect'>
                                        <select multiple  id="car" name="info[carmodleId][]">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">素材分类</label>
                                <div class="col-sm-4">
                                    <select name="category" class="form-control"  >
                                        <option value="0"  >  请选择 </option>
                                        @foreach($materlList as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select name="categoryId" class="form-control"  ></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">素材名称</label>
                                <div class="col-sm-4">
                                    <input type="text" name="materialName" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-4"><input type="text" name="sort" class="form-control" value="0" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">下载所需积分</label>
                                <div class="col-sm-4">
                                    <input type="text" name="integral"  class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传图片</label>
                                <div class="col-sm-4">
                                    <div id="uploader-demo">
                                        <!--用来存放item-->
                                        <div id="albumPicker"  >选择多图</div>
                                        <input type="hidden" name="albumpics"  id="albumpics"/>
                                        <div id="albumList" class="uploader-list"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传附件链接</label>
                                <div class="col-sm-4">
                                    <input name="attachmentName" class="form-control"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传附件</label>
                                <div class="col-sm-4">
                                    <div id="uploader" class="wu-example">
                                        <div id="thelist" class="uploader-list"></div>
                                            <a id="upload_file_btn"></a><span class="tips"></span>
                                            <input type="hidden" name="fileId"  id="fileID1"/>
                                            <p class="filename"></p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <span class="tips">支持RAR\ZIP\PDF\DOC\XLS格式文件，单个文件不超过4G，如上传多个附件，请压缩成一个附件上传，单个文件不超过4G</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-4">
                                    <select name="status" class="form-control">
                                        <option value="0">未审核</option>
                                        <option value="1" selected="true"  >审核通过</option>
                                        <option value="2" >审核未通过</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图文描述</label>
                                <div class="col-sm-4">
                                    <textarea id="container" name="describle" style="width:800px;;height:500px;"></textarea>
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
    {!!HTML::script('common/ueditor/ueditor.config.js') !!}
    {!!HTML::script('common/ueditor/ueditor.all.js') !!}
    {!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js') !!}
    {!!HTML::script('webuploader/dist/webuploader.js') !!}
    {!!HTML::style("webuploader/dist/webuploader.css") !!}
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        var flag = 0;
        var $user = $('#car').multiSelect();
        $(function(){
            $("select[name='brandId']").change(function(){
                var brandId = $(this).val();
                $.ajax({
                    type: "POST",
                    url:"/superman/materialproduct/brands",
                    data:{'id':brandId,'_token':'<?php csrf_token() ?>'},
                    dataType: 'json',
                    success: function(msg) {
                        var html = "";
                        var content = msg['content'];
                        for(var i= 0;content.length>i;i++)
                        {
                            html +='<option value ="'+content[i]['carmodelId']+'">'+content[i]['carmodelName']+'</option >';
                        }
                        // alert(html);
                        $('select[name="carmodleId[]"]').html(html);
                    },
                    error: function(error){
                        //layer.msg("操作失败")
                    }
                });
            })

            /**
             * 上传附件的通用方法（除上传素材）
             */
            $("#upload_file_btn").uploadify({
                'height'        : 38,
                'width'         : 82,
                'buttonText'    : '选择文件',
                'swf'           : '/uploadify/uploadify.swf',
                'uploader'      : '/files/upload?qiniu=1',
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



            //
            $(document).on('click', '.itinerary .add.periodprice', function () {
                var html = '<div class="item periodprice">' +
                        '<div class="input-group input-group-sm">' +
                        '<input type="text" name="numberStart[]" class="form-control" placeholder="起始量(包含)">' +
                        '<div class="input-group-addon">至</div>' +
                        '<input type="text" name="numberEnd[]" class="form-control" placeholder="截止量(包含)">' +
                        '<div class="input-group-addon"></div>' +
                        '<div class="input-group-addon">价格</div>' +
                        '<input type="text" name="price[]" class="form-control">' +
                        '<div class="input-group-addon" onclick="javascript:$(this.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>' +
                        '</div>' +
                        ' </div>';
                $('.itinerary.periodprice').append(html);
            });
            //
            $(document).on('click', '.btn.btn-primary.spec', function () {
                var length = $('.form-group.spec').length;
                var index = length + 1;
                console.log(index);
                var html = '<div class="form-group spec" data-index="'+index+'">' +
                        '<label for="" class="control-label col-sm-2 required"></label>' +
                        '<div class="col-sm-6">' +
                        '<div class="input-group" style="width: 850px;" >' +
                        '<div class="input-group-addon">规格值</div>' +
                        '<input type="text" class="form-control" name="specvalue['+index+']">' +
                        '<div class="input-group-addon">原价</div>' +
                        '<input type="text" class="form-control" name="price['+index+']">' +
                        '<div class="input-group-addon">促销价</div>' +
                        '<input type="text" class="form-control" name="proprice['+index+']">' +
                        '<div class="input-group-addon">可用积分</div>' +
                        '<input type="text" class="form-control" name="maxCredits['+index+']">' +
                        '<div class="input-group-addon specimage1">选择单图<div class="t1" id="specimage'+index+'">选择单图</div></div>' +
                        '<div class="input-group-addon" onclick="$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>' +
                        '</div>' +
                        '<div id="specimageList'+index+'" class="t2"></div>' +
                        '<input type="hidden" class="form-control" name="specimage['+index+']" id="specimageval'+index+'">' +
                        '</div>' +
                        '</div>';
                if (length >0) {
                    $($('.form-group.spec')[length-1]).after(html);
                }else {
                    $('.form-group.specadd').after(html);
                }

                process(WebUploader.create({
                    displayId:'specimageList'+index,
                    setid:'#specimageval'+index,
                    fileNumLimit : 1,
                    auto: true, // 选完文件后，是否自动上传。
                    swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
                    server: '/superman/image/upload',   // 文件接收服务端。
                    pick: '#'+ 'specimage'+index,   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
                    formData: {'_token': '<?php echo  csrf_token() ?>' },
                    accept: {// 只允许选择图片文件。
                        title: 'Images',
                        extensions: 'gif,jpg,jpeg,bmp,png',
                        mimeTypes: 'image/*'
                    }
                }));
            });

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
                displayId:'fileList',
                setid:'#fileId',
                fileNumLimit : 1,
                auto: true, // 选完文件后，是否自动上传。
                swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
                server: '/superman/files/upload?qiniu=1',   // 文件接收服务端。
                pick: '#filePicker',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
                formData: {'_token': '<?php echo  csrf_token() ?>' },
                 accept: {
                     title: 'text',
                     extensions: 'pdf,doc,docx,xls,rar,zip,xlsx',
                     mimeTypes: 'application/*'
                 }
            }));

            process(WebUploader.create({
                displayId:'albumList',
                setid:'#albumpics',
                auto: true, // 选完文件后，是否自动上传。
                swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
                server:  '/superman/image/upload',   // 文件接收服务端。
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
                flag = 0;
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
                    if(flag == 0){
                        displayObj.html("");
                        flag++;
                    }
                    // $list为容器jQuery实例
                    displayObj.append( $li );
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
                                val = '';
                                flag ++;
                            }
                            if(val) {
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

            $('select[name="category" ]').bind('change',function(){
                var id = $(this).val();
                $.ajax({
                    type: "get",
                    url:"/superman/materialproduct/category/"+id,
                    data:$('#form').serialize(),
                    dataType: 'json',
                    success: function(msg) {
                       var html = "<option value='0' >请选择</option>";
                        $.each(msg['content'],function(k,v){
                            html += "<option value='"+k+"' >"+v+"</option>";
                        }) ;
                        $('select[name="categoryId"]').html(html);
                    },
                    error: function(error){
                        //layer.msg("操作失败")
                    }
                });
            })
        })

        function store()
        {
            $.ajax({
                type: "POST",
                url:"/superman/materialproduct/add",
                data:$('#form').serialize(),
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg['tips'])
                    if (!msg['url']) {
                        if(!msg['status']){
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
            location.href = '/superman/materialproduct/index';
        }

        function getCar()
        {
            var pid = $("#brand option:selected").attr('data-id');
            $.post("/superman/trading/car", {id: pid, _token : $("#token").val()}, function(data){
                var t = '';
                $.each(data['content'], function () {
                    t += '<option value="'+ this.carmodelId +'">'+ this.carmodelName +'</option>';
                });
                $user.html(t).multiSelect('refresh');
            }, "json");
        }
    </script>
@stop