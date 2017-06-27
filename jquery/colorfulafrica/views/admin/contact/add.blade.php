@extends('admin.adminbase')

@section('title', '新增文章')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增文章</h3>
        </div>
        <form action="{{url('/backstage/contact/add-article')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">标题</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">英文标题</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入英文标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">图文描述</label>
                    <div class="col-sm-8">
                        <textarea name="describe" type="password" id="container" ></textarea>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认添加</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        <?php $timestamp = time();?>
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
                      $('#image').html('<image style="width:150px; height:150px;" src="/image/get/'+data.imageId+'" />');
                      $('#picKey').val(data.imageId);
                  }
             });
        });
    </script>
@endsection