@extends('admin.adminbase')
@section('title', '城市管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">城市管理</h3>
        </div>
        <div class="box-body">
             <form action="/backstage/system/city" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">城市名称</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info  btn-xs">搜索</button>
                </div>
                </form>
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.cityManage.addCity.id'),$jurisdiction))
                   <a href="{{url('/backstage/system/add-city')}}" class="btn btn-primary">新增城市</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="45%">城市名称</th>
                        <th width="45%">城市英文名称</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($lists) && count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['nameEn']}}</td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.cityManage.editCity.id'),$jurisdiction))
                                           <a href="/backstage/system/edit-city/{{$list['id']}}?start={{Input::get('start',0)}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.cityManage.removeCity.id'),$jurisdiction))
                                           <a href="/backstage/system/remove-city/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
@endsection
