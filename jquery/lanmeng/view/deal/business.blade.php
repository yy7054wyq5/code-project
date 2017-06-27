@extends('layouts.main')

@section('banner')
@stop

@section('header-scripts')
<script type="text/javascript" src="/common/ueditor/ueditor.parse.min.js"></script>
<script type="text/javascript" src="/common/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/common/ueditor/ueditor.all.min.js"></script>
<script language="javascript" type="text/javascript" src="/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/js/loongjoy.upload.js"></script>
@endsection
@section('content')
<div class="business-main deal">
<div class="container sell">
    <ol class="breadcrumb">
      <li><a href="/deal" class="red-font" target="_self">交易平台</a></li><li class="arrow"></li><li>发布需求</li>
    </ol>
    <h1 class="sell">出售</h1>
    <form>
    <table>
    <tbody>
        <tr>
          <td>标题</td>
          <td colspan="4"><div class="input-box title"><input type="text" maxlength="50" id="dealTitle"><span class="now-w">0</span>/50</div></td>
        </tr>
        <tr>
          <td>品牌</td>
          <td colspan="4"><ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex4">
              <a class="btn six-words" data-toggle="dropdown"><div class="input-result">请选择</div><i></i></a>
              <ul class="dropdown-menu brand">
                @if($brand)
                @foreach($brand as $value)
                <li><a data-id="{{ $value->brandId }}">{{ $value->brandName }}</a></li>
                @endforeach
                @endif
              </ul></li>
              <input type="hidden" id="brandID">
              {{-- 获取品牌ID --}}
        </ul></td>
        </tr>
        <tr>
          <td class="up-title">车型</td>
          <td colspan="4"><div class="car-type Zindex4 clear">
              <div class="input-result"></div><i></i>
              <ul class="car-type-box"></ul>
              <input type="hidden" id="carType">
              {{-- 获取车型ID --}}
              </div></td>
        </tr>
        <tr>
          <td>地区</td>
          <td><ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex3" id="province">
              <a class="btn six-words" data-toggle="dropdown"><div class="input-result">请选择</div><i></i></a>
              <ul class="dropdown-menu">
                @if($province)
                @foreach($province as $value)
                <li data-id="{{$value->id}}"><a>{{ $value->name }}</a></li>
                @endforeach
                @endif
              </ul></li>
              <input type="hidden" id="proID">
              {{-- 接收省ID --}}
        </ul></td>
          <td><ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex3" id="city">
              <a class="btn six-words" data-toggle="dropdown"><div class="input-result">请选择</div><i></i></a>
              <ul class="dropdown-menu">
              </ul></li>
              <input type="hidden" id="cityID">
              {{-- 接收市ID --}}
        </ul></td>
          <td colspan="2"><div class="input-box"><input type="text" id="add"></td>
        </tr>
        <tr>
          <td>联系人</td>
          <td><div class="input-box userName"><input type="text" id="userName"></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>手机号</td>
          <td><div class="input-box mobile"><input type="text" id="mobile" maxlength="11" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>状态</td>
          <td><ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex2" id="status">
              <a class="btn six-words" data-toggle="dropdown"><div class="input-result">进行中</div><i></i></a>
              <ul class="dropdown-menu">
                <li data-id="0"><a>进行中</a></li>
                <li data-id="1"><a>已结束</a></li>
              </ul></li>
              <input type="hidden" id="statusID" value="0">
              {{-- 状态 --}}
        </ul></td>
          <td class="pc"><span>单价</span><div class="input-box price"><input type="text" id="price">元&nbsp;</td>
          <td class="pc"><span>数量</span><div class="input-box price"><input type="text" id="count" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "></td>
          <td class="color"><span>成色</span><ul class="lem-drop lem-drop-input">
          <li class="dropdown Zindex2" id="quality">
              <a class="btn six-words" data-toggle="dropdown"><div class="input-result">全新</div><i></i></a>
              <ul class="dropdown-menu">
                <li data-id="10"><a>全新</a></li>
                <li data-id="1"><a>一成新</a></li>
                <li data-id="2"><a>两成新</a></li>
                <li data-id="3"><a>三成新</a></li>
                <li data-id="4"><a>四成新</a></li>
                <li data-id="5"><a>五成新</a></li>
                <li data-id="6"><a>六成新</a></li>
                <li data-id="7"><a>七成新</a></li>
                <li data-id="8"><a>八成新</a></li>
                <li data-id="9"><a>九成新</a></li>
              </ul></li>
              <input type="hidden" id="qualityID" value="10">
              {{-- 成色 --}}
        </ul></td>
        </tr>
        <tr>
          <td>生产日期</td>
          <td colspan="4"><div class="input-box" style="width:168px;"><input type="text" onClick="WdatePicker()" id="factorytime"/></div></td>
        </tr> 
     <tr>
          <td>详细描述</td>
          <td colspan="4"></td>
        </tr>   
    </tbody>
    </table>
    {!!HTML::script('common/ueconfig.js') !!}<div id="editTxt"></div>
    <a class="btn publish" role="button">发布</a>
    <input type="hidden" id="editorContent">
    {{-- 富文本内容 --}}
    </form>
</div>
</div>
<input type="hidden" id="pass">
{{-- pass为1，可以发布，反之亦然 --}}
@stop

@section('footer-scripts')
<script type="text/javascript">
    editor('editTxt');
/**
 * 省市区
 */
var $province = $('#province');
var $city = $('#city');
$province.on('click', '.dropdown-menu li', function () {
  $city.find('.input-result').html('请选择');
  var proID = $(this).attr('data-id');
  $('#proID').val(proID);
  $.post('/user/api/city', {id: $(this).attr('data-id')}).success(function (res) {
    var tmp = '';
    $.each(res, function () {
      tmp += '<li data-id="'+this.id+'"><a>'+this.name+'</a></li>';
    });
    $city.find('.dropdown-menu').html(tmp);
  });
});

$city.on('click', '.dropdown-menu li', function () {
    var cityID = $(this).attr('data-id');
    $('#cityID').val(cityID);
});
</script>
@stop
