@extends('admin.base')
@section('content')
    <style>
        .cellitem span {
            position: relative;
            float: left;
            padding: 3px 15px 3px 25px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #f4f4f4;
            cursor: pointer;
        }
        .cellitem span.active {
            background: #dd4b39;
            border-color: #d73925;
            color: #fff;
        }
        .cellitem span.active .fa {
            display: block;
        }
        .cellitem span .fa {
            display: none;
            position: absolute;
            top: 6px;
            left: 5px;
        }
        .selectedItem span {
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
            <h3 class="box-title">延展套餐</h3>
        </div>
        <div class="box-body">
            <form onsubmit="return false" method="post" class="form-horizontal">

                <div class="form-group">
                    <label for="" class="control-label col-sm-2">已选择</label>
                    <div class="col-sm-8 selectedItem">
                        @if(isset($details) && count($details) > 0)
                            @foreach($details as $detail)
                                @if($detail['rellationType'] == 1 || $detail['rellationType'] == 2)
                                <span data-relationId="{{$detail['rellationId']}}" data-relationType="{{$detail['rellationType']}}">{{$detail['info']['name']}}</span>
                                @elseif($detail['rellationType'] == 3 ||$detail['rellationType'] == 4 )
                                    <span data-relationId="{{$detail['rellationId']}}" data-relationType="{{$detail['rellationType']}}">{{$detail['info']['name']}}</span>
                                @endif
                            @endforeach
                        @endif

                    </div>
                    <input type="hidden" id="packageDetails" name="packageDetails" value="{{$map}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="selftype" value="{{ array_get($_GET, 'type')}}">
                    <input type="hidden" name="selftypeId" value="{{array_get($_GET, 'typeId') }}">
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">商品类型</label>
                    <div class="col-sm-10">
                        <select id="rellationType" name="rellationType" class="form-control" style="display: inline-block;width: auto;">
                            <option value="0">请选择类型</option>
                            <option value="1">商城商品</option>
                            <option value="2">团购商品</option>
                            <option value="3">车友汇</option>
                            <option value="4">创意设计</option>
                        </select>
                        <select id="categoryId1" name="categoryId1" class="form-control" style="display: inline-block;width: auto;">
                            <option value="0">请选择分类</option>
                        </select>
                        {{--<select id="categoryId2" name="categoryId2" class="form-control" style="display: inline-block;width: auto;">--}}
                        {{--</select>--}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-sm-2">可选商品</label>
                    <div class="col-sm-8 cellitem commodity">

                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-2">
                        <button type="submit" onclick="store()" class="btn btn-primary">确定</button>
                        <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
{!!HTML::script('webuploader/test/jquery-1.10.1.min.js') !!}
{!!HTML::script('webuploader/dist/webuploader.js') !!}
{!!HTML::style("webuploader/dist/webuploader.css") !!}


<script type="text/javascript">
    var dataType = "<?php echo $_GET['type'] ?>";
    $(function () {
        var selftype = $('input[name="selftype"]').val();
        var selftypeId = $('input[name="selftypeId"]').val();
        // 拉取分类
        $('#rellationType').on('change', function () {
            var type = $(this).val();
            if (type == null || type == 0) return;
            $.ajax({
                type: "GET",
                url:"/superman/mall/packagecategory",
                data:{'type':type,'_token':'{{csrf_token()}}'},
                dataType: 'json',
                success: function(msg) {
                    if (msg.status == 0){
                        $("#categoryId1").data('type', type);
                        var html = '<option value="0">请选择分类</option>';
                        for(var i=0;i<msg['content']['categories'].length;i++){
                            if (type == 1) {
                                html += '<option value="'+msg['content']['categories'][i]['id']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                            } else if(type == 2){
                                html += '<option value="'+msg['content']['categories'][i]['id']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                            }else if(type == 3){
                                html += '<option value="'+msg['content']['categories'][i]['type']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                            }else if(type == 4){
                                html += '<option value="'+msg['content']['categories'][i]['id']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                            }
                        }
                        $("#categoryId1").html(html);
                    }
                }
            });
        });

        $('#categoryId1').on('change', function () {

            var type = $(this).data('type'), val = $(this).val();
            if (type == undefined || type == 0) return;
            if (type == 1 && val>0){
                $.ajax({
                    type: "GET",
                    url:"/superman/mall/packagecategory",
                    data:{'type':type,'parentId':val,'_token':'{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(msg) {
                        if (msg.status == 0){
                            var html = '<select id="categoryId2" name="categoryId2" class="form-control" style="display: inline-block;width: auto;">'
                            html += '<option value="0">请选择分类</option>';
                            for(var i=0;i<msg['content']['categories'].length;i++){
                                html += '<option value="'+msg['content']['categories'][i]['id']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                            }
                            html += '</select>';
                            if ($("#categoryId2")) $("#categoryId2").remove();
                            $("#categoryId1").after(html);
                            $('#categoryId2').on('change', function () {
                                var detail = $('#packageDetails').val();
                                detail = detail? detail:null;
                                var type = $('#categoryId1').data('type'), val = $(this).val(),packageDetails = $.parseJSON(detail);
                                $.ajax({
                                    type: "GET",
                                    url:"/superman/mall/packagecommodity",
                                    data:{'type':type,'categoryId':val,'_token':'{{csrf_token()}}'},
                                    dataType: 'json',
                                    success: function(msg) {
                                        if (msg.status == 0){
                                            var html = '';
                                            for(var i=0;i<msg['content']['commodities'].length;i++){
                                                var classStr = '', typeId=msg['content']['commodities'][i]['id'];
                                                var typeMap = [type, typeId].join(',');
                                                if (!(type == selftype && typeId==selftypeId)){
                                                    if (packageDetails &&  $.inArray(typeMap, packageDetails) != -1) classStr = 'class="active"';
                                                    html += '<span '+classStr+' data-relationType='+type+' data-relationId="' + typeId + '">' + msg['content']['commodities'][i]['name'] + '<i class="fa fa-check"></i></span>';
                                                }
                                            }
                                            $('.cellitem.commodity').html(html);
                                            $('.cellitem span').click(function () {process($(this))});
                                        }
                                    }
                                });

                            });
                        }
                    }
                });
            }else if (type == 4 && val>0){
                $.ajax({
                    type: "GET",
                    url:"/superman/mall/packagecategory",
                    data:{'type':type,'parentId':val,'_token':'{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(msg) {
                        if (msg.status == 0){
                            var html = '<select id="categoryId2" name="categoryId2" class="form-control" style="display: inline-block;width: auto;">'
                            html += '<option value="0">请选择分类</option>';
                            for(var i=0;i<msg['content']['categories'].length;i++){
                                html += '<option value="'+msg['content']['categories'][i]['id']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                            }
                            html += '</select>';
                            if ($("#categoryId2")) $("#categoryId2").remove();
                            $("#categoryId1").after(html);
                            $('#categoryId2').on('change', function () {
                                var detail = $('#packageDetails').val();
                                detail = detail? detail:null;
                                var type = $('#categoryId1').data('type'), val = $(this).val(),packageDetails = $.parseJSON(detail);
                                $.ajax({
                                    type: "GET",
                                    url:"/superman/mall/packagecommodity",
                                    data:{'type':type,'categoryId':val,'_token':'{{csrf_token()}}'},
                                    dataType: 'json',
                                    success: function(msg) {
                                        if (msg.status == 0){
                                            var html = '';
                                            for(var i=0;i<msg['content']['commodities'].length;i++){
                                                var classStr = '', typeId=msg['content']['commodities'][i]['id'];
                                                var typeMap = [type, typeId].join(',');
                                                if (!(type == selftype && typeId==selftypeId)){
                                                    if (packageDetails &&  $.inArray(typeMap, packageDetails) != -1) classStr = 'class="active"';
                                                    html += '<span '+classStr+' data-relationType='+type+' data-relationId="' + typeId + '">' + msg['content']['commodities'][i]['name'] + '<i class="fa fa-check"></i></span>';
                                                }
                                            }
                                            $('.cellitem.commodity').html(html);
                                            $('.cellitem span').click(function () {process($(this))});
                                        }
                                    }
                                });

                            });
                        }
                    }
                });
            }else if (type == 4 && val>0){
                $.ajax({
                    type: "GET",
                    url:"/superman/mall/packagecategory",
                    data:{'type':type,'parentId':val,'_token':'{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(msg) {
                        if (msg.status == 0){
                            var html = '<select id="categoryId2" name="categoryId2" class="form-control" style="display: inline-block;width: auto;">'
                            html += '<option value="0">请选择分类</option>';
                            for(var i=0;i<msg['content']['categories'].length;i++){
                                html += '<option value="'+msg['content']['categories'][i]['categoryId']+'" >'+msg['content']['categories'][i]['name']+'</option>';
                            }
                            html += '</select>';
                            if ($("#categoryId2")) $("#categoryId2").remove();
                            $("#categoryId1").after(html);
                            $('#categoryId2').on('change', function () {
                                var detail = $('#packageDetails').val();
                                detail = detail? detail:null;
                                var type = $('#categoryId1').data('type'), val = $(this).val(),packageDetails = $.parseJSON(detail);
                                $.ajax({
                                    type: "GET",
                                    url:"/superman/mall/packagecommodity",
                                    data:{'type':type,'categoryId':val,'_token':'{{csrf_token()}}'},
                                    dataType: 'json',
                                    success: function(msg) {
                                        if (msg.status == 0){
                                            var html = '';
                                            for(var i=0;i<msg['content']['commodities'].length;i++){
                                                var classStr = '', typeId=msg['content']['commodities'][i]['creativeId'];
                                                var typeMap = [type, typeId].join(',');
                                                if (!(type == selftype && typeId==selftypeId)){
                                                    if (packageDetails &&  $.inArray(typeMap, packageDetails) != -1) classStr = 'class="active"';
                                                    html += '<span '+classStr+' data-relationType='+type+' data-relationId="' + typeId + '">' + msg['content']['commodities'][i]['commodityName'] + '<i class="fa fa-check"></i></span>';
                                                }
                                            }
                                            $('.cellitem.commodity').html(html);
                                            $('.cellitem span').click(function () {process($(this))});
                                        }
                                    }
                                });

                            });
                        }
                    }
                });
            } else {
                $.ajax({
                    type: "GET",
                    url:"/superman/mall/packagecommodity",
                    data:{'type':type,'categoryId':val,'_token':'{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(msg) {
                        if (msg.status == 0){
                            var detail = $('#packageDetails').val();
                            detail = detail? detail:null;
                            var html = '', packageDetails = $.parseJSON(detail);
                            for(var i=0;i<msg['content']['commodities'].length;i++){
                                var classStr = '', typeId='';
                                if (type == 1) {
                                    typeId = msg['content']['commodities'][i]['id'];
                                    typeMap = [type, typeId].join(',');
                                    if (!(type == selftype && typeId==selftypeId)){
                                        if (packageDetails &&  $.inArray(typeMap, packageDetails) != -1) classStr= 'class="active"';
                                        html += '<span '+classStr+' data-relationType='+type+' data-relationId="' + typeId + '">' + msg['content']['commodities'][i]['name'] + '<i class="fa fa-check"></i></span>';
                                    }

                                } else if (type == 2) {
                                    typeId = msg['content']['commodities'][i]['id'];
                                    typeMap = [type, typeId].join(',');
                                    if (!(type == selftype && typeId==selftypeId)){
                                        if (packageDetails &&  $.inArray(typeMap, packageDetails) != -1) classStr= 'class="active"';
                                        html += '<span  '+classStr+'  data-relationType='+type+'  data-relationId="' + typeId + '">' + msg['content']['commodities'][i]['name'] + '<i class="fa fa-check"></i></span>';
                                    }
                                } else if (type == 3) {
                                    typeId = msg['content']['commodities'][i]['id'];
                                    typeMap = [type, typeId].join(',');
                                    if (!(type == selftype && typeId==selftypeId)){
                                        if (packageDetails &&  $.inArray(typeMap, packageDetails) != -1) classStr= 'class="active"';
                                        html += '<span   '+classStr+'  data-relationType='+type+' data-relationId="' + typeId + '">' + msg['content']['commodities'][i]['name'] + '<i class="fa fa-check"></i></span>';
                                    }
                                } else if (type == 4) {
                                    typeId = msg['content']['commodities'][i]['id'];
                                    typeMap = [type, typeId].join(',');
                                    if (!(type == selftype && typeId==selftypeId)){
                                        if (packageDetails &&  $.inArray(typeMap, packageDetails) != -1) classStr= 'class="active"';
                                        html += '<span   '+classStr+' data-relationType='+type+'  data-relationId="' + msg['content']['commodities'][i]['id'] + '">' + msg['content']['commodities'][i]['name'] + '<i class="fa fa-check"></i></span>';
                                    }
                                }

                            }
                            if ($("#categoryId2")) $("#categoryId2").remove();
                            $('.cellitem.commodity').html(html);
                            $('.cellitem span').click(function () {process($(this))});
                        }
                    }
                });
            }
        });



        function process(dataObj)
        {
            var id = $(dataObj).attr('data-relationId'), type=$(dataObj).attr('data-relationType');
            if ($(dataObj).hasClass('active')) {
                $.each($('.selectedItem span'), function () {
                    var _id = $(this).attr('data-relationId');
                    var _type = $(this).attr('data-relationType');
                    if (id == _id && type==_type) $(this).remove();
                });
            } else {
                $('.selectedItem').append('<span data-relationId="' + id + '" data-relationType="' + type + '"  ' +  '">' + $(dataObj).text() + '</span>');
            }
            $(dataObj).toggleClass('active');
            var v = [];
            $.each($('.selectedItem span'), function () {
                returnId = $(this).attr('data-relationId');
                returnType = $(this).attr('data-relationType');
                v.push([returnType,returnId].join(','));
            });
            $('#packageDetails').val(JSON.stringify(v));
        }
    });


    function store()
    {
        var selftype = $('input[name="selftype"]').val();
        var selftypeId = $('input[name="selftypeId"]').val();
        $.ajax({
            type: "POST",
            url:"/superman/mall/savepackage",
            data:{'type':selftype,'typeId':selftypeId,'packageDetails':$('#packageDetails').val(), '_token':'{{csrf_token()}}'},
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
    function reload()
    {
        if(dataType == 4){
            location.href = '/superman/creativeproduct/index';
        }else{
            location.href = '/superman/mall/list';
        }
    }
</script>






