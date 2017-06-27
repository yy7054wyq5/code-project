@extends('admin.adminbase')
@section('title', '编辑美食分类')
@section('content')
    <style>
        .cellitem  {
            position: relative;
            float: left;
            padding: 3px 15px 3px 25px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #f4f4f4;
            cursor: pointer;
        }
        .cellitemStrategy  {
             position: relative;
             float: left;
             padding: 3px 15px 3px 25px;
             margin: 10px;
             border: 1px solid #ddd;
             background: #f4f4f4;
             cursor: pointer;}
        .cellitemPartners {
            position: relative;
            float: left;
            padding: 3px 15px 3px 25px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #f4f4f4;
            cursor: pointer;
        }
         span.active {
            background: #dd4b39;
            border-color: #d73925;
            color: #fff;
        }
        .cellitem  .active .fa {
            display: block;
        }
        .cellitemStrategy .active .fa{
            display: block;
        }
        .cellitemPartners .active .fa {
            display: block;
        }
        .cellitem  .fa {
            display: none;
            position: absolute;
            top: 6px;
            left: 5px;
        }
        .cellitemStrategy .fa{
            display: none;
            position: absolute;
            top: 6px;
            left: 5px;
        }
        .cellitemPartners .fa {
            display: none;
            position: absolute;
            top: 6px;
            left: 5px;
        }
         .cellitem {
             position: relative;
             float: left;
             padding: 3px 15px;
             margin: 10px;
             border: 1px solid #ddd;
             background: #f4f4f4;
             cursor: pointer;
         }
        .cellitemStrategy {
            position: relative;
            float: left;
            padding: 3px 15px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #f4f4f4;
            cursor: pointer;
        }
         .cellitemPartners {
            position: relative;
            float: left;
            padding: 3px 15px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #f4f4f4;
            cursor: pointer;
        }
    </style>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增美食</h3>
        </div>
        <form action="{{url('/backstage/food/add-foods')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                    <!-- 错误提示 -->
                    <div class="alert alert-danger errMsgBox">
                        <button class="close">&times;</button>
                        <div class="result"></div>
                    </div>
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#base" data-toggle="tab">基础数据</a>
                    </li>
                    <li><a href="#commenity"  data-toggle="tab">关联商品</a></li>
                    <li><a href="#strategy"  data-toggle="tab">关联游记</a></li>
                    <li><a href="#partner"  data-toggle="tab">关联合作伙伴</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="base">
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">美食分类</label>
                            <div class="col-sm-4">
                                <select name="categoryId" class="form-control" >
                                    @foreach($category as $item)
                                        <option value="{{$item['id']}}" >{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请选择美食分类</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">国家</label>
                            <div class="col-sm-4">
                                <select name="countryId" class="form-control" >
                                    @foreach($countries as $key => $value)
                                        <option value="{{$key}}" >{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请选择美食分类</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">美食名称</label>
                            <div class="col-sm-4">
                                <input name="name" id="name" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入美食名称</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">英文美食名称</label>
                            <div class="col-sm-4">
                                <input name="nameEn" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入英文美食名称</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">美食简介</label>
                            <div class="col-sm-4">
                                <input name="summary" id="summary" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入美食简介</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">英文美食简介</label>
                            <div class="col-sm-4">
                                <input name="summaryEn" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入英文美食简介</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">美食缩略图</label>
                            <div class="col-sm-4">
                                <input id="file_upload" name="file_upload"  type="file" multiple="true">
                                <input type="hidden" id="picKey" name="picKey" />
                                <div class="col-sm-7 col-md-7" id="image"  ></div>
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请上传美食缩略图</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">美食图文详情</label>
                            <div class="col-sm-8">
                                <textarea id="container"  name="detail" ></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="commenity">
                        <p>
                            <div class="form-group">
                                <label for="username" class="control-label col-sm-2">已选择</label>
                                <div class="col-sm-6 selectedItemCommenity" ></div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="control-label col-sm-2">可选商品</label>
                                <div class="col-sm-6" id="optional-product" ></div>
                            </div>
                        </p>
                    </div>
                    <div class="tab-pane fade" id="strategy">
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2">已选择</label>
                            <div class="col-sm-6 selectedItemStrategy" ></div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2">可选游记</label>
                            <div class="col-sm-6" id="optional-strategy" ></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="partner">
                          <p>
                            <div class="form-group">
                                <label for="username" class="control-label col-sm-2">已选择</label>
                                <div class="col-sm-6 selectedItemPartners " ></div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="control-label col-sm-2">可选合作伙伴</label>
                                <div class="col-sm-6"  id="optional-partners" ></div>
                            </div>
                         </p>
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
                      $('#image').html('<a href="#" class="thumbnail" ><image style="width:150px; height:150px;" src="/image/get/'+data.imageId+'" /></a>');
                      $('#picKey').val(data.imageId);
                  }
             });

                $.ajax({
                    type: "GET",
                    url:"/backstage/food/commoditys",
                    data:{'start':0,'pageCount':10},
                    dataType: 'json',
                    success: function(msg) {
                       if (msg['success']) {
                           var html = '';
                           for (var i = 0; i < msg['commoditys'].length; i++) {
                               var classStr = 'class=cellitem';
                               html += '<span ' + classStr + ' commodity-id='+msg['commoditys'][i]['id']+' >' + msg['commoditys'][i]['name'] + '<i class="fa fa-check"></i></span>';
                           }
                       }
                       $('#optional-product').html(html);
                       $('.cellitem').click(function () {process_commenity($(this))});
                    }
                });
            $.ajax({
                type: "GET",
                url:"/backstage/food/strategy",
                data:{'start':0,'pageCount':10},
                dataType: 'json',
                success: function(msg) {
                    if (msg['success']) {
                        var html = '';
                        for (var i = 0; i < msg['strategy'].length; i++) {
                            var classStr = "class=cellitemStrategy";
                            html += '<span ' + classStr + ' travel-id='+msg['strategy'][i]['id']+' >' + msg['strategy'][i]['name'] + '<i class="fa fa-check"></i></span>';
                        }
                    }
                    $('#optional-strategy').html(html);
                    $('.cellitemStrategy').click(function () {process_travel($(this))});
                }
            });
                $.ajax({
                    type: "GET",
                    url:"/backstage/food/partners",
                    data:{'start':0,'pageCount':10},
                    dataType: 'json',
                    success: function(msg) {
                        if (msg['success']) {
                            var html = '';
                            for (var i = 0; i < msg['partners'].length; i++) {
                                var classStr = 'class=cellitemPartners';
                                html += '<span ' + classStr + ' commodity-id='+msg['partners'][i]['id']+' >' + msg['partners'][i]['name'] + '<i class="fa fa-check"></i></span>';
                            }
                        }
                        $('#optional-partners').html(html);
                        $('.cellitemPartners').click(function () {process_partners($(this))});
                    }
                });

            /**
             *  合作伙伴
             * @param dataObj
             */
            function process_partners(dataObj)
            {
                var id = $(dataObj).attr('commodity-id');
                var count = 0;
                $(dataObj).addClass('active');
                $.each($('.selectedItemPartners span'), function () {
                    var _id = $(this).attr('commodity-id');
                    if (id == _id || $('.selectedItemPartners span').lenght >= 5) $(this).remove();
                });
                $('.selectedItemPartners').append('<span class="cellitemPartners" onclick="del(this)" commodity-id="' + id +  '"><input type="hidden" name="partners[]" value="'+ id +'" />' + $(dataObj).text() + '</span>');
            }

            /**
             *  游记
             * @param dataObj
             */
            function process_travel(dataObj)
            {
                var id = $(dataObj).attr('travel-id');
                var count = 0;
                $(dataObj).addClass('active');
                $.each($('.selectedItemStrategy span'), function () {
                    var _id = $(this).attr('travel-id');
                    if (id == _id || $('.selectedItemStrategy span').lenght >= 5) $(this).remove();
                });
                $('.selectedItemStrategy').append('<span class="cellitemStrategy"  onclick="del(this)" travel-id="' + id +  '"><input type="hidden" name="travel[]" value="'+ id +'" />' + $(dataObj).text() + '</span>');
            }
            /**
             *  商品
             * @param dataObj
             */
            function process_commenity(dataObj)
            {
                var id = $(dataObj).attr('commodity-id');
                $(dataObj).addClass('active');
                $.each($('.selectedItemCommenity span'), function () {
                    var _id = $(this).attr('commodity-id');
                    if (id == _id  ||  $('.selectedItemCommenity span').length >= 5 ) $(this).remove();
                });
                $('.selectedItemCommenity').append('<span class="cellitem" onclick="del(this)" commodity-id="'+ id +'"><input type="hidden" name="commenity[]" value="'+ id +'" />' + $(dataObj).text() + '</span>');
            }
        });
        function del(obj){
            var $this=$(obj);
                $this.remove();
        }
    </script>
@endsection