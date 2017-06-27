<div class="box-body big">
    @if(Input::get('type') != 'group')
    <form class="form-horizontal" role="form" onsubmit="return false;">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-sm-2 control-label">品牌</label>
            <div class="col-sm-4">
                <select name="user[bid]" onchange="changeBrand(this);" class="form-control brand">
                    <option value="">请选择</option>
                    @if(isset($brand[0]))
                    @foreach($brand as $value)
                    <option @if($value->brandId == $info->bid) selected @endif value="{{ $value->brandId }}">{{ $value->brandName }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">公司名称</label>
            <div class="col-sm-4">
                <input type="text" name="user[company]" value="{{ $info->company }}" class="form-control" placeholder="请输入公司名称">
            </div>
        </div>
       <div class="form-group">
            <label class="col-sm-2 control-label">公司所在地</label>
            <div class="col-sm-2">
                <select name="user[province]" onchange="getCity(this);" class="form-control col-sm-2 province">
                    <option value="">请选择省市</option>
                    @if ($lists)
                    @foreach ($lists as $value)
                    <option @if($value->id == $info->province) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-2">
                <select name="user[city]" onchange="changeCity(this);" class="form-control col-sm-2 city">
                    <option value="{{ $info->city }}">{{ $info->cityname }}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">详细地址</label>
            <div class="col-sm-4">
                <input type="text" name="user[address]" onchange="changeAddress(this);" value="{{ $info->address }}" class="form-control address" placeholder="请输入公司详细地址">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">税务登记号</label>
            <div class="col-sm-4">
                <input type="text" name="user[taxnum]" onchange="changeTaxnum(this)" value="{{ $info->taxnum }}" class="form-control taxnum" placeholder="请输入税务登记号">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">开户行</label>
            <div class="col-sm-4">
                <input type="text" name="user[bank]" onchange="changeBank(this)" value="{{ $info->bank }}" class="form-control bank" placeholder="请输入开户行">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">开户账号</label>
            <div class="col-sm-4">
                <input type="text" name="user[account]" onchange="changeAccount(this)" value="{{ $info->account }}" class="form-control account" placeholder="请输入开户账号">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
                <button type="submit" onclick="return update();" class="btn btn-primary">确认</button>
                <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
            </div>
        </div>
    </form>
    @else
    <form class="form-horizontal" role="form" onsubmit="return false;">
    <div class="form-group">
        <label class="col-sm-2 control-label">公司名称</label>
        <div class="col-sm-4">
            <input type="text" disabled value="{{ $info->company }}" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">网络代码</label>
        <div class="col-sm-4">
            <input type="text" disabled value="{{ $info->netcode }}" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">公司所在地</label>
        <div class="col-sm-2">
            <select name="user[province]" onchange="getCity(this);" class="form-control col-sm-2 province">
                <option value="">请选择省市</option>
                @if ($lists)
                @foreach ($lists as $value)
                <option @if($value->id == $info->province) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-2">
            <select name="user[city]" onchange="changeCity(this);" class="form-control col-sm-2 city">
                <option value="{{ $info->city }}">{{ $info->cityname }}</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">详细地址</label>
        <div class="col-sm-4">
            <input type="text" disabled onchange="changeAddress(this);" value="{{ $info->address }}" class="form-control address" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">经销商级别</label>
        <div class="col-sm-4">
            <select name="user[type]" class="form-control">
                <option value="0">无</option>
                @foreach (Config::get('other.validate') as $key => $value)
                <option @if($key == $info->type) selected @endif value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">税务登记号</label>
        <div class="col-sm-4">
            <input type="text" disabled onchange="changeTaxnum(this)" value="{{ $info->taxnum }}" class="form-control taxnum" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">开户行</label>
        <div class="col-sm-4">
            <input type="text" disabled onchange="changeBank(this)" value="{{ $info->bank }}" class="form-control bank" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">官方微博</label>
        <div class="col-sm-4">
            <input type="text" disabled value="{{ $info->weibo }}" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">微信公众号</label>
        <div class="col-sm-4">
            <input type="text" disabled value="{{ $info->weixin }}" class="form-control" />
        </div>
    </div>
    </form>
    @endif
</div>