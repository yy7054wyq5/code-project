@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-auth" id="j_uc_auth">
    <div class="uc-auth-header">
      <div class="title">我的认证</div>
    </div>
    <div class="uc-auth-body">
      <div class="w-step w-step-auth">
        <div class="w-step-item on">
          <i>1</i><span>填写资料</span>
        </div>

        <div class="w-step-item @if(array_get($userInfo, 'step') >= 1) on @endif">
          <i>2</i><span>上传扫描件</span>
        </div>
        <div class="w-step-item @if(array_get($userInfo, 'step') >= 2) on @endif">
          <i>3</i><span>审核中</span>
        </div>
        <div class="w-step-item @if(array_get($userInfo, 'step') >= 3) on @endif">
          <i class="check"></i><span>审核通过</span>
        </div>
      </div>
        @if(array_get($userInfo, 'status')==2)
      <div class="uc-auth-result">{{array_get($userInfo['info'], 'reason')}}</div>
        @endif
        @if (array_get($userInfo, 'step')==0 || array_get($userInfo, 'step')==1)
      <!-- step1 -->
      <div class="uc-auth1 @if(array_get($userInfo, 'step') == 0) active @endif">
        <p class="uc-auth1-title">请填写认证类型及内容，经销商认证成功后可进入素材库进行下载对应品牌素材</p>
        <form id="authform" autocomplete="off" novalidate>
          <input type="hidden" class="i-ipt" name="userInfoId" id="userInfoId" value="{{ array_get($userInfo['info'], 'id') ? array_get($userInfo['info'], 'id'):''}}">

          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><b>*</b>认证类型：</div>
            <div class="uc-auth1-cont">
              <label><input type="radio" name="groupType" value="6" @if($userInfo['usergroup']==6 || !in_array($userInfo['usergroup'],[6,7,8])) checked @endif> 经销商</label>
              <label><input type="radio" name="groupType" value="7" @if($userInfo['usergroup']==7) checked @endif> 区域经销商</label>
              <label><input type="radio" name="groupType" value="8" @if($userInfo['usergroup']==8) checked @endif> 合作伙伴</label>
              <div class="help"></div>
            </div>
          </div>

          <!-- type 1 2 -->
          <div class="uc-auth1-row type1 type2 @if($userInfo['usergroup']==6 || $userInfo['usergroup']==7|| !in_array($userInfo['usergroup'],[6,7,8])) show @endif">
            <div class="uc-auth1-label"><b>*</b>品牌：</div>
            <div class="uc-auth1-cont">
              <select name="bid" class="i-ipt">
                  @if(isset($brands) && count($brands)>0)
                      @foreach($brands as $brand)
                          <option value="{{$brand['brandId']}}" @if($brand['brandId'] == array_get($userInfo['info'], 'bid')) selected @endif>{{$brand['brandName']}}</option>
                      @endforeach
                  @endif
              </select>
              <div class="help"></div>
            </div>
          </div>

          <!-- type 1 2 3 -->
          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><b>*</b>公司名称：</div>
            <div class="uc-auth1-cont">
              <input type="text" class="i-ipt" name="company" value="{{array_get($userInfo['info'], 'company')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><b>*</b>公司固定电话：</div>
            <div class="uc-auth1-cont">
              <input type="text" class="i-ipt" name="mobile" value="{{array_get($userInfo['info'], 'telephone')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><b>*</b>公司所在地：</div>
            <div class="uc-auth1-cont">
              <select name="province" class="i-ipt j_province">
                  <option value="">--选择省--</option>
                  @if(isset($provinces) && count($provinces)>0)
                    @foreach($provinces as $province)
                      <option value="{{$province['id']}}"
                        @if( array_get($userInfo['info'], 'province') == $province['id'] )
                        selected
                        @endif>{{$province['name']}}</option>
                    @endforeach
                  @endif
              </select>
              <select name="city" class="i-ipt j_city">
                  <option value="">--选择市--</option>
                  @if(isset($cities) && count($cities)>0)
                      @foreach($cities as $city)
                          <option value="{{$city['id']}}"
                            @if( array_get($userInfo['info'], 'city') == $city['id'] )
                            selected
                            @endif>{{$city['name']}}</option>
                      @endforeach
                  @endif
              </select>
              <select name="district" class="i-ipt j_district">
                  <option value="">--选择区--</option>
                  @if(isset($districts) && count($districts)>0)
                      @foreach($districts as $dist)
                          <option value="{{$dist['id']}}"
                            @if( array_get($userInfo['info'], 'district') == $dist['id'] )
                            selected
                            @endif>{{$dist['name']}}</option>
                      @endforeach
                  @endif
              </select>
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><b>*</b>公司详细地址：</div>
            <div class="uc-auth1-cont">
              <input type="text" name="address" class="i-ipt" value="{{array_get($userInfo['info'], 'address')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><b>*</b>税务登记号：</div>
            <div class="uc-auth1-cont">
              <input type="text" class="i-ipt" name="taxnum" value="{{array_get($userInfo['info'], 'taxnum')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><!--<b>*</b>-->开户行：</div>
            <div class="uc-auth1-cont">
             <!-- <select name="bank" class="i-ipt">
                @foreach($banks as $item)
                <option @if(array_get($userInfo['info'], 'bank') == $item) selected @endif>{{$item}}</option>
                @endforeach
              </select>  -->
                <input type="text" class="i-ipt" name="bank" value="{{array_get($userInfo['info'], 'bank')}}" />
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row">
            <div class="uc-auth1-label"><b>*</b>开户账号：</div>
            <div class="uc-auth1-cont">
              <input type="text" class="i-ipt" name="account" value="{{array_get($userInfo['info'], 'account')}}">
              <div class="help"></div>
            </div>
          </div>

          <!-- type 3 -->
          <div class="uc-auth1-row type3 @if($userInfo['usergroup']==8) show @endif">
            <div class="uc-auth1-label">企业类型：</div>
            <div class="uc-auth1-cont">
              <input class="i-ipt i-ipt-short" type="text" name="ctype" value="{{array_get($userInfo['info'], 'ctype')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row type3 @if($userInfo['usergroup']==8) show @endif">
            <div class="uc-auth1-label">企业人数：</div>
            <div class="uc-auth1-cont">
              <input class="i-ipt i-ipt-short" type="text" name="cnum" value="{{array_get($userInfo['info'], 'cnum')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row type3 @if($userInfo['usergroup']==8) show @endif">
            <div class="uc-auth1-label">所属行业：</div>
            <div class="uc-auth1-cont">
              <input class="i-ipt i-ipt-short" type="text" name="ctrade" value="{{array_get($userInfo['info'], 'ctrade')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row type3 @if($userInfo['usergroup']==8) show @endif">
            <div class="uc-auth1-label">公司性质：</div>
            <div class="uc-auth1-cont">
              <input class="i-ipt i-ipt-short" type="text" name="cnature" value="{{array_get($userInfo['info'], 'cnature')}}">
              <div class="help"></div>
            </div>
          </div>


          <!-- type1 -->
          <div class="uc-auth1-row type1 @if( !in_array($userInfo['usergroup'],[7,8]) ) show @endif">
            <div class="uc-auth1-label"><b>*</b>经销商代码：</div>
            <div class="uc-auth1-cont">
              <input type="text" class="i-ipt" name="netcode" value="{{array_get($userInfo['info'], 'netcode')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row type1 @if( !in_array($userInfo['usergroup'],[7,8]) ) show @endif">
            <div class="uc-auth1-label"><b>*</b>经销商类别：</div>
            <div class="uc-auth1-cont">
              <select name="type" class="i-ipt">
                <option value="1" @if(array_get($userInfo['info'], 'type') == 1) selected @endif>特许经销商</option>
                <option value="2" @if(array_get($userInfo['info'], 'type') == 2) selected @endif>四位一体</option>
                <option value="3" @if(array_get($userInfo['info'], 'type') == 3) selected @endif>维修站</option>
                <option value="4" @if(array_get($userInfo['info'], 'type') == 4) selected @endif>一般经销商</option>
                <option value="5" @if(array_get($userInfo['info'], 'type') == 5) selected @endif>精品店</option>
                <option value="6" @if(array_get($userInfo['info'], 'type') == 6) selected @endif>直营店</option>
              </select>
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row type1 @if( !in_array($userInfo['usergroup'],[7,8]) ) show @endif">
            <div class="uc-auth1-label"><b>*</b>展厅面积(㎡)：</div>
            <div class="uc-auth1-cont">
              <input type="text" name="rank" class="i-ipt" value="{{array_get($userInfo['info'], 'rank')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row type1 @if( !in_array($userInfo['usergroup'],[7,8]) ) show @endif">
            <div class="uc-auth1-label">官方微博：</div>
            <div class="uc-auth1-cont">
              <input type="text" class="i-ipt" name="weibo" value="{{array_get($userInfo['info'], 'weibo')}}">
              <div class="help"></div>
            </div>
          </div>
          <div class="uc-auth1-row type1 @if( !in_array($userInfo['usergroup'],[7,8]) ) show @endif">
            <div class="uc-auth1-label">微信公众号：</div>
            <div class="uc-auth1-cont">
              <input type="text" class="i-ipt" name="weixin" value="{{array_get($userInfo['info'], 'weixin')}}">
              <div class="help"></div>
            </div>
          </div>
            <input type="hidden" class="i-ipt" name="userInfoId" value="{{array_get($userInfo['info'], 'id')}}">


          <div class="uc-auth1-row">
            <div class="uc-auth1-cont">
              <button class="uc-auth1-submit" type="submit">保存</button>
            </div>
          </div>

        </form>
      </div>
      <!-- end step1 -->
      <!-- step2 -->
      <div class="uc-auth2 @if(array_get($userInfo, 'step') == 1) active @endif">
        <p class="uc-auth2-title">请提供与注册时公司名称相同的营业三证的扫描件，三证合一企业三张图片都请上传营业执照即可，认证后可开启网站认证用户功能（如果上传不成功，建议用360浏览器上传你的认证资料）</p>
        <div class="uc-auth2-item">
          <a href="javascript:;" data-type="clicense" data-id="{{array_get($userInfo['info'], 'clicense')? $userInfo['info']['clicense']:''}}" class="upload-btn">选择文件</a>
          <span class="upload-help">请上传营业执照副本，支持jpg，png，gif格式文件，大小不能超过1M</span>
          <div class="upload-info">
            <div class="prog">
              <div class="wrap"><div class="in"></div></div>
              <span class="pct">0%</span>
            </div>
            <span class="msg"></span>
          </div>
          <div class="preview">
            <div class="cont pre"><div class="in"><img src="{{array_get($userInfo['info'], 'clicense')? '/image/get/'.$userInfo['info']['clicense']:''}}"></div></div>
            <div class="cont exp"><div class="in"><img src="/img/mine/ex1.png" alt=""></div><div class="exp-tip">示例：</div></div>
          </div>
        </div>
        <div class="uc-auth2-item">
          <a href="javascript:;" data-type="ctax" data-id="{{array_get($userInfo['info'], 'ctax')? $userInfo['info']['ctax']:''}}" class="upload-btn">选择文件</a>
          <span class="upload-help">请上传税务登记证副本，支持jpg，png，gif格式文件，大小不能超过1M</span>
          <div class="upload-info">
            <div class="prog">
              <div class="wrap"><div class="in"></div></div>
              <span class="pct">0%</span>
            </div>
            <span class="msg"></span>
          </div>
          <div class="preview">
            <div class="cont pre"><div class="in"><img src="{{array_get($userInfo['info'], 'ctax')? '/image/get/'.$userInfo['info']['ctax']:''}}"></div></div>
            <div class="cont exp"><div class="in"><img src="/img/mine/ex2.png" alt=""></div><div class="exp-tip">示例：</div></div>
          </div>
        </div>
        <div class="uc-auth2-item">
          <a href="javascript:;" data-type="ocode" data-id="{{array_get($userInfo['info'], 'ocode')? $userInfo['info']['ocode']:''}}" class="upload-btn">选择文件</a>
          <span class="upload-help">请上传组织机构代码证副本，支持jpg，png，gif格式文件，大小不能超过1M</span>
          <div class="upload-info">
            <div class="prog">
              <div class="wrap"><div class="in"></div></div>
              <span class="pct">0%</span>
            </div>
            <span class="msg"></span>
          </div>
          <div class="preview">
            <div class="cont pre"><div class="in"><img src="{{array_get($userInfo['info'], 'ocode')? '/image/get/'.$userInfo['info']['ocode']:''}}"></div></div>
            <div class="cont exp"><div class="in"><img src="/img/mine/ex3.png" alt=""></div><div class="exp-tip">示例：</div></div>
          </div>
        </div>
        <div class="uc-auth2-footer">
          <a href="javascript:;" id="btn2Prev" class="uc-auth2-prev">返回上一步</a>
          <a href="javascript:;" id="btn2Submit" class="uc-auth2-submit">确定</a>
        </div>
      </div>
      <!-- end step2 -->
        @elseif(array_get($userInfo, 'step')==2)

    <!-- step3 -->
    <div class="uc-auth3" style="display: block;">
        <div class="uc-auth3-title"><img class="ico" src="/img/mine/me_home_aut_ic_wait.png">工作人员审核中，请耐心等待，如有问题可联系客服电话<strong>400-030-8555</strong></div>
    </div>
    <!-- end step3 -->

      <!-- step4 -->
        @else
      <div class="uc-auth3" style="display: block;">
        <div class="uc-auth3-title"><img class="ico" src="/img/mine/me_home_aut_ic_finish.png">您已通过认证，可以进行操作了！点击进入<a href="/innovate/clip">官方素材</a>或<a href="/deal">交易平台</a></div>
        <div class="uc-auth3-row">
          <div class="uc-auth3-u">认证类型：</div>
          <div class="uc-auth3-u">@if($userInfo['usergroup']==6) 经销商 @elseif($userInfo['usergroup']==7) 区域经销商 @else 合作伙伴 @endif </div>
        </div>

        <div class="uc-auth3-row">
          <div class="uc-auth3-u">公司名称：</div>
          <div class="uc-auth3-u">{{array_get($userInfo['info'], 'company')}}</div>
        </div>
        <div class="uc-auth3-row">
          <div class="uc-auth3-u">公司固定电话：</div>
          <div class="uc-auth3-u">{{str_replace(substr(array_get($userInfo['info'], 'telephone'),0,-4),'********',array_get($userInfo['info'], 'telephone'))}} </div>
        </div>

        <div class="uc-auth3-row">
          <div class="uc-auth3-u">公司所在地：</div>
          <div class="uc-auth3-u">{{array_get($userInfo['info'], 'addressStr')}}</div>
        </div>
        <div class="uc-auth3-row">
          <div class="uc-auth3-u">公司地址：</div>
          <div class="uc-auth3-u">{{array_get($userInfo['info'], 'address')}}</div>
        </div>
          <div class="uc-auth3-row">
              <div class="uc-auth3-u">税务登记号：</div>
              <div class="uc-auth3-u">{{str_replace(substr(array_get($userInfo['info'], 'taxnum'),0,-4),'********',array_get($userInfo['info'], 'taxnum'))}}  </div>
          </div>
          <div class="uc-auth3-row">
              <div class="uc-auth3-u">开户行：</div>
              <div class="uc-auth3-u">{{array_get($userInfo['info'], 'bank')}}  </div>
          </div>
          <div class="uc-auth3-row">
              <div class="uc-auth3-u">开户账号：</div>
              <div class="uc-auth3-u">{{str_replace(substr(array_get($userInfo['info'], 'account'),0,-4),'********',array_get($userInfo['info'], 'account'))}} </div>
          </div>

            @if($userInfo['usergroup']==6 || $userInfo['usergroup']==7)
          <div class="uc-auth3-row">
              <div class="uc-auth3-u">品牌：</div>
              <div class="uc-auth3-u">{{array_get($userInfo['info'], 'brand')}}</div>
          </div>
          @endif



          @if($userInfo['usergroup']==6)
          <div class="uc-auth3-row">
              <div class="uc-auth3-u">经销商代码：</div>
              <div class="uc-auth3-u">{{str_replace(substr(array_get($userInfo['info'], 'netcode'),0,-4),'********',array_get($userInfo['info'], 'netcode'))}}</div>
          </div>

        <div class="uc-auth3-row">
          <div class="uc-auth3-u">经销商类别：</div>
          <div class="uc-auth3-u">
              @if(array_get($userInfo['info'], 'type') == 1)
                  特许经销商
              @elseif(array_get($userInfo['info'], 'type') == 2)
                  四位一体
              @elseif(array_get($userInfo['info'], 'type') == 3)
                  维修站
              @elseif(array_get($userInfo['info'], 'type') == 4)
                  一般经销商
              @elseif(array_get($userInfo['info'], 'type') == 5)
                  精品店
              @elseif(array_get($userInfo['info'], 'type') == 6)
                  直营店
              @endif
          </div>
        </div>
        <div class="uc-auth3-row">
          <div class="uc-auth3-u">展厅级别：</div>
          <div class="uc-auth3-u">{{array_get($userInfo['info'], 'rank')}}</div>
        </div>

        <div class="uc-auth3-row">
          <div class="uc-auth3-u">官方微博客：</div>
          <div class="uc-auth3-u">{{array_get($userInfo['info'], 'weibo')}}</div>
        </div>
        <div class="uc-auth3-row">
          <div class="uc-auth3-u">微信公众号：</div>
          <div class="uc-auth3-u">{{array_get($userInfo['info'], 'weixin')}}</div>
        </div>
          @endif


          @if($userInfo['usergroup']==8)
          <div class="uc-auth3-row">
              <div class="uc-auth3-u">企业类型：</div>
              <div class="uc-auth3-u">{{array_get($userInfo['info'], 'ctype')}}</div>
          </div>

          <div class="uc-auth3-row">
              <div class="uc-auth3-u">企业人数：</div>
              <div class="uc-auth3-u">{{array_get($userInfo['info'], 'cnum')}}</div>
          </div>
          <div class="uc-auth3-row">
              <div class="uc-auth3-u">所属行业：</div>
              <div class="uc-auth3-u">{{array_get($userInfo['info'], 'ctrade')}}</div>
          </div>

          <div class="uc-auth3-row">
              <div class="uc-auth3-u">公司性质：</div>
              <div class="uc-auth3-u">{{array_get($userInfo['info'], 'cnature')}}</div>
          </div>
          @endif



        <div class="uc-auth3-tb">
          <div class="uc-auth3-c"><img src="/image/get/{{$userInfo['info']['clicense']}}" alt=""></div>
          <div class="uc-auth3-c"><img src="/image/get/{{$userInfo['info']['ctax']}}" alt=""></div>
          <div class="uc-auth3-c"><img src="/image/get/{{$userInfo['info']['ocode']}}" alt=""></div>
        </div>
      </div>
        @endif
      <!-- end step4 -->
    </div>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
