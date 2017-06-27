<div class="form-group add-logistics " style="display: none">
    <label class="col-sm-2 control-label">用户名称</label>
    <div class="col-sm-4">
        <input type="text" name="logistics[username]" class="form-control" placeholder="请输入用户名称">
    </div>
</div>
<div class="form-group add-logistics" style="display: none">
    <label class="col-sm-2 control-label">用户密码</label>
    <div class="col-sm-4">
        <input type="text" name="logistics[password]" class="form-control" placeholder="如果不修改密码请留空">
    </div>
</div>
<div class="form-group  add-logistics " style="display: none">
    <label class="col-sm-2 control-label">物流公司</label>
    <div class="col-sm-4">
        <select name="logistics[realname]" class="form-control"   >
            <option value="">请选择物流公司</option>
            @foreach(Config::get('logistics') as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>



