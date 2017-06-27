        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label">用户名称</label>
            <div class="col-sm-4">
                <input type="text" name="user[username]" class="form-control" placeholder="请输入用户名称">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label">用户密码</label>
            <div class="col-sm-4">
                <input type="text" name="user[password]" class="form-control" placeholder="如果不修改密码请留空">
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
                <input type="text" name="userinfo[contacts]" class="form-control" placeholder="请输入联系人">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label"> 电话</label>
            <div class="col-sm-4">
                <input type="text" name="user[mobile]"  class="form-control" placeholder="请输入用户电话">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label"> 邮箱</label>
            <div class="col-sm-4">
                <input type="text" name="user[email]"  class="form-control" placeholder="请输入用户邮箱">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label"> 公司名称</label>
            <div class="col-sm-4">
                <input type="text" name="user[realname]" class="form-control" placeholder="请输入公司名称">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label"> 网络代码</label>
            <div class="col-sm-4">
                <input type="text" name="userinfo[netcode]"  class="form-control" placeholder="请输入网络代码">
            </div>
        </div>
        <div class="form-group add-group" style="display: none">
            <label class="col-sm-2 control-label"> 公司所在地省市</label>
            <div class="col-sm-2">
                <select class="form-control province" onchange="changeCitys()">
                    <option>请选择</option>
                    @foreach($citys as $key => $value)
                        <option value="{{$key}}" >{{$value}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select name="userinfo[city]" class="form-control city" >
                </select>
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label"> 详细地址</label>
            <div class="col-sm-4">
                <input type="text" name="userinfo[address]"  class="form-control" placeholder="请输入详细地址">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label"> 税务登记号</label>
            <div class="col-sm-4">
                <input type="text" name="userinfo[taxnum]"  class="form-control" placeholder="请输入税务登记号">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label">开户行</label>
            <div class="col-sm-4">
                <input type="text" name="userinfo[bank]"  class="form-control" placeholder="请输入开户行">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label">开户账号</label>
            <div class="col-sm-4">
                <input type="text" name="userinfo[account]"   class="form-control" placeholder="请输入开户账号">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label">官方微博</label>
            <div class="col-sm-4">
                <input type="text" name="userinfo[weibo]"  class="form-control" placeholder="请输入官方微博">
            </div>
        </div>
        <div class="form-group add-group " style="display: none">
            <label class="col-sm-2 control-label">微信公众号</label>
            <div class="col-sm-4">
                <input type="text" name="userinfo[weixin]" class="form-control" placeholder="请输入微信公众号">
            </div>
        </div>

