        <div class="form-group add-ordinary  ">
            <label class="col-sm-2 control-label">用户名称</label>
            <div class="col-sm-4">
                <input type="text" name="admin[username]" class="form-control" placeholder="请输入管理员名称">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
            </div>
        </div>
        <div class="form-group add-ordinary  ">
            <label class="col-sm-2 control-label">用户密码</label>
            <div class="col-sm-4">
                <input type="text" name="admin[password]" class="form-control" placeholder="请输入管理员密码">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
            </div>
        </div>
        <div class="form-group add-ordinary  ">
            <label class="col-sm-2 control-label">真实姓名</label>
            <div class="col-sm-4">
                <input type="text" name="admin[realname]" class="form-control" placeholder="请输入管理员真实姓名">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
            </div>
        </div>
        <div class="form-group add-ordinary  ">
            <label class="col-sm-2 control-label">手机号码</label>
            <div class="col-sm-4">
                <input type="text" name="admin[mobile]" class="form-control" placeholder="请输入管理员电话">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
            </div>
        </div>
        <div class="form-group add-ordinary  ">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-4">
                <input type="text" name="admin[email]" class="form-control" placeholder="请输入管理员Email">
            </div>
            <div class="col-sm-4">
                <p class="text-muted small form-control-static"><font color="red">*必填</font></p>
            </div>
        </div>
        <!-- <div class="form-group add-ordinary  ">
            <label class="col-sm-2 control-label">权限</label>
            <div class="col-sm-8">
                @if ($brand)
                    <table class="table table-striped">
                        <thead>
                        <th style="width:100px;">全选</th>
                        <th>权限</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="width:100px;"><input type="checkbox" id="checkall"></td>
                            <td>
                                @foreach ($brand as $value)
                                    <label style="float:left;" class="checkbox-inline">
                                        <input type="checkbox" name="admin[role][]" value="{{ $value->brandId }}">{{ $value->brandName }}
                                    </label>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div> -->
