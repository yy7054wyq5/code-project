@extends('layouts.main')

@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="/js/blocksit.min.js"></script>
@endsection

@section('banner')
@endsection

@section('content')
<div class="gather-list-main">
<div class="container">
  <ol class="breadcrumb">
    <li><a href="/ju" class="red-font" target="_self">聚惠</a></li>
    <li class="arrow"></li>
    <li>火爆团购</li>
  </ol>
  <div class="list-chose">
  <table>
      <tr>
        <td >品牌：</td>
        <td class="black-font" id="brandBox">
          <a class="more" role="button"><span>更多</span><i></i></a>
          <!--上为更多按钮 -->
          <div class="chose-con">
            <a role="button" class="active auto" data-brandId="0">全部</a>
            @if($brand)
            @foreach($brand as $value)
            <a role="button" data-brandId="{{ $value['brandId'] }}">{{ $value['brandName'] }}</a>
            @endforeach
            @endif
          </div>
        </td>
        
        {{-- 品牌 --}}
      </tr>
      <tr class="noline">
        <td>种类：</td>
        <td class="black-font">
        <div class="chose-con" id="typeBox">
          <a role="button" class="active auto" data-categoryId="0">全部</a>
          @if($type)
          @foreach($type as $value)
          <a role="button" data-categoryId="{{ $value['id'] }}">{{ $value['name'] }}</a>
          @endforeach
          @endif
        </div>
        </td>
        
        {{-- 种类 --}}
      </tr>
  </table>
  <ul class="status-tab" id="statusBox">
      <li><a status-id="-1" class="active" role="button">全部</a></li>
      <li><a status-id="1" role="button">正在进行</a></li>
      <li><a status-id="0" role="button">即将开始</a></li>
      <li><a status-id="2" role="button">已结束</a></li>
  </ul>
  
  {{-- 状态  --}}
  <div class="chose-con">
    <div id="pinterest"></div>
    <div class="myclear"></div>
    <div class="loading"></div>
    <div class="noContent">没有找到相关的资源</div>
    <div class="page-action white clear"></div>
    <input type="hidden" name="current" value="{{ time() * 1000 }}">
    <input type="hidden" id="totalPage">
    {{-- 总页码 --}}
  </div>
  </div>
</div>
</div>
@endsection

@section('footer-scripts')
<script type="text/javascript">
    $(function() {   
        if(location.href.indexOf('brandId')>-1){
            $('#brandBox .chose-con a').removeClass('active');
            $('#brandBox').find('a[data-brandid="'+handleURL.markValue('brandId')+'"]').addClass('active');
        }
        if(location.href.indexOf('categoryId')>-1){
            $('#typeBox>a').removeClass('active');
            $('#typeBox').find('a[data-categoryid="'+handleURL.markValue('categoryId')+'"]').addClass('active');
        }
        if(location.href.indexOf('state')>-1){
            $('#statusBox>li>a').removeClass('active');
            $('#statusBox').find('a[status-id="'+handleURL.markValue('state')+'"]').addClass('active');
        }
    }); 
</script>
@endsection