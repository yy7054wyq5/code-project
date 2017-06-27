<!-- hot -->
<div class="uc-hot">
  <div class="uc-hot-header">
    <div class="title">多多推荐<small>Best buy</small></div>
  </div>
    <div class="uc-hot-body">
    @if(isset($recommends) && count($recommends) > 0)
        @foreach($recommends as $recommend)
                <div class="uc-hot-item">
                    <a href="/commodity/detail/{{$recommend['id']}}" class="pic"><img src="/image/get/{{$recommend['cover']}}" alt=""></a>
                    <a href="/commodity/detail/{{$recommend['id']}}" class="title">{{$recommend['name']}}</a>
                    <div class="price">&yen;{{$recommend['minPrice']}}</div>
                </div>
        @endforeach
    @endif
    {{--<div class="uc-hot-item">--}}
      {{--<a href="#" class="pic"><img src="//placehold.it/1000" alt=""></a>--}}
      {{--<a href="#" class="title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam, optio.</a>--}}
      {{--<div class="price">&yen;19.80</div>--}}
    {{--</div>--}}
    {{--<div class="uc-hot-item">--}}
      {{--<a href="#" class="pic"><img src="//placehold.it/1000" alt=""></a>--}}
      {{--<a href="#" class="title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam, optio.</a>--}}
      {{--<div class="price">&yen;19.80</div>--}}
    {{--</div>--}}
  </div>
</div>
<!-- end hot -->
