@extends('mine.fragment.layout')
@section('uc-content')
<div class="uc-main-main">
  <div class="uc-case">
    <div class="uc-case-header">
      <h3 class="title">我的案例</h3>
      <div class="side">
        <a href="/innovate/add-example?from=2" class="update">上传案例</a>
        <a href="/innovate/example">查看更多案例</a>
      </div>
    </div>
    <div class="uc-case-subheader">
      <div class="w-tab">
        <div class="w-tab-item @if(!array_get($_GET,'type') || array_get($_GET,'type') == 1) active @endif" data-type="1">我上传的</div>
        <div class="w-tab-item @if(array_get($_GET,'type') == 2) active @endif" data-type="2">我评论的</div>
      </div>

      <div class="filter">
        <div class="search">
          <input type="text" name="keyword" value="{{array_get($_GET, 'keyword')}}">
          <a href="#" class="sbtn">搜索</a>
        </div>
        <select id="category">
          <option value="0">全部分类</option>
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $key=>$category)
                    <option value="{{$key}}" @if(array_get($_GET,'category') == $key) selected @endif>{{$category}}</option>
                @endforeach
            @endif
        </select>
        <select id="status">
          <option value="-1" @if(array_get($_GET,'status', -1) == 0) selected @endif>全部状态</option>
          <option value="0" @if(array_get($_GET,'status', -1) == 0) selected @endif>审核中</option>
          <option value="1" @if(array_get($_GET,'status', -1) == 1) selected @endif>审核通过</option>
          <option value="2" @if(array_get($_GET,'status', -1) == 2) selected @endif>审核未通过</option>
        </select>
      </div>
    </div>
    <div class="uc-case-body">
        @if(isset($cases) && count($cases)>0)
        <div class="goods">
            @foreach($cases as $case)
            <div class="item">
                <a href="/innovate/example-detail/{{$case['caseProductId']}}" class="pic"><img src="{{$case['path']}}" alt=""></a>
                <a href="/innovate/example-detail/{{$case['caseProductId']}}" class="title">{{$case['caseName']}}</a>
                <div class="ft">
                    <a href="/user/api/deletecase?caseId={{$case['caseProductId']}}">删除</a>
                    <a href="/innovate/edit-example/{{$case['caseProductId']}}">编辑</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="noitem">暂无数据</div>
        @endif
    </div>
      <?php echo $pager?>
    <div class="uc-case-footer">
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
  @include('mine.fragment.focus')
</div>
<div class="uc-main-side">
@include('mine.fragment.hot')
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('.w-tab-item').on('click', function(){
            $('.w-tab-item').removeClass('active');
            $(this).addClass('active');
            reloadPage();
        });

        $('.sbtn').on('click', function(){
            reloadPage();
        });

        $('#category').on('change', function(){
            reloadPage();
        });

        $('#status').on('change', function(){
            reloadPage();
        });


        function reloadPage() {
            var type = $('.w-tab-item.active').data('type'), page = arguments[0] ? arguments[0] : 1;
            var url = '/mine/case?type='+type + '&page='+page;
            var keyword = $('input[name="keyword"]').val();
            if (keyword) url += '&keyword=' + keyword;
            var category = $('#category').val();
            if (category) url += '&category=' + category;
            var status = $('#status').val();
            if (status) url += '&status=' + status;
            location.href = url;
        }
    </script>
@endsection
