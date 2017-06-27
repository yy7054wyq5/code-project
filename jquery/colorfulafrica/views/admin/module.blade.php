@extends('admin.adminbase')
@section('title', '模块列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">模块列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <p>
                    @if(in_array(\Illuminate\Support\Facades\Config::get('app.moduleManage.addLine.id'),$jurisdiction))
                    <a href="/backstage/system/addmodule" class="btn btn-primary">添加模块</a>
                    @endif
                </p>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>模块名</th>
                        <th>模块英文名</th>
                        <th>排序</th>
                        <th>url</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($modules)
                        @foreach($modules as $module)
                            <tr>
                                <td>{{$module['name']}}</td>
                                <td>{{$module['nameEn']}}</td>
                                <td>{{$module['sort']}}</td>
                                <td>无</td>
                                <td>
                                    @if(in_array(\Illuminate\Support\Facades\Config::get('app.moduleManage.editmodule.id'),$jurisdiction))
                                    <a href="/backstage/system/editmodule/{{$module['id']}}" class="label label-primary">编辑</a>
                                    @endif
                                    @if(in_array(\Illuminate\Support\Facades\Config::get('app.moduleManage.editmodule.id'),$jurisdiction))
                                    <a href="/backstage/system/removemodule/{{$module['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                    @endif
                                </td>
                            </tr>
                        @if (array_get($module, 'children') && count($module['children'])>0)
                            @foreach($module['children'] as $k=>$v)
                                <tr>
                                    <td style="text-align: left;" >@if($k+1 == count($module['children'])) {{ '&nbsp;&nbsp;&nbsp;└─ ' .$v['name'] }} @else {{ '&nbsp;&nbsp;&nbsp;├─ ' .$v['name'] }} @endif</td>
                                    <td>{{$v['nameEn']}}</td>
                                    <td>{{$v['sort']}}</td>
                                    <td>{{$v['url']}}</td>
                                    <td>
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.moduleManage.editmodule.id'),$jurisdiction))
                                        <a href="/backstage/system/editmodule/{{$v['id']}}" class="label label-primary">编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.moduleManage.delmodule.id'),$jurisdiction))
                                        <a href="/backstage/system/removemodule/{{$v['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        @endforeach
                    @else
                        <tr>
                            <td class="text-muted" colspan="10">未找到数据……</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
