@extends('admin.adminbase')
@section('title', '关于我们列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">关于我们列表</h3>
        </div>
        <div class="box-body">
            <p>@if(in_array(\Illuminate\Support\Facades\Config::get('app.ad.addAd.id'),$jurisdiction))
                    <a href="{{url('/backstage/about/add-about')}}" class="btn btn-primary">新增</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="35%" >标题</th>
                        <th width="35%" >英文标题</th>
                        <th width="20%">发布时间</th>
                        <th width="10%" >操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($abouts)>0)
                        @foreach($abouts as $about)
                            <tr>
                                <td>{{$about['name']}}</td>
                                <td>{{$about['nameEn']}}</td>
                                <td>{{$about['createTime']}}</td>
                                <td>
                                    @if($about['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.aboutManage.editabout.id'),$jurisdiction))
                                            <a href="/backstage/about/edit-about/{{$about['id']}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.aboutManage.addabout.id'),$jurisdiction))
                                            <a href="/backstage/about/remove-about/{{$about['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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