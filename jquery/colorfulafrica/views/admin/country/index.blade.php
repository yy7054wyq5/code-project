@extends('admin.adminbase')
@section('title', '国家管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">国家管理</h3>
        </div>
        <div class="box-body">
             <form action="/backstage/country/list" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">国家名称</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
                </form>
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.contactManage.editContact.id'),$jurisdiction))
                     <a href="{{url('/backstage/country/add-country')}}" class="btn btn-primary">新增国家</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="45%">国家名称</th>
                        <th width="45%">国家英文名称</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($data['lists']) && count($data['lists'])>0)
                        @foreach($data['lists'] as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['nameEn']}}</td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.countryManage.editCountry.id'),$jurisdiction))
                                             <a href="/backstage/country/edit-country/{{$list['id']}}?start={{Input::get('start',0)}}" class="label label-success" >详情</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.countryManage.removeCountry.id'),$jurisdiction))
                                             <a href="/backstage/country/remove/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
            {!!$data['pager']!!}
        </div>
    </div>
@endsection
