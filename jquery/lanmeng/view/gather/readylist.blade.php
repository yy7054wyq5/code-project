@extends('layouts.main')

@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="/js/blocksit.min.js"></script>
@endsection

@section('banner')
@endsection

@section('content')
<div class="gather-readylist-main">
<div class="container gather-list-main">
  <ol class="breadcrumb">
    <li><a href="/ju" class="red-font" target="_self">聚惠</a></li>
    <li class="arrow"></li>
    <li>热门预购</li>
      {{--@if(isset($categoryInfo) && $categoryInfo)
          <li>{{$categoryInfo['name']}}</li>
      @endif --}}

  </ol>
  <div class="list-chose">
  <table>
      <tr>
        <td >品牌：</td>
        <td class="black-font" id="brandBox"><a class="more" role="button"><span>更多</span><i></i></a><!--上为更多按钮 -->
            <div class="chose-con">
                <a role="button" data-brandId="0" @if(!array_get($_GET, 'randId')|| array_get($_GET, 'randId')==0) class="active auto" @endif>全部</a>
                @if(isset($brands) && count($brands) >0)
                    @foreach($brands as $brand)
                        <a role="button" @if(array_get($_GET, 'randId')==$brand['brandId']) class="active auto" @endif data-brandId="{{$brand['brandId']}}">{{$brand['brandName']}}</a>
                    @endforeach
                @endif
            </div></td>
    
        {{-- 品牌  --}}
      </tr>
      <tr class="noline">
        <td>种类：</td>
        <td class="black-font">
            <div class="chose-con" id="typeBox">
                <a role="button" data-categoryId="0" @if(!array_get($_GET, 'categoryId')|| array_get($_GET, 'categoryId')==0) class="active auto" @endif>全部</a>
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <a role="button" @if(array_get($_GET, 'categoryId')==$category['id']) class="active auto" @endif data-categoryId="{{$category['id']}}">{{$category['name']}}</a>
                    @endforeach
                @endif
            </div></td>
      
        {{-- 种类 --}}
      </tr>
  </table>
  <ul class="status-tab" id="statusBox">
      <li><a status-id="-1" @if(array_get($_GET, 'state', -1) == -1)class="active" @endif role="button">全部</a></li>
      <li><a status-id="1" @if(array_get($_GET, 'state', -1) == 0)class="active" @endif role="button">正在进行</a></li>
      <li><a status-id="0" @if(array_get($_GET, 'state', -1) == 1)class="active" @endif role="button">即将开始</a></li>
      <li><a status-id="2" @if(array_get($_GET, 'state', -1) == 2)class="active" @endif role="button">已结束</a></li>
  </ul>
  {{-- 状态  --}}
  <div class="chose-con">
    <div id="pinterest"></div>
    <div class="myclear"></div>
    <div class="loading"></div>
    <div class="noContent">没有找到相关的资源</div>
    <div class="page-action white clear"></div>
    <input type="hidden" name="current" value="{{ time() * 1000 }}">
    {{-- 当前页码 --}}
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