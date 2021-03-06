@extends('admin.adminbase')
@section('title', '编辑游记')
@section('content')

    <style>
        /*  .cellitem span {
              position: relative;
              float: left;
              padding: 3px 15px 3px 25px;
              margin: 10px;
              border: 1px solid #ddd;
              background: #f4f4f4;
              cursor: pointer;
          } */
        span.tag {
            background: #dd4b39;
            border-color: #d73925;
            color: #fff;
        }
        /*   .cellitem span.active .fa {
               display: block;
           }
           .cellitem span .fa {
               display: none;
               position: absolute;
               top: 6px;
               left: 5px;
           } */
        span.tag {
            position: relative;
            float: left;
            padding: 3px 15px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #dd4b39;
            cursor: pointer;
        }
    </style>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">编辑游记</h3>
        </div>
        <form action="<?= url('/backstage/travel/edit-travel') ?>" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$detail['id']}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">所属板块</label>
                    <div class="col-sm-3">
                        <select name="categoryId" class="form-control" >
                            @foreach($categories as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">所属国家</label>
                    <div class="col-sm-3">
                        <select name="countryId" class="form-control" >
                            @foreach($countryKV as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">游记标题</label>
                    <div class="col-sm-4">
                        <input name="name" id="name" type="text" class="form-control"  value="{{$detail['name']}}" >
                    </div>
                </div>
              <!--  <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">发布者昵称</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control"  value="{{$detail['nickname']}}" >
                    </div>
                </div> -->
              <!--  <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">发布时间</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control"  value="{{--$detail['createTime']--}}" >
                    </div>
                </div>  -->
              <!--  <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">游记标签</label>
                    <div class="col-sm-4">
                        @if(isset($detail['tags']) && count($detail['tags']))
                            @foreach($detail['tags'] as $item)
                                <span class="tag" >{{$item['name']}}</span>
                            @endforeach
                        @else
                            <span class="tag" >无</span>
                        @endif
                    </div>
                </div> -->
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">缩略图</label>
                    <div class="col-sm-4">
                         <input id="file_upload" name="file_upload" class="btn btn-primary"  type="file" multiple="true">
                         <input type="hidden" id="picKey" name="picKey" />
                        <div id="image"><image style="width:150px; height:150px;" src="/image/get/{{$detail['picId']}}" /></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2">线路摘要</label>
                    <div class="col-sm-4">
                        <textarea name="summary" rows="5"  class="form-control" >{{$detail['summary']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 ">详细图文</label>
                    <div class="col-sm-8">
                        <textarea name="detail"  id="container"  >{{$detail['detail']}}</textarea>
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