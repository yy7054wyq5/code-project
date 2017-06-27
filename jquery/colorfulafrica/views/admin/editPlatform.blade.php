@extends('admin.adminbase')

@section('title', '更新平台管理员')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">更新平台管理员</h3>
        </div>
        <form action="<?=url('/backstage/account/update-plat')?>" class="form-horizontal" method="post" m-bind="ajax">
            <input type="hidden" name="_token" value="{{csrf_token() }}">
            <input type="hidden" name="userId" value="{{$platformUser['id'] }}">
            <input type="hidden" name="start" value="{{Input::get('start',0)}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">所属角色</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="roleId"  style="text-align: center;" >
                            @if(count($roles) == 0)
                               <option value="0" >=====请选择====</option>
                            @else
                                @foreach($roles as $key => $value)
                                    <option value="{{$value}}" @if($platformUser['roleId'] == $value) selected="selected"  @endif>{{$key}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请选择所属角色</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">用户名</label>
                    <div class="col-sm-4">
                        <input name="uname" type="text" class="form-control" value="{{ $platformUser['uname'] }}">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入用户名</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">密码</label>
                    <div class="col-sm-4">
                        <input name="password" type="password" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入密码</p>
                    </div>
                </div>


                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required">确认密码</label>
                    <div class="col-sm-4">
                        <input name="password_repeat" type="password" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请确认密码</p>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认更新</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
@endsection