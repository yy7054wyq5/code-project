@extends('admin.adminbase')
@section('title', '资讯管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">资讯管理</h3>
        </div>
        <div class="box-body">
            <form action="/backstage/adinfo/info" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">资讯标题</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
            </form>
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.info.addInfo.id'),$jurisdiction))
                   <a href="{{url('/backstage/adinfo/add-info')}}" class="btn btn-primary">新增资讯</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th >资讯标题</th>
                        <th >英文资讯标题</th>
                        <th >资讯缩略图</th>
                        <th >发布时间</th>
                        <th >操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($infos)
                        @foreach($infos as $infos)
                            <tr>
                                <td>{{$infos['name']}}</td>
                                <td>{{$infos['nameEn']}}</td>
                                <td><img src="/image/get/{{$infos['picKey']}}" style="width: 60px; height: 60px;" /></td>
                                <td>{{$infos['createTime']}}</td>
                                <td>
                                    @if($infos['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.info.editInfo.id'),$jurisdiction))
                                            <a href="/backstage/adinfo/edit-info/{{$infos['id']}}/{{$start}}" class="label label-success" >详情</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.info.delInfo.id'),$jurisdiction))
                                        @if($infos['isRecommand'] ==0)
                                           <a href="/backstage/adinfo/recommend-info/{{$infos['id']}}" class="label label-info" >推荐</a>
                                        @else
                                           <a href="javascript:;" data-id="{{$infos['id']}}" data-type="1" class="label label-info unrecommand" >取消推荐</a>
                                         @endif
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.info.delInfo.id'),$jurisdiction))
                                                <a href="/backstage/adinfo/remove-info/{{$infos['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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