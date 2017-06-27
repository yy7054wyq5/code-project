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
                <form class="form-horizontal" id="form" onsubmit="return false;">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="mallCommodityId"  value="{{ $commodity['id'] }}" />
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#home" data-toggle="tab">基础信息</a>
                        </li>
                        {{--<li><a href="#ios" data-toggle="tab">规格</a></li>--}}
                        <!--  <li><a href="#freight" data-toggle="tab">运费选择</a></li> -->
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="home">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">选择品牌</label>
                                    <div class="col-sm-4">
                                        <select name="info[brandId]" class="form-control" >
                                            <option >请选择</option>
                                            @foreach($brandList as $item)
                                            <option value="{{$item->brandId}}" @if($item->brandId == array_get($commodity, 'brandId')) selected @endif >{{$item->brandName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选择分类</label>
                                    <div class="col-sm-3">
                                        <select name="parentCategoryId" id="parentCategoryId" class="form-control" >
                                            <option>请选择</option>
                                            @foreach($categoryList as $item)
                                                <option value="{{$item->id}}" @if($item->id == $parentId) selected @endif>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <select name="info[categoryId]" id="categoryId" class="form-control" >
                                            <option>请选择</option>
                                            @if($subCategory)
                                            @foreach($subCategory as $brother)
                                                <option value="{{$brother['id']}}" @if($brother['id'] == array_get($commodity, 'categoryId')) selected @endif>{{$brother['name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[name]"  class="form-control"  value="{{ $commodity['name'] }}" />
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品副标题</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[title]"  class="form-control"  value="{{ $commodity['title'] }}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品编号</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[code]"  class="form-control"   value="{{ $commodity['code'] }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">起订量</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[minNumber]"  class="form-control"  value="{{ $commodity['minNumber'] }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">排序</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[sort]"  class="form-control" value="{{ $commodity['sort'] }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">额外赠送积分</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[integral]"  class="form-control"  placeholder="默认按价格1：1赠送"  value="{{ $commodity['integral'] }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">状态</label>
                                    <div class="col-sm-4">
                                        <input type="radio" name="info[status]" value="0" @if($commodity['status'] == 0) checked @endif /> 下架
                                        <input type="radio" name="info[status]" value="1" @if($commodity['status'] == 1) checked @endif /> 上架
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">运费方式</label>
                                    <div class="col-sm-7">
                                        @foreach(Config::get('other.dispatch') as $key => $value)
                                        <input type="radio" onclick="changeDispatch({{$key}});" @if($commodity['dispatch'] == $key) checked @endif name="info[dispatch]" value="{{ $key }}" />{{ $value }}&nbsp;
                                        @endforeach
                                    </div>
                                </div>

                               <div class="form-group" id="volume" style="display: @if(in_array($commodity['dispatch'], [5,6])) block @else none @endif;">
                                    <label class="col-sm-3 control-label">请输入单件商品体积或质量</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="info[unit_num]" value="{{ $commodity['unit_num'] }}" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">单位</font></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">推荐</label>
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="info[recommend]" value="1" @if($commodity['recommend'] == 1) checked @endif /> 复选多多推荐
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品图标</label>
                                    <div class="col-sm-4">
                                        <div id="uploader-demo">
                                            <!--用来存放item-->
                                            <div id="filePicker">选择单图</div>
                                            <input type="hidden" name="info[cover]" id="imageId" value="{{ $commodity['cover'] }}"/>
                                            <div id="fileList" class="uploader-list">
                                            @if($commodity['cover'])
                                                <div class="file-item upload-state-done">
                                                    <img width="150" height="200" src="/superman/image/get/{{ $commodity['cover'] }}">
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                    </div>
                                </div>
                                <div class="isspec">
                                    <div class="form-group specadd">
                                        <label for="" class="control-label col-sm-2 required">规格值及图片</label>
                                        <div class="col-sm-6">
                                            <button class="btn btn-primary spec"><i class="fa fa-plus-circle"></i> 添加</button>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
                                        </div>
                                    </div>
                                    @if($specs)
                                    @foreach($specs as $key => $value)
                                    <div class="form-group spec" data-index="{{ $key+1 }}">
                                    <label for="" class="control-label col-sm-2 required"></label>
                                    <div class="col-sm-10">
                                    <div class="input-group">
                                    <div class="input-group-addon">规格</div>
                                    <input type="text" class="form-control" name="specvalue[{{ $key+1 }}]" value="{{ $value['specValue'] }}">
                                    <div class="input-group-addon">原价</div>
                                    <input type="text" class="form-control" name="sourcePrice[{{ $key+1 }}]" value="{{ $value['sourcePrice'] }}">
                                    <div class="input-group-addon">促销价</div>
                                    <input type="text" class="form-control" name="price[{{ $key+1 }}]" value="{{ $value['price'] }}">
                                    <div class="input-group-addon">库存</div>
                                    <input type="text" class="form-control" name="inventory[{{ $key+1 }}]" value="{{ $value['inventory'] }}">
                                    <div class="input-group-addon">积分</div>
                                    <input type="text" class="form-control" placeholder="最多可用积分" name="maxCredits[{{ $key+1 }}]" value="{{ $value['maxCredits'] }}">
                                    <div class="input-group-addon specimage1">选择单图<div class="t1" id="specimage{{ $key+1 }}">选择单图</div></div>
                                    <div class="input-group-addon" onclick="$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>
                                    </div>
                                    <div id="specimageList{{ $key+1 }}" class="t2">
                                        <div class="file-item upload-state-done"><img width="150" height="200" src="/superman/image/get/{{ $value['imageId'] }}"></div>
                                    </div>
                                    <input type="hidden" class="form-control" name="specimageId[{{ $key+1 }}]" id="specimageval{{ $key+1 }}" value="{{ $value['imageId'] }}">
                                    <input type="hidden" class="form-control" name="commoditySpecId[{{ $key+1 }}]" value="{{ $value['specId'] }}">
                                    </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品说明<font color="red">*必填</font></label>
                                    <div class="col-sm-4">
                                        <textarea type="text" id="container" name="info[describe]" style="width: 800px; height: 500px;">{{ $commodity['describe'] }}</textarea>
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
    $(function(){
        var length = $('.form-group.spec').length;
        for(var index=1; index<=length; index++){
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
        }
        //
        $(document).on('click', '.btn.btn-primary.spec', function () {
            var length = $('.form-group.spec').length;
            var index = length + 1;
            var html = '<div class="form-group spec" data-index="'+index+'">'+
                    '<label for="" class="control-label col-sm-2 required"></label>'+
                    '<div class="col-sm-10">'+
                    '<div class="input-group">'+
                    '<div class="input-group-addon">规格</div>'+
                    '<input type="text" class="form-control" name="specvalue['+index+']">'+
                    '<div class="input-group-addon">原价</div>'+
                    '<input type="text" class="form-control" name="sourcePrice['+index+']">'+
                    '<div class="input-group-addon">促销价</div>'+
                    '<input type="text" class="form-control" name="price['+index+']">'+
                    '<div class="input-group-addon">库存</div>'+
                    '<input type="text" class="form-control" name="inventory['+index+']">'+
                    '<div class="input-group-addon">积分</div>'+
                    '<input type="text" class="form-control" placeholder="最多可用积分" name="maxCredits['+index+']">'+
                    '<div class="input-group-addon specimage1">选择单图<div class="t1" id="specimage'+index+'">选择单图</div></div>'+
                    '<div class="input-group-addon" onclick="$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>'+
                    '</div>'+
                    '<div id="specimageList'+index+'" class="t2"></div>'+
                    '<input type="hidden" class="form-control" name="specimageId['+index+']" id="specimageval'+index+'">'+
                    '</div>'+
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


        //  二级分类
        $("#parentCategoryId").change(function(){
            $.ajax({
                type: "GET",
                url:"/superman/mall/childcategory",
                data:{'categoryId':$(this).val(),'_token':'{{csrf_token()}}'},
                dataType: 'json',
                success: function(msg) {
                    if (msg.status == 0){
                        var html = '<option>请选择</option>';
                        for(var i=0;i<msg['content']['categories'].length;i++){
                            html += '<option value="'+msg['content']['categories'][i]['id']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                        }
                        $("#categoryId").html(html);
                    }

                }
            });
        })

        // 运费计算方式选择
        $('input[name="shippingMethod"]').on('click',function(){
            var method = $(this).val();
            if(method == 5){
                $('.weight-group').css('display','none');
                $('.volume-group').css('display','block');
            }else if(method == 6){
                $('.volume-group').css('display','none');
                $('.weight-group').css('display','block');
            }else{
                $('.volume-group').css('display','none');
                $('.weight-group').css('display','none');
            }
        });
    });

    function store()
    {
        $('input[name="batchCode"]').attr("disabled",false);
        $.ajax({
            type: "POST",
            url:"/superman/mall/editcommodity",
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
        location.href = '/superman/mall/list';
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
