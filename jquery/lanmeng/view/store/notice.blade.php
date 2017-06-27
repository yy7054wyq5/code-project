@extends('layouts.main')

{{-- 关闭banner --}}
@section('banner')
@endsection

@section('header-scripts')
    <script src="/common/ueditor/ueditor.parse.min.js"></script>
    <script>
        uParse('.uecontent', {
            rootPath: '/public/common/ueditor'
        });</script>
@endsection
@section('content')
<div class="infor-detail-main">
<div class="container">
  <!-- 面包屑 -->
  <ol class="breadcrumb">
    <li><a href="/store/index" class="red-font" target="_self">商城</a></li>
    <li class="arrow"></li>
    <li class="current">商城公告</li>
  </ol>
  <!-- 资讯详情左边 -->
  <div class="infor-detail-left">
    <div class="article">
      <h1>{{$notice['title']}}</h1>
        <div role="tabpanel" class="tab-pane active uecontent" id="detail">
            <?php echo  htmlspecialchars_decode($notice['content'])?>
        </div>
    </div>
    <div class="myclear"></div>
  </div>
  <!-- 资讯详情右边 -->
  <div class="infor-detail-right">
    <div class="side-bar rank">
        <h2>其他公告</h2>
        <ul>
            @if(isset($notices) && count($notices)>0)
                @foreach($notices as $notice)
                    <li><a href="/store/notice/{{$notice['id']}}" target="_self" title="{{$notice['title']}}">{{$notice['title']}}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
  </div>
</div>
</div>
@endsection
<script>
    function store()
    {
        $.ajax({
            type: "POST",
            url:"/infor/addcomment",
            data:$('#form').serialize(),
            dataType: 'json',
            success: function(msg) {
                layer.msg(msg['tips'])
                if (!msg['url']) {
                    setTimeout("reload()", 1000)
                };
            },
            error: function(error){
                //layer.msg("操作失败")
            }
        });
    }
</script>
