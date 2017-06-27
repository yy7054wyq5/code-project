@extends('layouts.main')

@section('banner')
@endsection

@section('header-scripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
@endsection

@section('content')
<div class="example-list-main">
<div class="container innovate-main">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/innovate" target="_self" class="red-font">创库</a></li>
    <li class="arrow"></li>
    <li><a href="/innovate/example" target="_self" class="red-font">执行案例</a></li>
  </ol>

    @if(isset($_GET['keyword'])  )
            <div role="tabpanel" >
                @if( isset($lists) && count($lists)>0)
                    @foreach($lists as $key => $item)
                        <div class="example-box">
                            <a href="" title="臻级豪礼"><img src="/image/get/{{$item->imageId}}" data-original="/image/get/{{$item->imageId}}"  class="lazy"></a>
                            <span class="writer">{{$item->realname}}</span>
                            <h2><a href="" title="臻级豪礼">{{$item->caseName}}</a></h2>
                            <p>人气 <span class="red-font">918</span>评论<span class="red-font">1212</span>推荐<span class="red-font">1212</span></p>
                        </div>
                    @endforeach
                @endif
                <div class="myclear"></div>
                <div class="page-action white clear">
                 <!--   <a class="page-up nopage" role="button">上一页</a>
                    <a role="button" class="active">1</a>
                    <a role="button">2</a>
                    <a role="button">3</a>
                    <span>......</span>
                    <a class="page-down" role="button">下一页</a> -->
                </div>
            </div>
     @else


  <ul class="nav nav-tabs mouse-over-tab more-example" role="tablist" >
      @if(count($exampleType)>0)
          @foreach($exampleType as $key => $item)
              <li role="presentation" class=" @if($key == 1) active @endif "><a href="#ex{{$key}}" data-id="{{$key}}" aria-controls="ex{{$key}}" role="tab" data-toggle="tab">{{$item}}</a></li>
          @endforeach
      @endif
    <li class="last input-group">
        <input type="text" class="form-control">
        <span class="input-group-btn">
          <div class="btn btn-default" type="button" >搜索</div>
        </span>
    </li>
    <li class="last">
        <div class="btn-box">
            <a class="btn up-example notab" href="/innovate/add-example" target="_self">上传案例</a>
            <a class="btn manage-example notab" href="/mine/case" target="_self">管理案例</a>
        </div>
    </li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="ex1"> </div>
    <div role="tabpanel" class="tab-pane" id="ex2"> </div>
    <div role="tabpanel" class="tab-pane" id="ex3"></div>
    <div role="tabpanel" class="tab-pane" id="ex4"></div>
    <div role="tabpanel" class="tab-pane" id="ex5"></div>
    <div role="tabpanel" class="tab-pane" id="ex6"></div>
    <div role="tabpanel" class="tab-pane" id="ex7"></div>
    <div class="page-action white clear"></div>
  </div>

  <input type="hidden" id="pageID" value="1">
  
   @endif
</div>
</div>
@endsection
