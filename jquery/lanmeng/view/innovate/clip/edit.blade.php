@extends('layouts.main')

@section('banner')
@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="/uploadify/uploadify.css">
@endsection

@section('header-scripts')
    <script type="text/javascript" src="/common/ueditor/ueditor.parse.min.js"></script>
    <script type="text/javascript" src="/common/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/common/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/uploadify/jquery.uploadify-3.1.min.js"></script>
    <script type="text/javascript" src="/js/loongjoy.upload.js"></script>
@endsection

@section('content')
    <div class="add-clip">
        <div class="container business-main">
            <ol class="breadcrumb">
                <li><a href="/innovate" class="red-font" target="_self">创库</a></li><li class="arrow"></li><li>上传素材</li>
            </ol>
            <h1>上传素材</h1>
            <form>
                <table>
                    <tbody>
                    <tr>
                        <td>素材名称</td>
                        <td colspan="4"><div class="input-box title"><input type="text" name="materialName" maxlength="30" id="materialName" value="{{$materialList->materialName}}" ><span class="now-w">0</span>/30</div></td>
                    </tr>
                    <tr>
                        <td>品牌</td>
                        <td colspan="4"><ul class="lem-drop lem-drop-input">
                                <li class="dropdown Zindex3">
                                    <a class="btn six-words" data-toggle="dropdown"><div class="input-result">@if(isset($materialList->brandName) && !empty($materialList->brandName) ){{$materialList->brandName}}@else请选择@endif</div><i></i></a>
                                    <ul class="dropdown-menu brand">
                                        @if($brands)
                                            @foreach($brands as $key => $item)
                                                <li><a data-id='{{$key}}'>{{$item}}</a></li>
                                            @endforeach
                                        @endif
                                    </ul></li>
                                <input type="hidden" id="brandID" value="{{$materialList->brandId}}" >
                                {{-- 获取品牌ID --}}
                            </ul></td>
                    </tr>
                    <tr>
                        <td  class="up-title">车型</td>
                        <td colspan="4"><div class="car-type Zindex999 clear">
                                <div class="input-result">@if(count($carmodelSet)>1){{implode(',',$carmodelSet)}}@endif</div><i></i>
                                <ul class="car-type-box"></ul></div></td>
                    </tr>
                    <input type="hidden" id="carType" value="{{implode(',',$carmodelArr)}}" >
                    {{-- 获取车型ID --}}
                    <tr>
                        <td>分类</td>
                        <td colspan="4"><ul class="lem-drop lem-drop-input">
                                <li class="dropdown Zindex2">
                                    <a class="btn six-words" data-toggle="dropdown"><div class="input-result">@if(count($parentCategory)>0) {{$parentCategory['categoryName']}} @else 请选择 @endif </div><i></i></a>
                                    <ul class="dropdown-menu fenlei">
                                        @if(count($materialCategory)>0)
                                            @foreach($materialCategory as $key => $item)
                                                <li><a data-id={{$key}}>{{$item}}</a></li>
                                            @endforeach
                                        @endif
                                    </ul></li>
                                <input type="hidden" id="sortID" value="@if(count($parentCategory)>0) {{$parentCategory['categoryId']}} @endif" >
                                {{-- 获取一级分类ID --}}
                            </ul>
                            <div class="sub-fenlei-box" style=" @if(count($childrenCategory)>0) display: block @endif ">
                                <span class="sub-classic">子分类</span>
                                <ul class="lem-drop lem-drop-input">
                                    <li class="dropdown Zindex99">
                                        <a class="btn six-words" data-toggle="dropdown"><div class="input-result">@if(count($childrenCategory)>0) {{$childrenCategory['categoryName']}} @else 请选择 @endif</div><i></i></a>
                                        <ul class="dropdown-menu sub-fenlei">
                                        </ul></li>
                                    <input type="hidden" id="subsortID" value="@if(count($childrenCategory)>0) {{$childrenCategory['categoryId']}} @else 0 @endif">
                                    {{-- 获取二级分类ID --}}
                                </ul></div></td>
                    </tr>
                    <tr>
                        <td>积分</td>
                        <input type="hidden" id="materialId" value="{{ $id }}" />
                        <td colspan="4"><div class="input-box point"><input type="text" value="{{$materialList->integral}}" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " id="point"><span>0</span>/100</div></td>
                    </tr>
                    <tr>
                        <td class="up-title">上传图片</td>
                        <td colspan="4" class="upload_btn_box img">
                            <a id="upload_btn"></a>
                            <span class="tips">单个图片限制在1M以内，支持png，jpg，bmp图片格式</span>
                            <input type="hidden" id="imgID">
                            @if(count($imageArr)>0)
                                @foreach($imageArr as $key => $value)
                                <div class="successBox" data-id="{{$value}}">
                                    <i></i>
                                    <div class="imgCon">
                                        <img data-id="11462" src="/image/get/{{$value}}">
                                    </div>
                                    <textarea class="describe">@if(isset($describe[$key]['describle'])){{$describe[$key]['describle']}} @endif </textarea>
                                </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="up-title">上传附件</td>
                        <td colspan="4" class="upload_btn_box file"><a id="upload_file_btn"></a><span class="tips">支持RAR\ZIP\PDF\DOC\DOCX\XLS\XLSX\PPT\PPTX格式文件，单个文件不超过1G；如上传多个附件，请压缩成一个附件上传，单个文件不超过1G</span>
                            <input type="hidden" name="fileID" id="fileID" value="{{$materialList->id}}" >
                            {{-- 接收上传保留的文件ID --}}
                            <p class="filename">{{$materialList->realname}}</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p class="ms">详细描述</p>
                {!!HTML::script('common/ueconfig.js') !!}<textarea name="describle" id="editTxt">{{$materialList->describle}}</textarea>
                <a class="btn publish" role="button">发布</a>
                <input type="hidden" id="editorContent">
                <input type="hidden" name="from" value="{{array_get($_GET, 'from', 1)}}">
                {{-- 存放富文本内容 --}}
            </form>
        </div>
    </div>
    <input type="hidden" id="pass">
    {{-- pass为1，可以发布，反之亦然 --}}
@endsection

@section('footer-scripts')
    <script type="text/javascript">
        editor('editTxt');
    </script>
@stop
