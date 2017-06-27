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
    @if(isset($lists))
     <!-- 编辑 案例 -->
<div class="add-example">
<div class="container business-main">
    <ol class="breadcrumb">
      <li><a href="/innovate" class="red-font" target="_self">创库</a></li><li class="arrow"></li><li>上传案例</li>
    </ol>
    <h1>上传案例</h1>
    <form>
    <table>
    <tbody>
        <tr>
          <td>案例名称</td>
          <td colspan="4"><div class="input-box title"><input type="text" maxlength="30" value="{{$lists->caseName}}" id="examplename"><span class="now-w">0</span>/30</div></td>
        </tr>
        <tr>
          <td>案例分类</td>
          <td colspan="4"><ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex2">
              <a class="btn six-words" data-toggle="dropdown"><div class="input-result">@if(isset($categorys[$lists->caseTypeId])) {{$categorys[$lists->caseTypeId]}} @else 请选择 @endif</div><i></i></a>
              <ul class="dropdown-menu fenlei">
                  @if(isset($categorys))
                      @foreach($categorys as $key => $item)
                        <li><a data-id="{{$key}}">{{$item}}</a></li>
                      @endforeach
                 @endif
              </ul></li>
              <input type="hidden" id="sortID" value="{{$lists->caseTypeId}}">
              {{-- 获取案例分类ID --}}
        </ul></td>
        </tr>
        <tr>
          <td class="up-title">案例图片</td>
          <td colspan="4" class="upload_btn_box img">
              <a id="upload_btn"></a>
              <span class="tips">单个图片限制在1M以内，支持png，jpg，bmp图片格式</span>
              <input type="hidden" id="imgID">
              {{-- 接收图片json字符串 --}}
              <div class="successBox" data-id="{{$lists->coverId}}">
                  <i></i>
                  <div class="imgCon">
                      <img data-id="{{$lists->coverId}}" src="/image/get/{{$lists->coverId}}">
                  </div>
                  <a class="setting" role="button">设为封面</a>
                  <textarea class="describe">描述（20字以内）</textarea>
              </div>
            </td>
        </tr>
        <tr>
          <td class="up-title">上传附件</td>
          <td colspan="4" class="upload_btn_box file"><a id="upload_file_btn"></a><span class="tips">支持RAR\ZIP\PDF\DOC\DOCX\XLS\XLSX\PPT\PPTX格式文件，单个文件不超过1G；如上传多个附件，请压缩成一个附件上传，单个文件不超过1G</span>
          <input type="hidden" name="fileID" id="fileID" value="{{$lists->enclosure}}">
          {{-- 接收上传保留的文件ID --}}
          <p class="filename"></p>
          </td>
        </tr>
    </tbody>
    </table>
    <p class="ms">详细描述</p>
    {!!HTML::script('common/ueconfig.js') !!}<div id="editTxt"></div>
    <a class="btn publish" role="button">发布</a>
    <input type="hidden" id="editorContent">
    <input type="hidden" name="from" value="{{array_get($_GET, 'from', 1)}}">
    {{-- 存放富文本内容 --}}
    </form>
</div>
</div>
 @else
  <!--////////////////////// 添加案例 ///////////////////////-->
<div class="add-example">
    <div class="container business-main">
        <ol class="breadcrumb">
            <li><a href="/innovate" class="red-font" target="_self">创库</a></li><li class="arrow"></li><li>上传案例</li>
        </ol>
        <h1>上传案例</h1>
        <form>
            <table>
                <tbody>
                <tr>
                    <td>案例名称</td>
                    <td colspan="4"><div class="input-box title"><input type="text" maxlength="30" id="examplename"><span class="now-w">0</span>/30</div></td>
                </tr>
                <tr>
                    <td>案例分类</td>
                    <td colspan="4"><ul class="lem-drop lem-drop-input">
                            <li class="dropdown Zindex2">
                                <a class="btn six-words" data-toggle="dropdown"><div class="input-result">请选择</div><i></i></a>
                                <ul class="dropdown-menu fenlei">
                                    @if(isset($categorys))
                                        @foreach($categorys as $key => $item)
                                            <li><a data-id="{{$key}}">{{$item}}</a></li>
                                        @endforeach
                                    @endif
                                </ul></li>
                            <input type="hidden" id="sortID">
                            {{-- 获取案例分类ID --}}
                        </ul></td>
                </tr>
                <tr>
                    <td class="up-title">案例相册</td>
                    <td colspan="4" class="upload_btn_box img">
                        <a id="upload_btn"></a>
                        <span class="tips">单个图片限制在1M以内，支持png，jpg，bmp图片格式</span>
                        <input type="hidden" id="imgID">
                        {{-- 接收图片json字符串 --}}
                    </td>
                </tr>
                <tr>
                    <td class="up-title">上传附件</td>
                    <td colspan="4" class="upload_btn_box file"><a id="upload_file_btn"></a><span class="tips">支持RAR\ZIP\PDF\DOC\DOCX\XLS\XLSX\PPT\PPTX格式文件，单个文件不超过1G；如上传多个附件，请压缩成一个附件上传，单个文件不超过1G</span>
                        <input type="hidden" name="fileID" id="fileID">
                        {{-- 接收上传保留的文件ID --}}
                        <p class="filename"></p>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="ms">详细描述</p>
            {!!HTML::script('common/ueconfig.js') !!}<div id="editTxt"></div>
            <a class="btn publish" role="button">发布</a>
            <input type="hidden" id="editorContent">
            <input type="hidden" name="from" value="{{array_get($_GET, 'from', 1)}}">
            {{-- 存放富文本内容 --}}
        </form>
    </div>
</div>
@endif
    <input type="hidden" id="pass">
{{-- pass为1，可以发布，反之亦然 --}}
@endsection
@section('footer-scripts')
<script type="text/javascript">
    editor('editTxt')
</script>
@stop
