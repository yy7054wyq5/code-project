@extends('admin.adminbase')
@section('title', '线上商城')
@section('content')
    <div class="dialog-demo-box" style="display:none;"></div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">线上商城</h3>
        </div>
        <div class="box-body">
             <form action="/backstage/commodity/online-mall" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">商品名称</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
                </form>
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.commodityManage.addCommodity.id'),$jurisdiction))
                   <a href="{{url('/backstage/commodity/add-product')}}" class="btn btn-primary">新增商品</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>商品英文名称</th>
                        <th>商品价格</th>
                        <th>缩略图</th>
                        <th>商品评论</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['nameEn']}}</td>
                                <td>{{$list['price']}}</td>
                                <td><img src="/image/get/{{$list['picKey']}}" style="width:50px; height: 50px;" /> </td>
                                <td><a href="/backstage/commodity/comments/{{$list['id']}}" class="label label-default" >查看评论</a></td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.commodityManage.editCommodity.id'),$jurisdiction))
                                            <a href="/backstage/commodity/edit-product/{{$list['id']}}?start={{Input::get('start',0)}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.commodityManage.recommend.id'),$jurisdiction))
                                        @if($list['isRecommand'] ==0)
                                           <a href="/backstage/commodity/recommend/{{$list['id']}}" class="label label-primary" >推荐</a>
                                           @else
                                           <a href="javascript:;"  data-id="{{$list['id']}}" data-type="5" class="label label-primary unrecommand">取消推荐</a>
                                           @endif
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.commodityManage.removeCommodity.id'),$jurisdiction))
                                            <a href="/backstage/commodity/remove-commodity/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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