@extends('admin.adminbase')
@section('title', '游记管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">游记列表</h3>
        </div>
        <div class="box-body">
            <form action="/backstage/travel/list" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">标题</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword"  value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <label for="" class="control-label col-sm-1">标签</label>
                    <div class="col-sm-2">
                        <input type="text" name="tag"  value="{{request('tag')? request('tag') : ''}}">
                    </div>
                    <label for="" class="control-label col-sm-1">板块</label>
                    <div class="col-sm-2">
                        <select name="category" >
                            <option value="0">----请选择----</option>
                            @foreach($categoryList as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th >标题</th>
                        <th >所属板块</th>
                        <th >发布者昵称</th>
                        <th >回帖数量</th>
                        <th >操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($travels)>0)
                        @foreach($travels as $travel)
                            <tr>
                                <td>{{$travel['name']}}</td>
                                <td>{{$travel['setion_name']}}</td>
                                <td>{{$travel['nickname']}}</td>
                                <td><a href="/backstage/travel/comments/{{$travel['id']}}" class="label label-default" >{{$travel['commentNum']}}</a></td>
                                <td>
                                    @if($travel['deleted'] == 0)
                                        <a href="/backstage/travel/examine/{{$travel['id']}}" class="label label-warning" >审核</a>
                                        @if($travel['status']==1)
                                        @if($travel['isRecommand']==0)
                                        <a href="/backstage/travel/recommend/{{$travel['id']}}" class="label label-primary">推荐</a>
                                        @else
                                        <a href="javascript:;"  data-id="{{$travel['id']}}" data-type="2" class="label label-primary unrecommand">取消推荐</a>
                                        @endif
                                        @endif

                                       {{--  <a href="/backstage/travel/edit-travel/{{$travel['id']}}" class="label label-success">编辑</a> --}}
                                        <a href="/backstage/travel/detail-travel/{{$travel['id']}}" class="label label-info">详情</a>
                                        <a href="/backstage/travel/remove-travel/{{$travel['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
            <?php echo $pager ?>
        </div>
         <script>
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
    </div>
@endsection