@extends('admin.adminbase')

@section('title', '新增商品')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增商品</h3>
        </div>
        <form action="{{url('/backstage/commodity/add-product')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">商品名称</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入商品名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">商品英文名称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入商品英文名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">商品价格</label>
                    <div class="col-sm-4">
                        <input name="price" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入商品价格</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">商品摘要</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="summary" ></textarea>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入商品摘要</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">商品英文摘要</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="summaryEn" ></textarea>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入商品摘要</p>
                    </div>
                </div>
                <div class="isspec">
                    <div class="form-group specadd">
                        <label for="" class="control-label col-sm-2 required">商品规格</label>
                        <div class="col-sm-6">
                            <button class="btn btn-primary spec"><i class="fa fa-plus-circle"></i> 添加</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">缩略图</label>
                    <div class="col-sm-4">
                        <input id="file_upload" name="file_upload"  type="file" multiple="true">
                        <input type="hidden" id="picKey" name="picKey" />
                        <div id="image"></div>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请上传缩略图</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">相册</label>
                    <div class="col-sm-5">
                        <input id="album_upload" name="file_upload"  type="file" multiple="true">
                        <div id="album"></div>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static text-muted small">可上传多图</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">商品图文描述</label>
                    <div class="col-sm-8">
                        <textarea name="detail" type="password" id="container" ></textarea>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认更新</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        /**
         * 删除图片
         * @return string
         */
        function delImg(obj,iconid){
            var $this = $(obj);
            if(typeof $this !== 'object'){
                return false;
            }
            $.post("<?php echo url('/image/del') ?>",{'id':iconid},function(json){
                 console.log(json);
                if(json.status == 'alert'){
                    alert(json.msg);
                }else{
                   // console.log($this);
                    $this.parent().remove();
                }
            },'json');
        }
        <?php $timestamp = time();?>

        $(document).on('click', '.specadd', function (event) {
            event.preventDefault();
            var length = $('.form-group.spec').length;
            var index = length + 1;
           // console.log(index);
            var html = '<div class="form-group spec" data-index="'+index+'">' +
                    '<label for="" class="control-label col-sm-2 required"></label>' +
                    '<div class="col-sm-4">' +
                    '<div class="input-group" style="width: 350px;" >' +
                    '<div class="input-group-addon">规格值</div>' +
                    '<input type="text" class="form-control" name="specvalue[]">' +
                    '<div class="input-group-addon" onclick="$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            if (length >0) {
                $($('.form-group.spec')[length-1]).after(html);
            }else {
                $('.form-group.specadd').after(html);
            }
        });


        $(document).ready(function(){
              $('#file_upload').uploadify({
                 'height'        : 80,
                 'width'         : 80,
                 'buttonText'    : '选择文件',
                 'swf'       : '/uploadify/uploadify.swf',
                 'uploader' : '/image/upload',
                  'buttonImage': '/img/admin/add-photo-multi.png',
                 'auto'          : true,
                 'multi'         : false,
                 'fileTypeExts'  :  '*.gif;*.jpg;*.jpeg;*.png',
                 'fileSizeLimit' : '4092MB',
                  'onUploadSuccess':function(file,res,response){
                      var data = JSON.parse(res);
                      if(data.tips===undefined){
                          data.tips = '上传失败,data.tips返回为'+data.tips;
                      }
                      $('#image').html('<a href="#" class="thumbnail"  ><image style="width:150px; height:150px;" src="/image/get/'+data.imageId+'" /></a>');
                      $('#picKey').val(data.imageId);
                  }
             });
        });
        $(document).ready(function(){
              $('#album_upload').uploadify({
                 'height'        : 80,
                 'width'         : 80,
                 'buttonText'    : '选择文件',
                 'swf'       : '/uploadify/uploadify.swf',
                 'uploader' : '/image/upload',
                  'buttonImage': '/img/admin/add-photo-multi.png',
                 'auto'          : true,
                 'multi'         : true,
                 'fileTypeExts'  :  '*.gif;*.jpg;*.jpeg;*.png',
                 'fileSizeLimit' : '4092MB',
                  'onUploadSuccess':function(file,res,response){
                      var data = JSON.parse(res);
                      if(data.tips===undefined){
                          data.tips = '上传失败,data.tips返回为'+data.tips;
                      }
                       $('#album').append($('<div style="float:left;margin-right:5px;"><image style="width:150px; height:150px;" src="/image/get/'+data.imageId+'" /><a href="javascript:;"  onclick="$(this.parentElement).remove()">删除</a><input type="hidden" name="album[]" value="' + data.imageId+'"/></div>'));
                  }
             });
        });
    </script>
@endsection