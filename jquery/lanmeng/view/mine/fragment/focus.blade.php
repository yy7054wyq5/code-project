<!-- focus -->
<div class="w-focus">
  <div class="w-focus-header">
    <div class="title">我关注的商品</div>
    <div class="side">
      <a href="/mine/focus">查看更多</a>
    </div>
  </div>
  <div class="w-focus-body">
    <div class="sld" id="j_sld_focus" data-min="4">
      <div class="wrap">
        <ul>
            @if(isset($follows) && count($follows) > 0)
                @foreach($follows as $follow)
                    <li><a href="{{$follow['url']}}"><img src="{{$follow['image']}}" alt=""></a></li>
                @endforeach
            @endif
        </ul>
      </div>
      <a href="javascript:;" class="prev">prev</a>
      <a href="javascript:;" class="next">next</a>
    </div>
  </div>
</div>
<!-- end focus -->
