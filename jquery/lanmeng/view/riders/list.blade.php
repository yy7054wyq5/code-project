@extends('layouts.main')
@section('banner')
@endsection
@section('content')
<div class="riders-list-main">
<div class="container">
  <ol class="breadcrumb">
    <li><a href="/riders" class="red-font">车友汇</a></li><li class="arrow"></li><li class="current">最新线路</li>
  </ol>
  <div class="list-left">
    <ul class="nav nav-tabs mouse-over-tab" role="tablist" >
      <li role="presentation" class="active"><a href="#road" aria-controls="inspect" role="tab" data-toggle="tab" >最新线路</a></li>
      <li role="presentation"><a href="#theme" aria-controls="infor" role="tab" data-toggle="tab">主题游</a></li>
      <li role="presentation"><a href="#go" aria-controls="brand" role="tab" data-toggle="tab">说走就走</a></li>
    </ul>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="road">
        <ul class="riders-list-con clear">
          @if(isset($lists[0]))
          @foreach($lists as $value)
          <li>
            <div class="shadow"></div>
            <div class="riders-tab-content">
                <img src="{{ $value['imageurl'] }}" onclick="goDetail('/riders/detail/{{ $value['oldId'] ? $value['oldId'] : $value['id'] }}')">
                <dl onclick="goDetail('/riders/detail/{{ $value['id'] }}')">
                  <dt>{{ $value['name'] }}</dt>
                  <dd class="red-font">{{ $value['title'] }}</dd>
                  <dd>{{ $value['strokeMode'] }}</dd>
                  <dd>行程天数：{{ $value['travelDays'] }}天</dd>
                  <dd>出发日期：@if(!empty($value['departureDate'])) {{ $value['departureDate']}} @endif </dd>
                </dl>
                <div class="riders-btn-box">
                  <p><span>￥</span>{{ isset($value['specarr']['price']) ? $value['specarr']['price'] : 0.00 }}</p>
                  <a class="detail-btn" href="/riders/detail/{{ $value['id'] }}" >查看详情</a>
                </div>
            </div>
          </li>
          <li class="clear"></li>
          @endforeach
          @endif
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane" id="theme">
        <ul class="riders-list-con clear">
          @if(isset($lists[0]))
          @foreach($lists as $value)
          @if($value['categoryId'] == 1)
          <li>
            <div class="shadow"></div>
            <div class="riders-tab-content">
                <img src="{{ $value['imageurl'] }}" onclick="goDetail('/riders/detail/{{ $value['oldId'] ? $value['oldId'] : $value['id'] }}')">
                <dl onclick="goDetail('/riders/detail/{{ $value['id'] }}')">
                  <dt>{{ $value['name'] }}</dt>
                  <dd class="red-font">{{ $value['title'] }}</dd>
                  <dd>{{ $value['strokeMode'] }}</dd>
                  <dd>行程天数：{{ $value['travelDays'] }}天</dd>
                    <dd>出发日期：@if(!empty($value['departureDate'])) {{ $value['departureDate']}} @endif </dd>
                </dl>
                <div class="riders-btn-box">
                  <p><span>￥</span>{{ isset($value['specarr']['price']) ? $value['specarr']['price'] : 0.00 }}</p>
                  <a class="detail-btn" href="/riders/detail/{{ $value['id'] }}" target="_self">查看详情</a>
                </div>
            </div>
          </li>
          <li class="clear"></li>
          @endif
          @endforeach
          @endif
        </ul>
      </div>
      <div role="tabpanel" class="tab-pane" id="go">
          <ul class="riders-list-con clear">
            @if(isset($lists[0]))
            @foreach($lists as $value)
            @if($value['categoryId'] == 2)
            <li>
              <div class="shadow"></div>
              <div class="riders-tab-content">
                  <img src="{{ $value['imageurl'] }}" onclick="goDetail('/riders/detail/{{ $value['oldId'] ? $value['oldId'] : $value['id'] }}')">
                  <dl onclick="goDetail('/riders/detail/{{ $value['id'] }}')">
                    <dt>{{ $value['name'] }}</dt>
                    <dd class="red-font">{{ $value['title'] }}</dd>
                    <dd>{{ $value['strokeMode'] }}</dd>
                    <dd>行程天数：{{ $value['travelDays'] }}天</dd>
                      <dd>出发日期：@if(!empty($value['departureDate'])) {{ $value['departureDate']}} @endif </dd>
                  </dl>
                  <div class="riders-btn-box">
                    <p><span>￥</span>{{ isset($value['specarr']['price']) ? $value['specarr']['price'] : 0 }}</p>
                    <a class="detail-btn" href="/riders/detail/{{ $value['id'] }}" target="_self">查看详情</a>
                  </div>
              </div>
            </li>
            <li class="clear"></li>
            @endif
            @endforeach
            @endif
          </ul>
      </div>
    </div>
    <div class="riders-list-bottom">
      <div class="page-action white clear">
          <a class="page-up nopage" href="/riders-list?page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
          @for($i = 1; $i <= $pagenum; $i++)
          <a role="button" href="/riders-list?page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
          @endfor
          <a class="page-down" href="/riders-list?page={{ $page + 1 >= $pagenum ? $pagenum : $page + 1 }}" role="button">下一页</a>
          <span style="margin-left:50px;">共{{ $pagenum }}页</span>
          <span>到第</span>
          <input type="text">
          <span>页</span>
          <a role="button" class="btn">确定</a>
      </div>
    </div>
  </div>
    <div class="list-right">
      <div class="side-bar rank">
          <h2>热卖线路产品排行</h2>
          <ul>
              @if(count($bestSellers)>0)
                  @foreach($bestSellers as $key => $item)
                  <!-- 排名第一的样式，请勿于下面的混淆 -->
                  @if($key == 0)
                      <li class="rank-one">
                        <a href="/riders/detail/{{$item['id']}}" target="_self" title="{{$item['title']}}">
                          <span>0{{$key+1}}</span>
                          <img src="{{ $item['imageurl'] }}"/>
                          <p class="side-font">{{$item['name']}}</p>
                        </a>
                        <span>￥{{$item['showprice']}}</span>
                      </li>
                   @else
                     <li><a href="/riders/detail/{{$item['id']}}" target="_self" title="{{$item['title']}}"><span>{{$key+1}}</span>{{$item['name']}}</a></li>
                   @endif
                  @endforeach
          @endif
          </ul>
      </div>
      <div class="side-bar duoduo">
          <h2>推荐线路</h2>
          <ul>
              @if(isset($attributeLists) && count($attributeLists)>0)
                  @foreach($attributeLists as $key => $item)
                      <li><a href="/riders/detail/{{$item['id']}}" target="_self" title="{{$item['title']}}">
                        <img src="{{ $item['imageurl'] }}"/>
                        <p class="side-font">{{$item['name']}}</p>
                      </a>
                      <span>￥{{$item['showprice']}}</span></li>
                  @endforeach
              @endif
          </ul>
      </div>
  </div>
</div>
</div>
@endsection
@section('footer-scripts')
  @parent
    <script type="text/javascript">
        function goDetail(url) {
            location.href = url;
        }
    </script>
@endsection

