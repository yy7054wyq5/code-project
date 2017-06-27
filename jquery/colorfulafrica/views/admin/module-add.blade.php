@extends('admin.adminbase')

@section('title', '新增模块')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增模块</h3>
        </div>
        <form action="backstage/system/addmodule" class="form-horizontal" method="post" m-bind="ajax">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 required">父模块</label>
                    <div class="col-sm-4">
                        <select name="parentId" id="parentId" class="form-control" style="display: inline-block;width: auto;">
                            <option value="0">主模块</option>
                            @if(isset($modules) && count($modules)>0)
                            @foreach($modules as $module)
                                    <option value="{{$module['id']}}">{{$module['name']}}</option>
                                @foreach($module['children'] as  $children_module)
                                        <option value="{{$children_module['id']}}">{{$children_module['name']}}</option>
                                @endforeach
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请选择父模块</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 required">模块名</label>
                    <div class="col-sm-4">
                        <input name="name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入模块名</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2 required">模块英文名</label>
                    <div class="col-sm-4">
                        <input name="nameEn" type="text" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入模块英文名</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2 required">排序</label>
                    <div class="col-sm-4">
                        <input name="sort" type="text" class="form-control" value="0">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">越大越靠前</p>
                    </div>
                </div>

                <div class="level2" style="display: none">
                    <div class="form-group">
                        <label class="control-label col-sm-2 required">模块链接</label>
                        <div class="col-sm-4">
                            <input name="url" type="text" class="form-control" value="0">
                        </div>
                        <div class="col-sm-6">
                            <p class="form-control-static text-muted small">请输入模块链接</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认添加</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    @parent
    <script>
        $(function(){
            $(document).on('change', '#parentId', function () {
                if ($(this).val() > 0) {
                    $('.level2').show();
                } else {
                    $('.level2').hide();
                }
            });
        });
    </script>
@endsection
