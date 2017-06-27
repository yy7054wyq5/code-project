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
                    <h4><i class="fa fa-table"></i>编辑信息列表</h4>
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
                            <li><a href="#ios" data-toggle="tab">规格</a></li>
                          <!--  <li><a href="#freight" data-toggle="tab">运费选择</a></li> -->

                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选择品牌</label>
                                    <div class="col-sm-4">
                                        <select name="brandId" class="form-control" >
                                            <option>请选择</option>
                                            @foreach($brandList as $item)
                                             <option value="{{$item->brandId}}" >{{$item->brandName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选择分类</label>
                                    <div class="col-sm-4">
                                        <select id="commoditycategory" class="form-control" >
                                            <option>请选择</option>
                                            @foreach($commodityCategoryList as $item)
                                              <option value="{{$item->categoryId}}" >{{$item->categoryName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                            <select id="nextcategory" name="categoryId" class="form-control" >
                                                <option>请选择</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="commodityName"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品副标题</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="commodityTitle"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品编号</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="productId"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">起订量</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="number"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品说明</label>
                                    <div class="col-sm-4">
                                        <textarea name="describe"  class="form-control" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品图标</label>
                                    <div class="col-sm-4">
                                        <div id="uploader-demo">
                                            <!--用来存放item-->
                                            <div id="fileList" class="uploader-list"></div>
                                            <div id="filePicker">选择图片</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">状态</label>
                                    <div class="col-sm-4">
                                        <input type="radio" name="status"   value="1" /> 下架
                                        <input type="radio" name="status" selected  value="0"  /> 上架
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">推荐</label>
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="recommend"   value="1" /> 复选多多推荐
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

                            <!-- ///////////////////////   规格   ///////////////////  -->

                            <div class="tab-pane fade" id="ios">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">原价</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="oldPrice"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">促销价</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="promotionPrice"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">最多可使用积分</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="integral"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">内容</label>
                                    <div class="col-sm-4">
                                        <textarea name="content" class="form-control" ></textarea>
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

                            <!-- ////////////////////////   	运费选择    /////////////////////////   -->
                        <!--    <div class="tab-pane fade" id="freight">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">原价</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="sort"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">促销价</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="sort"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">最多可使用积分</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="sort"  class="form-control"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">内容</label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <button onclick="return store()" class="btn btn-primary">保存</button>
                                        <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="tab-pane fade" id="ejb">
                                <p>Enterprise Java Beans (EJB) is a development architecture
                                    for building highly scalable and robust enterprise level
                                    applications to be deployed on J2EE compliant
                                    Application Server such as JBOSS, Web Logic etc.
                                </p>
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
        var uploader = WebUploader.create({
            auto: true, // 选完文件后，是否自动上传。
            swf:  '/webuploader/dist/Uploader.swf', // swf文件路径
            server: '/superman/brand/upload',   // 文件接收服务端。
            pick: '#filePicker',   // 选择文件的按钮。可选。  内部根据当前运行是创建，可能是input元素，也可能是flash.
            formData: {'_token': '<?php echo  csrf_token() ?>' },
            accept: {// 只允许选择图片文件。
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

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


        //  二级分类
        $("#commoditycategory").change(function(){

            $.ajax({
                type: "POST",
                url:"/superman/commodity/category",
                data:{'categoryId':$(this).val(),'_token':'{{csrf_token()}}'},
                dataType: 'json',
                success: function(msg) {
                    var html = '<option>请选择</option>';
                    for(var i=0;i<msg['content'].length;i++){
                        html += '<option value="'+msg['content'][i]['categoryId']+'" >'+msg['content'][i]['categoryName']+'</option>';
                    }
                     $("#nextcategory").html(html);
                },
            });
        })
    })

    function store()
    {
        $.ajax({
            type: "POST",
            url:"/superman/commodity/add",
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
        location.href = '/superman/commodity/index';
    }
</script>