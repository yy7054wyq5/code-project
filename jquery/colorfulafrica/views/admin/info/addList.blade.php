@extends('admin.adminbase')

@section('title', '添加资讯')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">添加资讯</h3>
        </div>
        <form action="/backstage/adinfo/add-info" class="form-horizontal" method="post" m-bind="ajax">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">资讯标题</label>
                    <div class="col-sm-4">
                        <input name="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入资讯标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">英文资讯标题</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入英文资讯标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">资讯简短描述</label>
                    <div class="col-sm-4">
                        <input name="summary" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">资讯简短描述,长度不超过150个字符</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">国家</label>
                    <div class="col-sm-2">
                        <select name="countryId" id="" class="form-control">
                            <option value="0">请选择</option>
                            @foreach(\App\Http\Controllers\Admin\BaseController::getCountry() as $country)
                            <option value="{{$country['id']}}">{{$country['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请选择资讯所属国家</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">资讯缩略图</label>
                        <div class="col-sm-4">
                            <input id="file_upload" name="file_upload"  type="file" multiple="true">
                            <input type="hidden" id="picKey" name="picKey" />
                            <div id="image"></div>
                        </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请上传资讯缩略图</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">资讯图文</label>
                    <div class="col-sm-8">
                        <textarea name="detail" type="password" id="container" ></textarea>
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