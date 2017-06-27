@extends('admin.adminbase')

@section('title', '新增门店介绍')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增门店介绍</h3>
        </div>
        <form action="<?=url('/backstage/commodity/edit-mall')?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$detail['id']}}">
            <input type="hidden" name="start" value="{{Input::get('start',0)}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">门店名称</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control" value="{{$detail['name']}}">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入门店名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">英文门店名称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control" value="{{$detail['nameEn']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入英文门店名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">联系电话</label>
                    <div class="col-sm-4">
                        <input name="telephone" type="text" class="form-control" value="{{$detail['telephone']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入联系电话</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">邮箱</label>
                    <div class="col-sm-4">
                        <input name="mail" type="text" class="form-control" value="{{$detail['mail']}}">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入邮箱</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">地址</label>
                    <div class="col-sm-4">
                        <input name="address" type="text" class="form-control" value="{{$detail['address']}}" >
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入地址</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">缩略图</label>
                    <div class="col-sm-4">
                        <input id="file_upload" name="file_upload"  type="file" multiple="true">
                        <input type="hidden" id="picKey" name="picKey" value="{{$detail['picKey']}}" />
                        <div id="image"><image style="width:150px; height:150px;" src="/image/get/{{$detail['picKey']}}" /></div>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请上传缩略图</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">图文描述</label>
                    <div class="col-sm-8">
                        <textarea name="detail" type="password" id="container" >{{$detail['detail']}}</textarea>
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
                    $('#image').html('<image style="width:150px; height:150px;" src="/image/get/'+data.imageId+'" />');
                    $('#picKey').val(data.imageId);
                }
            });
        });
    </script>
@endsection