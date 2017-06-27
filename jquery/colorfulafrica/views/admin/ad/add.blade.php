@extends('admin.adminbase')

@section('title', '新增广告管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增广告管理</h3>
        </div>
        <form action="<?= url('/backstage/adinfo/add-ad') ?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">广告名称</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入广告名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">英文广告名称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入英文广告名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">所属模块</label>
                    <div class="col-sm-2">
                        <select name="type" id="cate" class="form-control">
                            <option value="">---请选择---</option>
                            @foreach($cate as $key=>$cate)
                            <option value="{{$key}}">{{$cate}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="info"></div>
                <div class="form-group" id="link">
                    <label for="username" class="control-label col-sm-2 ">跳转链接</label>
                    <div class="col-sm-4">
                        <input name="link" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入跳转链接</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">上传广告图</label>
                    <div class="col-sm-4">
                        <input id="file_upload" name="file_upload"  type="file" multiple="true">
                        <input type="hidden" id="picKey" name="picKey" />
                        <div id="image"></div>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请上传讯缩略图</p>
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
                 // 'buttonImage': '/img/admin/add-photo-multi.png',
                 'auto'          : true,
                 'multi'         : false,
                 'fileTypeExts'  :  '*.gif;*.jpg;*.jpeg;*.png',
                 'fileSizeLimit' : '4092MB',
                  'onUploadSuccess':function(file,res,response){
                      var data = JSON.parse(res);
                      if(data.tips===undefined){
                          data.tips = '上传失败,data.tips返回为'+data.tips;
                      }
                      $('#image').html('<a href="#" class="thumbnail" ><image style="width:150px; height:150px;" src="/image/get/'+data.imageId+'" /></a>');
                      $('#picKey').val(data.imageId);
                  }
             });
            var info=$('#info');
            $('#cate').on('change',function () {
                if($(this).val()==7){
                    info.css('display','none');
                    return;   
                }
                var optionStr='<div class="form-group"><label for="username" class="control-label col-sm-2 required">详情</label> <div class="col-sm-2"> <select name="resourceId" class="form-control"> <option value="">---请选择---</option>';
                $.post('/backstage/adinfo/info-list',{"type":$(this).val()},function (res) {
                    if(res.status==1){
                        var list=res.list;
                        $.each(list,function (key) {
                            optionStr+='<option value=' +list[key].id+'>' +list[key].name +'</option>';
                        });
                        optionStr+='</select></div>';
                        info.css('display','block');
                        info.html(optionStr);
                    }
                },'json');
            });
        });
    </script>
@endsection