@extends('mine.fragment.layout')

@section('uc-content')

<div class="uc-main-main">
  <div class="uc-material">
    <div class="uc-material-header">
      <h3 class="title">我的素材</h3>
      <div class="side">
        <a href="/innovate/add-clip?from=2" class="update">上传素材</a>
        <a href="/innovate/clip">查看更多素材</a>
      </div>
    </div>
    <div class="uc-material-subheader">
      <div class="w-tab">
          <input type="hidden" name="pageTotal" value="{{$pageNum}}">
        <div class="w-tab-item @if(array_get($_GET, 'status', 0) == 0) active @endif" data-status="0">未审核的素材</div>
        <div class="w-tab-item  @if(array_get($_GET, 'status', 0) == 1) active @endif" data-status="1">审核过的素材</div>
        <div class="w-tab-item  @if(array_get($_GET, 'status', 0) == 2) active @endif" data-status="2">审核未通过的素材</div>
      </div>
      <div class="filter">
        <div class="search">
          <input type="text" name="keyword" value="{{array_get($_GET, 'keyword')}}">
          <a href="javascript:;" class="sbtn">搜索</a>
        </div>
      </div>
    </div>
    <div class="uc-material-body">
          @if(isset($materials) && count($materials)>0)
      <div class="goods">
              @foreach($materials as $material)
                  <div class="item">
                      <a href="/innovate/clip-detail/{{$material['materialId']}}" class="pic"><img src="/image/get/{{$material['imageId']}}" alt=""></a>
                      <a href="/innovate/clip-detail/{{$material['materialId']}}" class="title">{{$material['materialName']}}</a>
                      <div class="ft">
                          <a href="/user/api/deletematerial?materialId={{$material['materialId']}}">删除</a>
                          <a href="/innovate/edit-clip/{{$material['materialId']}}">编辑</a>
                      </div>
                  </div>
              @endforeach
      </div>
          @else
          <div class="noitem">暂无数据</div>
          @endif
    </div>
    <div class="uc-material-footer">
        <?php echo $pager ?>
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
            return reloadPage();
        });


        $('.redirect.btn').on('click', function(){
            var pageNum = $('input[name="pageNum"]').val(), pageTotal=$('input[name="pageTotal"]').val();
            if (pageNum && pageNum>=1 && pageNum<=pageTotal) return reloadPage(pageNum);
            if (pageNum && pageNum>=1 && pageNum>pageTotal) {
                $('input[name="pageNum"]').val(pageTotal);
                return reloadPage(pageTotal);
            }
        });

        $('.sbtn').on('click', function(){
            reloadPage()
        });


        function reloadPage() {
            var status = $('.w-tab-item.active').data('status'), page = arguments[0], keyword=$('input[name="keyword"]').val();
            var url = '/mine/material?status=' + status;
            if (page && page > 0) url += '&page=' + page;
            if (keyword) url += '&keyword=' + keyword;
            location.href = url;
            return false;
        }
    </script>
@endsection
