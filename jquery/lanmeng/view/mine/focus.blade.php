@extends('mine.fragment.layout')
@section('uc-content')
<div class="uc-main-main">
  <div class="uc-focus" id="j_uc_focus">
    <div class="uc-focus-header">
      <h3 class="title">关注的商品</h3>
      <!-- <div class="side">
        <div class="page-action white">
            <a class="page-up nopage" role="button">&lt;</a>
            <span>1/20</span>
            <a class="page-down" role="button">&gt;</a>
        </div>
      </div> -->
    </div>
    <div class="uc-focus-body">
      @if(isset($follows) && count($follows)>0)
      <div class="operate">
        <label><input class="checkAll" type="checkbox"> 全选</label><a href="javascript:;">取消关注</a>
      </div>
      <div class="goods">
        @foreach($follows as $item)
          <div class="item">
            <a class="pic" href="{{$item['url']}}"><img src="{{$item['image']}}" alt=""></a>
            <div class="title">
              <input data-type="{{$item['type']}}" value="{{$item['cid']}}" type="checkbox">
              <a href="{{$item['url']}}">{{$item['name']}}</a>
            </div>
            {{--<p class="price"></p>--}}
            <p class="date">加关注时间:{{ date('Y-m-d', $item['fcreated']) }}</p>
            <div class="ft">
              <a href="{{$item['url']}}">重新购买</a>
              <a class="cancelBtn" href="javascript:;">取消关注</a>
            </div>
          </div>
        @endforeach
      </div>
      @else
      <div class="noitem">暂无数据</div>
      @endif
    </div>
    <div class="uc-focus-footer">
        <?php echo $pager?>
      {{--<div class="page-action white">--}}
          {{--<a class="page-up nopage" role="button">上一页</a>--}}
          {{--<a role="button" class="active">1</a>--}}
          {{--<a role="button">2</a>--}}
          {{--<a role="button">3</a>--}}
          {{--<span>......</span>--}}
          {{--<a class="page-down" role="button">下一页</a>--}}
      {{--</div>--}}
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
@section('footer-scripts')
    @parent
    <script>
        $(document).on('click', '.redirect.btn', function(){
            var page = $('input[name="pageNum"]').val();
            if (page && page>0) {
                location.href = '/mine/focus?page=' +page;
            }
        });
    </script>
@endsection
