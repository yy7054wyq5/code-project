@extends('admin.adminbase')

@section('title', '新增合作伙伴')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增合作伙伴</h3>
        </div>
        <form action="/backstage/partner/add-partner" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">所属分类</label>
                    <div class="col-sm-4">
                        <select name="categoryId" class="form-control" >
                            @if(count($categories)>0)
                                @foreach($categories as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请选择分类</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="country" class="control-label col-sm-2">所属国家</label>
                    <div class="col-sm-4">
                        <select name="countryId" class="form-control" >
                            <option value="">请选择</option>
                            @if(count($country)>0)
                                @foreach($country as  $value)
                                    <option value="{{$value['id']}}">{{$value['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请选择所属国家</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">名称</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入合作伙伴名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">英文名称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" id="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入合作伙伴英文名称</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">电话</label>
                    <div class="col-sm-4">
                        <input name="telephone" id="telephone" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入电话</p>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">网址</label>
                    <div class="col-sm-4">
                        <input name="link"  type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入网址</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">手机</label>
                    <div class="col-sm-4">
                        <input name="mobile"  type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入手机</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">传真</label>
                    <div class="col-sm-4">
                        <input name="tax"  type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入传真</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">邮箱</label>
                    <div class="col-sm-4">
                        <input name="email"  type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入邮箱</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">营业时间</label>
                    <div class="col-sm-2">
                        <input name="openBegin" id="openBegin" type="text" class="form-control Wdate" onclick="WdatePicker({dateFmt:'HH:mm'})" placeholder="开始营业时间" >
                    </div>
                    <div class="col-sm-2">
                        <input name="openEnd" id="openEnd"  type="text" class="form-control Wdate"  onclick="WdatePicker({dateFmt:'HH:mm'})" placeholder="截止营业时间" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">缩略图</label>
                    <div class="col-sm-4">
                        <input id="file_upload" name="file_upload"  type="file" multiple="true">
                        <div id="image"></div>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请上传缩略图</p>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">相册</label>
                    <div class="col-sm-5">
                        <input id="album_upload" name="album_upload"  type="file" multiple="true">
                        <div id="album"></div>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static text-muted small">一次可选择多个图片</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">合作伙伴地址</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="address" ></textarea>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入合作伙伴地址</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">详情</label>
                    <div class="col-sm-8">
                        <textarea name="detail"  id="container" ></textarea>
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
                      $('#image').html('<image style="width:150px; height:150px;" src="/image/get/'+data.imageId+' " /><input type="hidden" name="picKey" value="'+ data.imageId + ' " />');
                      $('#picKey').val(data.imageId);
                  }
             });
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