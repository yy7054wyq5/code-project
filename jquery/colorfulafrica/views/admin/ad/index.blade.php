@extends('admin.adminbase')
@section('title', '广告管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">广告管理</h3>
        </div>
        <div class="box-body">
            <form action="/backstage/adinfo/ad" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">广告名称</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
            </form>
            <p>@if(in_array(\Illuminate\Support\Facades\Config::get('app.ad.addAd.id'),$jurisdiction))
                    <a href="{{url('/backstage/adinfo/add-ad')}}" class="btn btn-primary">新增广告</a> @endif </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>广告名称</th>
                        <th>英文广告名称</th>
                        <th>广告所属模块</th>
                        <th>广告发布时间</th>
                        <th>广告跳转链接</th>
                        <th>广告缩略图</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($ads)
                        @foreach($ads as $ad)
                            <tr>
                                <td>{{$ad['name']}}</td>
                                <td>{{$ad['nameEn']}}</td>
                                <td>{{$ad['type']}}</td>
                                <td>{{$ad['createTime']}}</td>
                                <td>{{$ad['link']}}</td>
                                <td><img src="/image/get/{{$ad['picKey']}}" style="width:50px; height: 50px;" /> </td>
                                <td>
                                    @if($ad['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.ad.editAd.id'),$jurisdiction))
                                            <a href="/backstage/adinfo/edit-ad/{{$ad['id']}}/{{$start}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.ad.delAd.id'),$jurisdiction))
                                            <a href="/backstage/adinfo/remove-ad/{{$ad['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
    </div>
@endsection