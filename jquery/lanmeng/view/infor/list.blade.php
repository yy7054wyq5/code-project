@extends('layouts.main')

{{-- 关闭banner --}}
@section('banner')
@endsection

{{-- 资讯列表内容 --}}
@section('content')
<div class="infor-list-main">
<div class="container">
  <ol class="breadcrumb">
    <li><a href="/infor" class="red-font">资讯</a></li><li class="arrow"></li><li class="current"></li>
  </ol>
  <div class="list-tab">

    <ul class="nav nav-tabs" role="tablist" >
      <li role="presentation" index="{{$titleTag[0]['typeid']}}"><a href="#list-market" aria-controls="inspect" role="tab" data-toggle="tab">{{$titleTag[0]['type_name']}}</a></li>
      <li class="tab-line">|</li>
      <li role="presentation" index="{{$titleTag[1]['typeid']}}"><a href="#list-business" aria-controls="infor" role="tab" data-toggle="tab" >{{$titleTag[1]['type_name']}}</a></li>
      <li class="tab-line">|</li>
      <li role="presentation" index="{{$titleTag[2]['typeid']}}"><a href="#list-policy" aria-controls="brand" role="tab" data-toggle="tab" >{{$titleTag[2]['type_name']}}</a></li>
      <li class="tab-line">|</li>
      <li role="presentation" index="{{$titleTag[3]['typeid']}}"><a href="#list-car" aria-controls="brand" role="tab" data-toggle="tab">{{$titleTag[3]['type_name']}}</a></li>
    </ul>

      <div class="tab-content">
        <!-- 市场资讯 -->
        <div role="tabpanel" index="4" class="tab-pane" id="list-market">
            <div class="page-action white clear"></div>
            <input type="hidden" name="pageID4" value="1">
            <input type="hidden" name="totalPage4">
        </div>
        <!-- 行业观察 -->
        <div role="tabpanel" index="2" class="tab-pane" id="list-business">
            <div class="page-action white clear"></div>
            <input type="hidden" name="pageID2" value="1">
            <input type="hidden" name="totalPage2">
        </div>
        <!-- 政策公告 -->
        <div role="tabpanel" index="1" class="tab-pane" id="list-policy">
            <div class="page-action white clear"></div>
            <input type="hidden" name="pageID1" value="1">
            <input type="hidden" name="totalPage1">
        </div>
        <!-- 车界娱乐 -->
        <div role="tabpanel" index="3" class="tab-pane" id="list-car">
            <div class="page-action white clear"></div>
            <input type="hidden" name="pageID3" value="1">
            <input type="hidden" name="totalPage3">
        </div>
      </div>
      <div class="loading"></div>
      <div class="noContent">没有找到相关的资源</div>
      <input type="hidden" id="typeID">
    </div>
    <div class="list-right">
        <div class="side-bar rank">
            <h2>新闻排行</h2>
            <ul>
                @if($newList)
                @foreach($newList as $key => $item)
                     <li><a href="/infor/detail/{{$item->infoId}}" target="_self" title="{{$item['infoDesc']}}"><span>{{$key+1}}、</span>{{$item['infoTitle']}}</a></li>
                @endforeach
                @endif
            </ul>
        </div>
        <div class="side-bar duoduo">
            <h2>多多推荐<small>Best buy</small></h2>
            <ul>

                @if(isset($recommends) && count($recommends) > 0)
                    @foreach($recommends as $recommend)
                        <li><a href="/commodity/detail/{{$recommend['id']}}" target="_self" title="{{$recommend['name']}}">
                                <img src="/image/get/{{$recommend['cover']}}">
                                <p class="side-font">{{$recommend['name']}}</p>
                            </a>
                            <span>￥{{$recommend['minPrice']}}</span></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection


