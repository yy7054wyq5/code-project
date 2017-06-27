@extends('admin.adminbase')

@section('title', '新增国家')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">查看/编辑国家</h3>
        </div>
        <form action="{{url('/backstage/country/edit-country')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$base['id']}}">
            <input type="hidden" name="start" value="{{Input::get('start',0)}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">基础数据</a></li>
                    <li><a href="#play" data-toggle="tab">玩转非洲</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="home">

                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">国家名称</label>
                            <div class="col-sm-4">
                                <input name="base[name]" id="name" type="text" class="form-control" value="{{$base['name']}}">
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入国家名称</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">英文国家名称</label>
                            <div class="col-sm-4">
                                <input name="base[nameEn]" type="text" class="form-control" value="{{$base['nameEn']}}" >
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入英文国家名称</p>
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-2 required">上传缩略图</label>
                                <div class="col-sm-4">
                                    <input id="file_upload_1" name="file_upload"  type="file">
                                    <input type="hidden" id="picKey_1" name="base[picKey]" />
                                    <div id="image_1"></div>
                                </div>
                                <div class="col-sm-6">
                                    <p class="form-control-static text-muted small">请上传缩略图</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="control-label col-sm-2 required">简介</label>
                                <div class="col-sm-4">
                                    <textarea name="base[describe]" class="form-control"  ></textarea>
                                </div>
                               <div class="col-sm-6">
                                    <p class="form-control-static text-muted small">请输入简介,长度不超过200个字符</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="control-label col-sm-2 required">英文简介</label>
                                <div class="col-sm-4">
                                    <textarea name="base[describeEn]" class="form-control"  ></textarea>
                                </div>
                               <div class="col-sm-6">
                                    <p class="form-control-static text-muted small">请输入英文简介,长度不超过200个字符</p>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">国家图文详情</label>
                            <div class="col-sm-8">
                                <textarea id="container"  name="base[detail]" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="play">
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">标题</label>
                            <div class="col-sm-4">
                                <input name="play[name]" id="name" type="text" class="form-control" value="{{isset($play)?$play['name']:''}}" >
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入标题</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">英文标题</label>
                            <div class="col-sm-4">
                                <input name="play[nameEn]" id="name" type="text" class="form-control" value="{{isset($play)?$play['nameEn']:''}}" >
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入英文标题</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">上传缩略图</label>
                            <div class="col-sm-4">
                                <input id="file_upload" name="file_upload"  type="file" multiple="true">
                                <input type="hidden" id="picKey" name="play[picKey]" value="{{isset($play)?$play['picKey']:''}}" />
                                <div id="image"> @if(isset($play['picKey']))<img src="/image/get/{{isset($play)?$play['picKey']:''}}" style="width:100px;height:100px" alt="">@endif</div>
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请上传缩略图</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">简介</label>
                            <div class="col-sm-4">
                                <textarea name="play[describe]"  class="form-control" >{{isset($play)?$play['describe']:''}}</textarea>
                            </div>
                            <div class="col-sm-6">
                                    <p class="form-control-static text-muted small">请输入简介,长度不超过30个字符</p>
                                </div>
                        </div>

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
            $('#file_upload_1').uploadify({
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
                    $('#image_1').html('<image style="width:150px; height:150px;" src="/image/get/'+data.imageId+'" />');
                    $('#picKey_1').val(data.imageId);
                }
            });
        });
    </script>
@endsection