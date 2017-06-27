@extends('admin.adminbase')
@section('title', '美食管理')
@section('content')
    <div class="dialog-demo-box" style="display:none;"></div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">美食管理</h3>
        </div>
        <div class="box-body">
            <form action="/backstage/food/list" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">美食标题</label>
                    <div class="col-sm-3">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <label for="" class="control-label col-sm-1">美食分类</label>
                    <div class="col-sm-2">
                        <select name="category">
                            <option value="0">---请选择---</option>
                            @foreach($category as $item)
                            <option value="{{$item['id']}}" >{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
            </form>
           <p>
               @if(in_array(\Illuminate\Support\Facades\Config::get('app.foodManage.addFood.id'),$jurisdiction))
                <a href="{{url('/backstage/food/add-foods')}}" class="btn btn-primary">新增美食</a>
               @endif
           </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th >美食标题</th>
                        <th >英文美食标题</th>
                        <th >点赞数</th>
                        <th>评价</th>
                        <th >详情</th>
                        <th >美食发布时间</th>
                        <th >美食缩略图</th>
                        <th >操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['nameEn']}}</td>
                                <td>{{$list['thumbNum']}}</td>
                                <td><a href="/backstage/food/comments/{{$list['id']}}" class="label label-default" >{{$list['commentNum']}}</a></td>
                                <td><button class="open btn" id="open" data-content="{{$list['detail']}}"  >查看</button></td>
                                <td>{{$list['createTime']}}</td>
                                <td><img src="/image/get/{{$list['picKey']}}" style="width:50px; height: 50px;"  /></td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.foodManage.editFood.id'),$jurisdiction))
                                           <a href="/backstage/food/edit-foods/{{$list['id']}}/{{$start}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.foodManage.recommend.id'),$jurisdiction))
                                        @if($list['isRecommand']==0)

                                           <a href="/backstage/food/recommend/{{$list['id']}}" class="label label-primary" >推荐</a>
                                        @else
                                           <a href="javascript:;" data-type="3" data-id="{{$list['id']}}" class="label label-primary unrecommand" >取消推荐</a>
                                        @endif
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.foodManage.removeFood.id'),$jurisdiction))
                                            <a href="/backstage/food/remove-food/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <?php echo isset($pager) ? $pager : '' ?>
        </div>
    </div>
    <script type="text/javascript" >
        $(function(){
            $(".open").click(function(){
                var $d = $(".dialog-demo-box");
                var $content = $(this).attr('data-content');
                $d.dialog({
                    title: '美食详情',					// title
                    dragable:true,
                    cache: false,
                    html: '', 						// html template
                    width: 750,					// width
                    height: 400,				// height
                    confirmBtn:false,
                    cannelText: '取消',		// cannel text
                    confirmText: '确认',	    // confirm text
                    showFooter:true,
                    getContent:function(){ 	// get Content callback
                        $d.find('.body-content').html($content);
                    }
                }).open();
            });
        });
        $(function () {
            $('.unrecommand').on('click',function(){
                $('.btn').attr('disabled',true);
                $.post('/backstage/index/unrecommand',{'id':$(this).attr('data-id'),'type':$(this).attr('data-type')},function(res){
                    res = JSON.parse(res);
                    alert(res.msg);
                   location=location;
                });
            });
        });
    </script>
@endsection