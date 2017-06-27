@extends('admin.base')
@section('content')
    {!!HTML::script('jcDate/js/jquery.min.js')!!}
    {!!HTML::script('jcDate/js/jQuery-jcDate.js')!!}
    {!!HTML::style("jcDate/css/jcDate.css") !!}
    <style type="text/css">
        th,td{ font-size: 14px;}
        .form-control { width:250px; }
        .editor-class { width: 800px;}
        #editor1,#editor2,#editor3,#editor { width: 800px; height: 400px;}

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
                    <h4><i class="fa fa-table"></i>新增商品</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <form class="form-horizontal" id="form" onsubmit="return false;" >
                <div class="box-body">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">基础数据</a></li>
                            <li><a href="#productManage" data-toggle="tab" >产品经理推荐</a></li>
                            <li><a href="#product" data-toggle="tab" >产品特色</a></li>
                            <li><a href="#ios" data-toggle="tab">行程介绍</a></li>
                            <li ><a href="#jmeter" data-toggle="tab">费用说明</a></li>
                            <li ><a href="#server" data-toggle="tab">预定须知</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">选择品牌</label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <select id="brand" class="form-control" >
                                                <option value="-1">全品牌</option>
                                                @foreach($brandList as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            {!! Form::hidden('brandId', null) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            <font color="#dc143c" >必填</font>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">选择分类</label>
                                        <div class="col-sm-4">
                                            {!! Form::select(null,$commodityList,1,['id'=>'select_type','class'=>'form-control']) !!}
                                            {!! Form::hidden('type', null) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            <font color="#dc143c" >必填</font>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品名称</label>
                                        <div class="col-sm-4">
                                            {!!Form::text('commodityName',null,['class'=>'form-control','placeholder'=>'请输入商品名称'])  !!}
                                        </div>
                                        <div class="col-sm-4">
                                            <font color="#dc143c" >必填</font>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品副标题</label>
                                        <div class="col-sm-4">
                                            {!!Form::text('commodityTitle',null,['class'=>'form-control','placeholder'=>'请输入商品副标题',])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品编号</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('commodityId',null,['class'=>'form-control','placeholder'=>'请输入商品编号',])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">积分赠送</label>
                                        <div class="col-sm-4">
                                            {!!  Form::text('integralOut',null,['class'=>'form-control'])!!}
                                        </div>
                                        <div class="col-sm-4">
                                            <font color="#dc143c">整数</font>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">行程天数</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('travelDays',null,['class'=>'form-control','placeholder'=>'请输入行程天数',])!!}
                                        </div>
                                        <div class="col-sm-4">
                                            <font color="#dc143c">整数</font>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">行程方式</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('strokeMode',null,['class'=>'form-control','placeholder'=>'请输入行程方式',])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">出发日期</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('selectDate',null,['class'=>'form-control jcDate ','id'=>'selectDate','placeholder'=>'请输入出发日期',])!!}
                                            <br/><textarea type="text" id="departureDate"  name="departureDate"  class='form-control'  rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">起订量</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('number',null,['class'=>'form-control','placeholder'=>'请输入起订量',])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">状态</label>
                                        <div class="col-sm-4">
                                            <input name="status" type="radio" checked  value="1" /> 上架
                                            <input name="status" type="radio"    value="0" /> 下架
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> 图标</label>
                                        <div class="col-sm-4">
                                            <div id="uploader-demo">
                                                <!--用来存放item-->
                                                <div id="fileList" class="uploader-list"></div>
                                                <div id="filePicker">选择图片</div>
                                                <input type="hidden" name="imageId"  id="imageId" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> 属性</label>
                                        <div class="col-sm-4">
                                            <input type="checkbox" value="1"   name="recommend"  />&nbsp;多多推荐
                                        </div>
                                    </div>

                                <!-- 基础信息 End -->
                                <!-- 适配车型 Begin -->
                                <input type="hidden" name="isSpec" value="1"  />
                                <div class="isspec" style="display: block">
                                    <div class="form-group specadd">
                                        <label for="" class="control-label col-sm-2 required">规格值及图片</label>
                                        <div class="col-sm-6">
                                            <button class="btn btn-primary spec"><i class="fa fa-plus-circle"></i> 添加</button>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
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
                            </div>
                            <div class="tab-pane fade" id="productManage"  >
                                <div class="tab-pane fade in active" id="home">
                                    <div class="form-group" style="height: 550px;" >
                                        <label class="col-sm-2 control-label">产品经理推荐</label>
                                        <div class="col-sm-4">
                                            <textarea type="text" id="editor5"  name="productManager"  style="width: 800px; height: 500px;"  ></textarea>
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
                            <div class="tab-pane fade" id="product"  >
                                <div class="tab-pane fade in active" id="home">
                                    <div class="form-group" style="height: 550px;" >
                                        <label class="col-sm-2 control-label">产品特色</label>
                                        <div class="col-sm-4">
                                            <textarea type="text" id="editor0"  name="productFeatures"  style="width: 800px; height: 500px;"  ></textarea>
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
                                <div class="tab-pane fade in active" id="home">
                                    <div class="form-group" style="height: 550px;"  >
                                        <label class="col-sm-2 control-label">行程介绍</label>
                                        <div class="col-sm-4">
                                            <textarea type="text" id="editor1"  name="travelIntroduction"    style="width: 800px; height:500px;"></textarea>
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
                            <div class="tab-pane fade" id="jmeter">
                                <div class="tab-pane fade in active" id="home">
                                <div class="form-group" style="height: 550px;" >
                                    <label class="col-sm-2 control-label">费用说明</label>
                                    <div class="col-sm-4">
                                        <textarea type="text" id="editor2"  name="costDescription"    style="width: 800px; height:500px;"></textarea>
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
                            <div class="tab-pane fade" id="server">
                                <div class="tab-pane fade in active" id="home">
                                        <div class="form-group" style="height: 550px;" >
                                            <label class="col-sm-2 control-label">预定须知</label>
                                            <div class="col-sm-4">
                                                <textarea type="text" id="editor3"  name="reservationInfo"  style="width: 800px; height:500px;"></textarea>
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

{!!HTML::script('common/ueditor/ueditor.config.js')!!}
{!!HTML::script('common/ueditor/ueditor.all.min.js')!!}
{!!HTML::script('common/ueditor/lang/zh-cn/zh-cn.js')!!}

<script type="text/javascript" >

    var ue = UE.getEditor('editor0');
    var ue = UE.getEditor("editor1");
    var ue = UE.getEditor("editor2");
    var ue = UE.getEditor("editor3");
    var ue = UE.getEditor("editor5");

    $(function(){

        $("input.jcDate").jcDate({
            IcoClass : "jcDateIco",
            Event : "click",
            Speed : 100,
            Left : 0,
            Top : 28,
            format : "-",
            Timeout : 100
        });

        //选择品牌
        $("input[name='brandId']").val($("#brand").val());
        $("#brand").change(function(){
            var brandId =  $(this).val();
            $("input[name='brandId']").val(brandId);
        });

        //选择分类
        $("input[name='type']").val($("#select_type").val());
        $("#select_type").change(function(){
            var type =  $(this).val();
            $("input[name='type']").val(type);
        });
        //
        $(document).on('click', '.btn.btn-primary.spec', function () {
            var length = $('.form-group.spec').length;
            var index = length + 1;
            console.log(index);
            var html = '<div class="form-group spec" data-index="'+index+'">' +
                    '<label for="" class="control-label col-sm-2 required"></label>' +
                    '<div class="col-sm-6">' +
                    '<div class="input-group" style="width: 860px;" >' +
                    '<div class="input-group-addon">内容</div>' +
                    '<input type="text" style="width:150px;" class="form-control" name="specvalue['+index+']">' +
                    '<div class="input-group-addon">规格原价</div>' +
                    '<input type="text" class="form-control" name="price['+index+']">' +
                    '<div class="input-group-addon">促销价</div>' +
                    '<input type="text" class="form-control" name="proprice['+index+']">' +
                    '<div class="input-group-addon">可使用积分</div>' +
                    '<input type="text" class="form-control" name="maxCredits['+index+']">' +
                  //  '<div class="input-group-addon">库存</div>' +
                  //  '<input type="text" class="form-control" name="stock['+index+']">' +
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
               // fileNumLimit : 1,
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

        // 初始化Web Uploader
        process(WebUploader.create({
            displayId:'fileList',
            setid:'#imageId',
         //   fileNumLimit : 1,
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
                    }else{
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
    });
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/riders/add",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    if(!msg['status']){
                        setTimeout("reload()", 1200)
                    }
                }
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        location.href = '/superman/riders/index';
    }
</script>