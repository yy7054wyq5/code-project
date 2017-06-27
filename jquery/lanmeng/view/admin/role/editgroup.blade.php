<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label">用户名称</label>
    <div class="col-sm-4">
        <input type="text" name="user[username]" class="form-control" value="@if(isset($info->username)){{$info->username}} @endif ">
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label">用户密码</label>
    <div class="col-sm-4">
        <input type="text" name="user[password]" class="form-control"  >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label">密码可修改</label>
    <div class="col-sm-4">
        <input type="radio" name="ismodify" value="1" checked=true  >可修改</input>
        <input type="radio" name="ismodify" value="0" >不可修改</input>
    </div>
</div>
<div class="form-group  add-group " style="display: none">
    <label class="col-sm-2 control-label"> 联系人</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[contacts]" class="form-control" value="@if(isset($info->contacts)){{$info->contacts}} @endif " >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label"> 电话</label>
    <div class="col-sm-4">
        <input type="text" name="user[mobile]"  class="form-control" value="@if(isset($info->mobile)){{$info->mobile}} @endif ">
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label"> 邮箱</label>
    <div class="col-sm-4">
        <input type="text" name="user[email]"  class="form-control" value="@if(isset($info->email)){{$info->email}} @endif ">
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label"> 公司名称</label>
    <div class="col-sm-4">
        <input type="text" name="user[realname]" class="form-control" value="@if(isset($info->realname)){{$info->realname}} @endif " >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label"> 网络代码</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[netcode]"  class="form-control" value="@if(isset($info->netcode)) {{$info->netcode}}@endif " >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label"> 公司所在地省市</label>
    <div class="col-sm-2">
        <select class="form-control province " onchange="changeCitys()" >
            @foreach($citys as $key => $value)
                <option value="{{$key}}" @if(isset($parentCity->id) && $parentCity->id==$key) selected="selected" @endif >{{$value}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-2">
        <select name="userinfo[city]" class="form-control city " >
            @if(isset($childCity->id))
            <option value="{{$childCity->id}}"  >{{$childCity->name}}</option>
            @endif
        </select>
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label"> 详细地址</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[address]"  class="form-control" value="@if(isset($info->address)){{$info->address}}@endif">
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label"> 税务登记号</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[taxnum]"  class="form-control" value="@if(isset($info->taxnum)){{$info->taxnum}} @endif " >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label">开户行</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[bank]"  class="form-control" value="@if(isset($info->bank)) {{$info->bank}} @endif " >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label">开户账号</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[account]"   class="form-control" value="@if(isset($info->account)){{$info->account}} @endif " >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label">官方微博</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[weibo]"  class="form-control" value="@if(isset($info->weibo)){{$info->weibo}} @endif " >
    </div>
</div>
<div class="form-group add-group " style="display: none">
    <label class="col-sm-2 control-label">微信公众号</label>
    <div class="col-sm-4">
        <input type="text" name="userinfo[weixin]" class="form-control" value="@if(isset($info->weixin)){{$info->weixin}} @endif" >
    </div>
</div>

