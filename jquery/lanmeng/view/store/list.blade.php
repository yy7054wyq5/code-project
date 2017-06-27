@extends('layouts.main')
@section('banner')
@endsection
@section('header-scripts')
{!!HTML::script('common/follow.js') !!}
{!!HTML::script('common/carts.js') !!}
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
@endsection
@section('content')
<div class="store-list-main">
  <div class="container">
    <div class="store-list-left">
      <div class="side-bar duoduo">
          <h2>多多推荐<small>Best Buy</small></h2>
          <ul>
              @if(isset($recommends) && count($recommends) >0)
                  @foreach($recommends as $recommend)
                      <li><a href="/commodity/detail/{{$recommend['id']}}" target="_self" title="{{$recommend['name']}}">
                              <img src="/image/get/{{$recommend['cover']}}"/>
                              <p class="side-font">{{$recommend['name']}}</p>
                          </a>
                          <span>￥{{$recommend['minPrice']}}</span>
                      </li>
                  @endforeach
              @endif
          </ul>
      </div>
        @if(isset($ad) && $ad)
        <a href="{{starts_with($ad['link'], 'http://')?$ad['link']:'http://'.$ad['link']}}" target="_self" title="广告位"><img class="img-adv" src="/image/get/{{$ad['imageId']}}" alt="广告位"></a>
        @endif
    </div>
    <div class="store-list-right">
        <ol class="breadcrumb list">
          <li><a href="/store" target="_self" class="red-font">商城</a></li>
            <li class="arrow"></li><li>所有分类</li>
            @if(isset($cInfo) && $cInfo)
            <li class="arrow"></li><li class="current">{{$cInfo['name']}}</li>
            @endif
            @if(isset($childCInfo) && $childCInfo)
                <li class="arrow"></li><li class="current">{{$childCInfo['name']}}</li>
            @endif
            <li class="arrow"></li>
            <li class="chosed brand">@if(array_get($_GET,'brandId') && in_array(array_get($_GET,'brandId'), array_keys($brandKv))) <a><span data-sourceid="{{array_get($_GET,'brandId')}}">{{$brandKv[$_GET['brandId']]['brandName']}}</span><i></i></a> @endif</li>
            <li class="chosed kind">@if(array_get($_GET,'categoryId') && in_array(array_get($_GET,'categoryId'), array_keys($categoryKv))) <a><span data-sourceid="{{array_get($_GET,'categoryId')}}">{{$categoryKv[$_GET['categoryId']]['name']}}</span><i></i></a> @endif</li>
            <li class="chosed price">@if(array_get($_GET,'priceId') && in_array(array_get($_GET,'priceId'), array_keys($priceKv))) <a><span data-sourceid="{{array_get($_GET,'priceId')}}">{{$priceKv[$_GET['priceId']]['rangeStart']}}-{{$priceKv[$_GET['priceId']]['rangeEnd']}}</span><i></i></a> @endif</li>
        </ol>
        <div class="list-chose">
          <h2>@if(isset($cInfo) && $cInfo) {{$cInfo['name']}} @endif商品筛选<small>共{{$cnt}}个商品</small></h2>
          <table>
              <tr>
                <td>品牌：</td>
                <td class="black-font brand">
                  <a class="more" role="button"><span>更多</span><i></i></a>
                  <ul class="brand-tab">
                    <li><a id="brandAll" class="active" role="button">全部品牌</a></li>
                    <li><a id="brand1" role="button" title="A,B,C,D,E,F,G">A-G</a></li>
                    <li><a id="brand2" role="button" title="H,I,J,K,L,M,N">H-N</a></li>
                    <li><a id="brand3" role="button" title="O,P,Q,R,S,T">O-T</a></li>
                    <li><a id="brand4" role="button" title="U,V,W,X,Y,Z">U-Z</a></li>
                  </ul>
                  <div class="chose-con brand">{{-- <a role="button" class="active" id="auto">不限</a> --}}
                      @if(isset($brand) && count($brand) >0)
                      @foreach($brand as $index=>$value)
                              @foreach($value as $item)
                              <a role="button" data-brandId="{{$item['brandId']}}" class="brand{{$index+1}} @if($item['brandId'] == array_get($_GET,'brandId')) active @endif">{{$item['brandName']}}</a>
                              @endforeach
                      @endforeach
                      @endif
                  </div>
                </td>
              </tr>
              @if(isset($categoryKv) && count($categoryKv) >0)
              <tr>
                <td >种类：</td>
                <td class="black-font"><a class="more" role="button">@if(count($categoryKv) >= 11) <span>更多</span><i></i></a> @endif
                <!--上为更多按钮 -->
                    <div class="chose-con kind">
                        <a role="button" @if(array_get($_GET,'categoryId') == 0 || !in_array(array_get($_GET,'categoryId'),array_keys($categoryKv))) class="active" @endif data-categoryId="0" id="auto">不限</a>
                        <?php $j=0?>
                            @foreach($categoryKv as $key=>$category)
                                <a role="button" data-categoryId="{{$category['id']}}" @if($category['id'] == array_get($_GET,'categoryId')) class="active" @endif>{{$category['name']}}</a>
                                    @if($j==10)
                                        <a role="button">台卡架</a>
                                    @endif
                            <?php $j++?>
                            @endforeach
                    </div></td>
              </tr>
              @endif
              @if(isset($priceKv) && count($priceKv) > 0)
              <tr class="noline">
                <td>价格：</td>
                <td class="black-font">
                    <div class="chose-con price">
                        <a role="button" data-priceId="0" @if(array_get($_GET,'priceId') ==0 || !in_array(array_get($_GET,'priceId'),array_keys($priceKv))) class="active" @endif  id="auto">不限</a>
                        @foreach($priceKv as $rangePrice)
                            <a role="button" data-priceId="{{$rangePrice['mallCategoryRangePriceId']}}" @if($rangePrice['mallCategoryRangePriceId'] == array_get($_GET,'priceId')) class="active" @endif>{{$rangePrice['rangeStart']}}-{{$rangePrice['rangeEnd']}}</a>
                        @endforeach
                    </div></td>
              </tr>
              @endif
          </table>
        </div>
        <nav class="navbar">
            <ul class="nav nav-pills">
                <li role="presentation" data-value="" @if(!array_get($_GET, 'sort')) class="active first"  @endif><a href="javascript:return false" id="">综合排序</a></li>
                <li role="presentation"  data-value="saleNumber" @if(array_get($_GET, 'sort') == 'saleNumber') class="active first"  @endif><a href="javascript:return false" id="">销量</a></li>
                <li role="presentation" data-value="minPrice"  @if(array_get($_GET, 'sort') == 'minPrice') class="active first"  @endif><a  href="javascript:return false" id="">价格</a></li>
                <li role="presentation" data-value="created"  @if(array_get($_GET, 'sort') == 'created') class="active first"  @endif><a href="javascript:return false" id="">新品</a></li>
            </ul>
            <div class="navbar-form navbar-left">
                <div class="form-group">
                  <input type="text" class="form-control" name="ckeyword" placeholder="在结果中搜索" value="{{array_get($_GET, 'keyword')? array_get($_GET, 'keyword'):''}}">
                  <input type="hidden" name="categoryId" value="{{array_get($cInfo,'id')? array_get($cInfo,'id'): 0}}">
                </div>
                <a class="btn btn-default search">搜索</a>
            </div>
            <div class="page-action white">
                <a class="page-up @if(!isset($prePage) || !$prePage) nopage @endif" href="{{$prePage}}" role="button">&lt;</a>
                <span>{{array_get($_GET,'page', 1)}}/{{$pageNum}}</span>
                <a class="page-down @if(!isset($nextPage) || !$nextPage) nopage @endif" href="{{$nextPage}}" role="button">&gt;</a>
            </div>
        </nav>
        <div class="dis-result">
        <div class="noContent">没有找到相关的资源</div>
            @if(isset($commodities) && count($commodities)>0)
                @foreach($commodities as $commodity)
                    <div class="small-adv">
                        <a href="/commodity/detail/{{$commodity['id']}}" target="_self"><img  src="/img/temp-img.png" title="{{$commodity['name']}}" class="lazy" data-original="{{$commodity['path']}}"/></a>
                        <p class="clear"><span class="price">￥{{$commodity['minPrice']}}</span><span class="tag">{{ $commodity['dispatch'] ? Config::get('other.dispatch')[$commodity['dispatch']] : '与客服沟通' }}</span><span class="myclear"></span></p>
                        <h5><a href="/commodity/detail/{{$commodity['id']}}" target="_self" title="{{$commodity['name']}}">{{$commodity['name']}}</a></h5>
                        <span class="comment">已有<a href="" target="_self">{{$commodity['commentNumber']}}</a>评价</span>
                        <div class="adv-btn-box"><a data-type="{{$commodity['cartType']}}"
                                                    data-commodityid="{{$commodity['id']}}"
                                                    data-spec="{{$commodity['spec'] ? $commodity['spec']:0}}"
                                                    class="btn addbus" role="button">加入购物车</a><a
                                    data-commodityid="{{$commodity['id']}}" data-followtype="0"
                                    class="btn att @if(array_get($commodity, 'followStatus') == 1) active @endif"
                                    role="button">关注</a></div>
                    </div>
                @endforeach
            @endif
        </div>
        <?php echo $page?>
    </div>
  </div>
</div>
@endsection
@section('footer-scripts')
    @parent
    <script>
        $('.btn.att').on('click', function(){
            if(Cookies.get('lAmE_simple_auth')==undefined){
                alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
                return false;
            }
            var commodityId = $(this).data('commodityid'), followType = $(this).data('followtype'), status= 0, button = $(this);
            if ($(this).hasClass('active'))  status=1;

            var param = {
                "type" : followType,
                "id" : commodityId,
                "status" : status
            };
            $.ajax({
                type: "POST",
                url:"/user/api/setfollow",
                data:param,
                dataType: 'json',
                success: function(msg) {
                    if (msg.status == 0) {
                        button.toggleClass("active");
                    } else {
                        alertTips(msg.tips);
                    }
                },
                error: function(error){
                    alertTips('操作失败');
                }
            });
        });

        $('.btn.addbus').on('click', function(){
            if(Cookies.get('lAmE_simple_auth')==undefined){
                alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
                return false;
            }
            $(this).addClass('active');
            var type = $(this).data('type'), subtype= 0, commodityId = $(this).data('commodityid'), spec=$(this).data('spec'), nums=1;
            return carts(type, subtype, commodityId, spec, nums);
        });

        $(document).ready(function() {
          var $kind = $('.chose-con.kind');
          var totalWidth = $kind.width();
          var kindChildenWidth = 0;
          $.each($('.chose-con.kind>a[data-categoryid]'), function(index, val) {
            kindChildenWidth += $(val).width()+parseInt($(val).css('margin-right'));
          });
          //多了一个更多按钮
          $('.chose-con.kind').find('a.more').remove();
          if(totalWidth<kindChildenWidth){
            $kind.siblings('a.more').html('<span>更多</span><i></i>');
          }
        });
    </script>
@endsection
