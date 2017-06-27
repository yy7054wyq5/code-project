@extends('admin.adminbase')
@section('title', '版块管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">版块管理</h3>
        </div>
        <div class="box-body">
            <p><a href="{{url('/backstage/travel/add-category')}}" class="btn btn-primary">新增版块</a></p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="35">版块名称</th>
                        <th width="35%">版块英文名称</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($categories)>0)
                        @foreach($categories as $categorie)
                            <tr>
                                <td>{{$categorie['name']}}</td>
                                <td>{{$categorie['nameEn']}}</td>
                                <td>
                                    @if($categorie['deleted'] == 0)
                                        <a href="/backstage/travel/edit-category/{{$categorie['id']}}" class="label label-success" >编辑</a>
                                        <a href="/backstage/travel/remove-category/{{$categorie['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
            <?php //echo $pager ?>
        </div>
    </div>
@endsection