@extends('mine.fragment.layout')

@section('uc-content')

<!-- deal -->
<div class="uc-deal">
  <div class="uc-deal-header">
    <div class="title">我的交易</div>
  </div>
  <div class="uc-deal-body">
    <div class="w-tab">
        <input type="hidden" name="pageTotal" value="{{$pageNum}}">
      <div class="w-tab-item @if(array_get($_GET, 'status', 0) == 0) active @endif" data-status="0"><a href="">进行中</a></div>
      <div class="w-tab-item @if(array_get($_GET, 'status', 0) == 1) active @endif" data-status="1"><a href="">已结束</a></div>
    </div>
    <table class="uc-deal-tb">
      <colgroup span="1" width="33.3333%"></colgroup>
      <colgroup span="5" width="11.1111%"></colgroup>
      <thead>
        <tr>
          <th>物品</th>
          <th>
            <div class="w-drop">
              <a href="#" class="w-drop-toggle" data-type="{{array_get($_GET, 'type',-1)}}">@if(array_get($_GET, 'type',-1) == -1) 全部状态 @elseif(array_get($_GET, 'type',-1) == 0) 求购 @else 出售 @endif </a>
              <div class="w-drop-menu">
                <a href="" class="w-drop-item" data-type="-1">全部状态</a>
                <a href="" class="w-drop-item" data-type="0">求购</a>
                <a href="" class="w-drop-item" data-type="1">出售</a>
              </div>
            </div>
          </th>
          <th>发布时间</th>
          <th>回复数</th>
          <th>最后回复</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($tradings) && count($tradings)>0)
        @foreach($tradings as $trading)
        <tr>
          <td class="title"><a href="#">{{ $trading['title'] }}</a></td>
          <td>{{ $trading['type'] == 0 ? "求购" : "出售" }}</td>
          <td>{{ date('Y-m-d', $trading['created']) }}<br>{{ date('H:i', $trading['created']) }}</td>
          <td>{{$trading['lastComment']?$trading['lastComment']['cnt'] :0}}</td>
          <td>{{$trading['lastComment']?date('Y-m-d H:i:s', $trading['lastComment']['created']) :''}}<br>{{$trading['lastComment']? $trading['lastComment']['userInfo']['username']:''}}</td>
          <td>
            <a href="/deal/edit-business/{{$trading['id']}}">编辑</a>
            <a href="/user/api/deletedeal?tradingId={{$trading['id']}}">删除</a>
          </td>
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="6">暂无数据</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
  <div class="uc-deal-footer">
      <?php echo $pager ?>

  </div>
</div>
<!-- end deal -->

@include('mine.fragment.focus-lg')

@endsection

@section('footer-scripts')
    @parent
    <script>
        $('.w-drop-item').on('click', function(){
            var dropObj = $('.w-drop-toggle');
            dropObj.data('type', $(this).data('type'));
            dropObj.text($(this).text());
            return reloadPage();
        });

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

        function reloadPage() {

            var type = $('.w-drop-toggle').data('type'), status = $('.w-tab-item.active').data('status'), page = arguments[0];
            var url = '/mine/deal?type='+type + '&status='+status;
            if (page && page > 0) url += '&page=' + page;
            location.href = url;
            return false;
        }
    </script>
@endsection
