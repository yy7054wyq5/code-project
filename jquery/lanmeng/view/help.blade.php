@extends('login')

@section('header-search')
    <p class="login-header">帮助中心</p>
@endsection

@section('content')
    <div class="help-main">
        <div class="container">
            <div class="page-left">
                <h1>常见问题分类</h1>
                @if(isset($category) && count($category)>0 )
                    @foreach($category as $key => $item)
                        <div @if($item['typeId'] == $result['typeId']) class="h-nav-title" @else class=" active h-nav-title" @endif >
                            <span>{{$item['typeName']}}</span>
                            <i></i>
                        </div>
                        <ul @if($item['typeId'] == $result['typeId']) class="h-nav-con active " style="display: block;"   @else class="h-nav-con"   @endif >
                            @foreach($item['sub'] as $k => $subitem)
                                <li id="li_{{$k+1}}}" @if($subitem['articleId'] == $active) class=" active"  @endif ><a href="/help/{{$subitem['articleId']}}">{{$subitem['articleTitle']}}</a></li>
                            @endforeach
                        </ul>
                    @endforeach
                @endif
            </div>
            <div class="page-right">
                @if(isset($result) && count($result)>0)
                <div class="bread"> {{$result['typeName']}} > {{$result->articleTitle}}</div>
                <h2>{{$result->articleTitle}}</h2>
                <div class="article">
                    {!!$result->articleContent!!}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('footer-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.h-nav-title').on('click', function(event) {
                var $navCon = $(this).next('.h-nav-con');
                if($navCon.hasClass('acitve')){
                    $(this).removeClass('active');
                    $navCon.removeClass('acitve').slideUp();
                }
                else{
                    $(this).addClass('active');
                    $navCon.slideDown(function() { $(this).addClass('acitve') ;});
                }
            });
        });
    </script>
@endsection
