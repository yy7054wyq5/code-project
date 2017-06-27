@extends('admin.adminbase')
@section('title', '帖子管理')
@section('content')
    <div class="dialog-demo-box" style="display:none;"></div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">帖子列表</h3>
        </div>
        <div class="box-body">
              <form action="/backstage/food/comments/{{$id}}" method="get">
                <div class="form-group">
                   {{--  <label for="" class="control-label col-sm-1">来源名称</label>
                    <div class="col-sm-3">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info  btn-xs">搜索</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default btn-xs">返回</a> --}}
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="40%">来源名称</th>
                        <th width="10%">帖子内容</th>
                        <th width="20%">用户昵称</th>
                        <th width="15%">用户头像</th>
                       {{--  <th width="15%">操作</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($lists) && count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td><button class="open btn" id="open"  data-content="{{$list['content']}}">查看</button></td>
                                <td>{{$list['nickname']}}</td>
                                <td><img src="/image/get/{{$list['picKey']}}" style="width:50px; height: 50px;" /> </td>
                                {{-- <td>
                                    @if($list['deleted'] == 0)
                                        <a href="/backstage/food/edit-comment/{{$list['id']}}" class="label label-success" >编辑</a>
                                        <a href="/backstage/food/remove-comment/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            @if(isset($pager))
                {!!$pager!!}
            @endif
        </div>
    </div>
    <script type="text/javascript" >
        $(function(){
            $(".open").click(function(){
                var $d = $(".dialog-demo-box");
                var $content = $(this).attr('data-content');
                $d.dialog({
                    title: '帖子内容',					// title
                    dragable:true,
                    cache:false,
                    html: '', 						// html template
                    width: 750,					// width
                    height: 400,				// height
                    confirmBtn:false,
                    cannelText: '关闭',		// cannel text
                    confirmText: '确认',	    // confirm text
                    showFooter:true,
                    getContent:function(){ 	// get Content callback
                        $d.find('.body-content').html($content);
                    }
                }).open();
            });
        });
    </script>
@endsection
