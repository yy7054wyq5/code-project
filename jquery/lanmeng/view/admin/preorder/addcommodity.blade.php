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
                    <h4><i class="fa fa-table"></i>新增预定商品</h4>
                    <div class="tools hidden-xs">
                        <a href="javascript:;" class="collapse">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" id="form" onsubmit="return false;" >
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active">
                                <a href="#home" data-toggle="tab">基础信息</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选择品牌</label>
                                    <div class="col-sm-4">
                                        <select name="info[brandId]" class="form-control" >
                                            @foreach($brandList as $item)
                                             <option value="{{$item->brandId}}" >{{$item->brandName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选择分类</label>
                                    <div class="col-sm-4">
                                        <select name="info[categoryId]" class="form-control" >
                                            @foreach($categoryList as $item)
                                              <option value="{{$item->id}}" >{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[name]" class="form-control" />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品副标题</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[title]"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品编号</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[code]"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">排序</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[sort]" class="form-control"   />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必须为数字</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">定金</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[prepayPrice]"  class="form-control"   />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">原价</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[sourcePrice]"  class="form-control"   />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">开始时间</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[timeStart]" placeholder="开始时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="form-control" />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填 大于当前时间</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">结束时间</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[timeEnd]" placeholder="结束时间" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss',  choose:chooseCbk})" class="form-control" />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填 大于开始时间</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">批次号</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[batchCode]" disabled="true" class="form-control" />
                                    </div>
                                    <input type="hidden" name="info[orderCommodityBatchId]"/>
                                    <div class="col-sm-1 btn btn-info batchCode">设置批次号
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">起订量</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[minNumber]"  class="form-control"   />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">最大订量</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[maxNumber]"  class="form-control"   />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label col-sm-2 required">阶梯价格设置</label>

                                    <div class="col-sm-6">
                                        <div class="itinerary form-inline periodprice">
                                            <a href="javascript:;" class="btn btn-primary add periodprice"><i class="fa fa-plus-circle"></i> 添加</a>
                                            <div class="item periodprice">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" name="numberStart[]" class="form-control" placeholder="起始量(包含)">
                                                    <div class="input-group-addon">至</div>
                                                    <input type="text" name="numberEnd[]" class="form-control" placeholder="截止量(包含)">
                                                    <div class="input-group-addon">价格</div>
                                                    <input type="text" name="price[]" class="form-control">
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
                                    <label class="col-sm-2 control-label">最多可使用积分</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[maxCredits]"  class="form-control"  value="0">
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">额外赠送积分</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[integral]"  class="form-control"  value="0" />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">状态</label>
                                    <div class="col-sm-4">
                                        <input type="radio" name="info[status]" value="0" /> 下架
                                        <input type="radio" name="info[status]" value="1" checked /> 上架
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">运费方式</label>
                                    <div class="col-sm-7">
                                        @foreach(Config::get('other.dispatch') as $key => $value)
                                        <input type="radio" onclick="changeDispatch({{$key}});" name="info[dispatch]" value="{{ $key }}" />{{ $value }}&nbsp;
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group" id="volume" style="display: none;">
                                    <label class="col-sm-2 control-label">请输入单件商品体积或质量</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[unit_num]" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">单位</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">推荐</label>
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="info[recommend]" value="1" /> 复选多多推荐
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品图标</label>
                                    <div class="col-sm-4">
                                        <div id="uploader-demo">
                                            <!--用来存放item-->
                                            <div id="filePicker">选择单图</div>
                                            <input type="hidden" name="info[cover]" id="imageId"/>
                                            <div id="fileList" class="uploader-list"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>

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

                                    <label class="col-sm-2 control-label">商品说明<font color="red">*必填</font></label>

                                    <div class="col-sm-4">
                                        <textarea type="text" id="container"  name="info[describe]" style="width: 800px; height: 500px;"></textarea>
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
    var ue = UE.getEditor('container');
    var count =0;
    $(function(){
        //
        $(document).on('click', '.itinerary .add.periodprice', function () {
            var html = '<div class="item periodprice">' +
                    '<div class="input-group input-group-sm">' +
                    '<input type="text" name="numberStart[]" class="form-control" placeholder="起始量(包含)">' +
                    '<div class="input-group-addon">至</div>' +
                    '<input type="text" name="numberEnd[]" class="form-control" placeholder="截止量(包含)">' +
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
                    '<div class="input-group">' +
                    '<div class="input-group-addon">规格值</div>' +
                    '<input type="text" class="form-control" name="specvalue['+index+']">' +
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


        $('.btn.btn-info.batchCode').click(function(){
            $.ajax({
                type: "GET",
                url:"/superman/preorder/resetbatchcode",
                data:{'_token':'{{csrf_token()}}'},
                dataType: 'json',
                success: function(msg) {
                    layer.msg(msg.tips);
                    if (msg.status == 0) {
                        $('input[name="info[batchCode]"]').val(msg.content.batchCode);
                        $('input[name="info[orderCommodityBatchId]"]').val(msg.content.orderCommodityBatchId);
                    }
                }
            });
        });

        process(WebUploader.create({
            displayId:'fileList',
            setid:'#imageId',
            fileNumLimit : 1,
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
               uploader.reset();
           });
       }

    });

    function store()
    {
        $('input[name="batchCode"]').attr("disabled",false);
        $.ajax({
            type: "POST",
            url:"/superman/preorder/addcommodity",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (msg.status == 0 && !msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        window.location.href = '/superman/preorder/list';
    }


    function chooseCbk(dates)
    {
        count++;
        var h = dates.substring(11,13);
        var m = dates.substring(14,16);
        var s = dates.substring(17,19);
        if (h == '00' && m=='00' && s=='00' && count==1) $('input[name="timeEnd"]').val(dates.substring(0,10) + ' 23:59:59');
    }

    function changeDispatch(id)
    {
        if (id == 5 || id == 6) {
            $('#volume').show();
        } else {
            $('#volume').hide();
        }
    }
</script>
