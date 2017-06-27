@extends('admin.adminbase')

@section('title', '新增版块')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增版块</h3>
        </div>
        <form action="<?= url('/backstage/travel/edit-category') ?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$detail['id']}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">版块名称</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control" value="{{$detail['name']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入版块名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">版块英文名称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control" value="{{$detail['nameEn']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入版块英文名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">层级</label>
                    <div class="col-sm-4">
                        <input name="level" type="text" class="form-control" value="{{$detail['level']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入层级</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">上传板块图标</label>
                    <div class="col-sm-4">
                        <input id="file_upload" name="file_upload"  type="file" multiple="true">
                        <input type="hidden" id="picKey" name="picKey" value="{{$detail['picKey']}}" />
                        <div class="col-sm-7 col-md-7" id="image">
                            <a href="#" class="thumbnail"  >
                                <image style="width:150px; height:150px;" src="/image/get/{{$detail['picKey']}}" />
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">上传板块图标</p>
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
                    $('#image').html('<a href="#" class="thumbnail"  ><image  src="/image/get/'+data.imageId+'" /></a>');
                    $('#picKey').val(data.imageId);
                }
            });
        });
    </script>
@endsection