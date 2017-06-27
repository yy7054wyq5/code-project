@extends('layouts.main')
@section('banner')
@endsection
@section('content')
  <div class="container">
    <ul class="w-crumb">
      <li><a href="#">我的蓝网</a></li>
      <li><a href="#">创库订单</a></li>
      <li class="disabled"><a href="javascript:;">订单号：{{ $ordersn }}</a></li>
    </ul>
    <div class="order-status-bar">
      <ul class="status">
        <li class="item @if($detail->status == 1) on arrow @elseif($detail->status > 1) on @endif">支付积分<span>{{ date('Y-m-d H:i:s', $detail->created) }}</span></li>
        <li class="item @if($detail->status == 2) on arrow @elseif($detail->status > 2) on @endif">设计待确认<span>{{ date('Y-m-d H:i:s', $detail->created) }}</span></li>
        <li class="item @if($detail->status == 3) on arrow @endif">订单完成<span></span></li>
      </ul>
    </div>
    <!-- step2 -->
     <div class="order-status-intro">
      <h3>当前订单状态：{{$status}}</h3>
      <div class="res-row" style="margin-bottom: 10px;">
        <div class="llabel">设计完稿文件</div>
        <div class="cont">
          <div class="r">
              @if(isset($down) && count($down))
                  @foreach($down as $key => $value)
                    <div class="u">
                        <a class="tt download" href="@if($detail->status == 4) javaceript:; @else /files/downloadfile/{{$value['fileid']}} @endif">{{$value['name']}}</a>
                        <span class="time">下载次数：@if(isset($value['downCount']) && !empty($value['downCount']) ){{$value['downCount']}} @else 0 @endif </span>
                        <span class="date">上传时间：@if(isset($value['created']) && !empty($value['created'])) {{date('Y-m-d H:i:s',$value['created'])}} @endif </span>
                    </div>
                  @endforeach
              @else
              暂无文档
              @endif
          </div>
        </div>
      </div>

         <div class="res-row">
             <div class="llabel" style="margin-bottom: 10px;">用户留言</div>
             <div class="cont">
                 <div class="r">
                     @if(isset($customer) && count($customer))
                         @foreach($customer as $key => $item)
                             <div class="u">
                                <div class="clear">
                                    <span class="time">用户：</span>
                                    <span class="date">发布时间：{{ date('Y-m-d H:i', $item['created'])}}</span>
                                </div>
                                 <p class="">{{$item['comment']}}</p>
                             </div>
                             @if(isset($item['customer']))
                                 @foreach($item['customer'] as $k => $customerItem)
                                     <div class="u">
                                          <div class="clear">
                                              <span class="time">客服：</span>
                                              <span class="date">发布时间：{{ date('Y-m-d H:i', $item['created'])}}</span>
                                          </div>
                                         <p class="">{{$customerItem['content']}}</p>
                                     </div>
                                 @endforeach
                             @endif
                         @endforeach
                    @else
                    暂无留言
                     @endif
                 </div>
             </div>
         </div>

        @if($detail->status != 3)
    <form class="form-horizontal" id="form" onsubmit="return false;" >
      <div class="res-row">
        <div class="llabel"></div>
          <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
          <input type="hidden" name="ordersn"  value="{{$ordersn}}"/>
          <input type="hidden" name="commentType"  value="{{\App\Model\Comment::$typeCreativeOrder}}"/>
        <div class="cont"><textarea rows="6" name="comment" autocomplete="off"  placeholder="输入您的要求，我们的设计师会尽量修改"></textarea></div>
      </div>
      <div class="res-row2">
        <a href="javascript:;"  class="lbtn">留言</a>
      </div>
    </form>
         <input type="hidden" name="status" value="3" />
         <input type="hidden" name="orderID" value="{{$id}}" />
      <p class="res-row3">如果您对设计表示满意了也可以<a href="javascript:;" class="ubtn">确认完稿</a></p>
    </div>
    @endif

    <!-- step3 -->
   <!-- <div class="order-status-intro">
      <h3>当前订单状态：已完成</h3>
      <div class="res-row">
        <div class="llabel">设计完稿文件<span>（点击下载）</span></div>
        <div class="cont">
          <div class="r">
           @if(isset($down) )
               @foreach($down as $key => $value)
                  <div class="u">
                      <a class="tt download" href="{{$value['path']}}">{{$value['name']}}</a>
                      <span class="time">下载次数：@if(isset($value['downCount']) && !empty($value['downCount']) ){{$value['downCount']}} @else 0 @endif </span>
                      <span class="date">上传时间：@if(isset($value['created']) && !empty($value['created'])) {{date('Y-m-d H:i:s',$value['created'])}} @endif </span>
                  </div>
               @endforeach
            @endif
          </div>
        </div>
      </div>
      <p>当前订单已经设计完稿，感谢您对我们设计的肯定，欢迎您对本地交易进行<a href="/mine/orderreply/{{ $ordersn }}" class="link-blue">发表评论</a></p>
      <p>如还有其他问题请联系客服：<a href="#" class="link-orange">400-030-8555</a></p>
    </div> -->
    <div class="order-status-desc">
      <div class="hd">订单信息</div>
      @if(isset($list) && count($list)>0 )
      @foreach($list as $key => $value)
      <div class="bd">
        <table>
          <col width="14.2857%">
          <col width="42.8571%">
          <col width="14.2857%">
          <col width="14.2857%">
          <col width="14.2857%">
          <tr>
            <th>商品图片</th>
            <th>商品名称</th>
            <th>单价</th>
            <th>数量</th>
            <th>总价</th>
          </tr>
          <tr>
            <td><img src="{{ $value['imageurl'] }}" alt=""></td>
            <td class="title">{{ $value['goodsname'] }}</td>
            <td>{{ $value['price'] }}积分</td>
            <td>{{ $value['num'] }}</td>
            <td>{{ $value['num'] * $value['price'] }}积分</td>
          </tr>
        </table>
        <div class="amount">
          <div class="price"><b>订单总积分：</b><span class="orange">{{ $value['num'] * $value['price'] }}</span></div>
        </div>
        <div class="panel">
          <!-- <div class="panel-hd">这个是名字名字名字名字 <span>大众</span></div> -->
          <div class="panel-bd">
            <dl>
              <dt>主KV信息</dt>
              <dd><span class="llabel">主标题：</span>{{ isset($kv[$key]) ? $kv[$key]->title : '无' }}</dd>
              <dd><span class="llabel">副标题：</span>{{ isset($kv[$key]) ? $kv[$key]->subtitle : '无' }}</dd>
              <dd><span class="llabel">活动详情：</span>{{ isset($kv[$key]) ? $kv[$key]->activity : '无' }}</dd>
              <dd><span class="llabel">经销商信息：</span>{{ isset($kv[$key]) ? $kv[$key]->dealer : '无' }}</dd>
            </dl>
          </div>
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
    <script type="text/javascript" >
        $(document).ready(function(){
            $('.lbtn').bind('click',function(){
                if (!$('[name="comment"]').val().length) return alertTips('留言内容不能为空');
                load($.post('/mine/submitcomment', $('#form').serialize()))
                  .done(function (res) {
                    if (res.status === 0) {
                      littleTips('留言成功');
                      window.location.reload();
                    } else {
                      alertTips(res.tips);
                    }
                  });
            });

            $('.ubtn').on('click', function(event) {
                alertTips('你确定对完稿文件没有意见了吗？','creativeOrderOK','确定');
            });
        })

    </script>
@endsection
