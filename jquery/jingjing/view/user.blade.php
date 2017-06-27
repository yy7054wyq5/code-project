@extends('web.main')

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/webuploader.css">
{{-- <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/> --}}
@endsection
@section('body')
<body class="user">
 {{--    <div class="addBox"><input  id="xxoo" type="text" class="short" style="width:372px;" value="1111111"></div> --}}
    <div class="top-bg">
        <div class="wrap">
            <div class="top">
                <a href="/" target="_self"><img src="/img/web/my_icon.png" class="logo"></a>
                <span>
                <a href="/" target="_self">首页</a>
                <a href="/web/login" target="_self">退出</a>
                </span>
            </div>
        </div>
    </div>
    <div class="user-banner">
        <div class="wrap">
            <img src={{ is_numeric(array_get(session(config('app.webUser')), 'picKey')) ? '/image/get/' .session(config('app.webUser'))['picKey']:"/img/web/my_photo.png"}}>
        </div>
        <div class="banner">
            <div class="wrap"><span class="username">{{ array_get(session(config('app.webUser')), 'nickname')}}</span></div>
        </div>
    </div>
    <div class="wrap">
        <div class="user-center">
            <ul class="tab">
                <li><span  index="1">我参加的活动</span></li>
                <li class="line">|</li>
                <li><span index="2" class="active">我发布的活动</span></li>
                <li class="line">|</li>
                <li><span index="3" id="mapSearch">发布活动</span></li>
                {{-- mapSearch --}}
                <li class="line">|</li>
                <li><span index="4" >个人资料</span></li>
            </ul>
            <div class="clear"></div>
            <div class="tab-con">
                <div class="tab-con-1">{{-- 该DIV下第一行字体默认居中，用table可避免此问题 --}}
                {{-- 我发起的活动 --}}
                <table>
                    <tr>
                        <td>
                            <ul class="my-event join">
                                @if (isset($joinActivities) && $joinActivities)
                                    @foreach($joinActivities as $key=>$value)
                                        <li class="event-date">{{$value['dateStr']}}<span>{{$value['weekStr']}}</span>
                                        </li>
                                        @if (array_get($value, 'activities'))
                                            @foreach(array_get($value, 'activities') as $activity)
                                                <li>
                                                    @if($activity['status']  == 4)
                                                    <ul class="today-meg delete">
                                                    @else
                                                    <ul class="today-meg">
                                                    @endif
                                                        <li class="today-time">{{$activity['timeStr']}}</li>
                                                        <li class="today-infor">
                                                            <p>
                                                                @if ($activity['type'] == 1 && array_get($activity, 'groupInfo'))
                                                                    {{$activity['groupInfo']['name']}}
                                                                    <i class="my_users"></i>
                                                                    @else
                                                                    {{$activity['createUser']['nickname']}}
                                                                    <i class="my_user"></i>
                                                                @endif
                                                                @if($activity['status']  == 4)
                                                                    <span class="delete-word">已取消</span>
                                                                @endif

                                                                    {{-- 多人是my_users，单人是my_user --}}
                                                            </p>

                                                            <p>{{$activity['name']}}</p>

                                                            <p><span>人数&nbsp;{{$activity['sumJoiners']}}/{{$activity['maxJoiners']}}人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span>￥&nbsp;{{$activity['fee']}}/人</span></p>
                                                        </li>
                                                        <li class="line"></li>
                                                    </ul>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                    </tr>
                </table>
                <div class="page-action white clear">
                    <?= $joinPager?>
                    {{--<a class="page-up" role="button">上一页</a>--}}
                    {{--<a role="button" class="active">1</a>--}}
                    {{--<a role="button">2</a>--}}
                    {{--<a role="button">3</a>--}}
                    {{--<a role="button">4</a>--}}
                    {{--<a role="button">5</a>--}}
                    {{--<a role="button">6</a>--}}
                    {{--<a role="button">7</a>--}}
                    {{--<span>......</span>--}}
                    {{--<a class="page-down" role="button">下一页</a>--}}
                    {{--<span style="margin-left:50px;">共12313页</span>--}}
                    {{--<span>到第</span>--}}
                    {{--<input type="text">--}}
                    {{--<span>页</span>--}}
                    {{--<a role="button" class="btn">确定</a>--}}
                </div>
                </div>
                <div class="tab-con-2 active">
                 {{-- 我创建的活动 --}}
                   <table>
                       <tr>
                           <td>
                              <ul class="my-event create">
                          
                                  @if (isset($createActivities) && $createActivities)
                                      @foreach($createActivities as $key=>$value)
                                          <li class="event-date">{{$value['dateStr']}}<span>{{$value['weekStr']}}</span>
                                          </li>
                                          @if (array_get($value, 'activities'))
                                              @foreach(array_get($value, 'activities') as $activity)
                                                  <li>
                                                      @if($activity['status']  == 4)
                                                      <ul class="today-meg delete">
                                                      @else
                                                      <ul class="today-meg">
                                                      @endif
                                                      {{-- 为today-meg 加上 delete 样式即为被取消的活动效果 --}}
                                                          <li class="today-time">{{$activity['timeStr']}}</li>
                                                          <li class="today-infor">
                                                              <p>
                                                                  @if ($activity['type'] == 1 && array_get($activity, 'groupInfo'))
                                                                      {{$activity['groupInfo']['name']}}
                                                                      <i class="my_users"></i>
                                                                  @else
                                                                      {{$activity['createUser']['nickname']}}
                                                                      <i class="my_user"></i>
                                                                  @endif
                                                                  @if($activity['status']  == 4)
                                                                  <span class="delete-word">已取消</span>
                                                                  @endif

                                                              </p>

                                                              <p>{{$activity['name']}}</p>

                                                              <p><span>人数&nbsp;{{$activity['sumJoiners']}}/{{$activity['maxJoiners']}}人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span>￥&nbsp;{{$activity['fee']}}/人</span></p>
                                                          </li>
                                                          <li class="line"></li>
                                                      </ul>
                                                  </li>
                                              @endforeach
                                          @endif
                                      @endforeach
                                  @endif

                            </ul>
                           </td>
                       </tr>
                   </table>
                    <div class="page-action white clear create">
                        <?= $createPager?>
                    </div>
                </div>
                <div  class="tab-con-3">
                {{-- 发布活动 --}}        
                <form id="publishActivity">
                    <table class="publish" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td width="120">关联兴趣</td>
                            <td width="870" class="interest">
                                <div class="input-result short interest-input" >请先选择兴趣分类</div>
                                <div class="dropdown interest-menu Zindex999999">
                                  <a class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">选择分类</a><i></i>
                                  <ul class="dropdown-menu interest-menu">
                                  @foreach($interests as $interest)
                                    <li><a role="button" id="<?= $interest['id'] ?>"><?= $interest['name'] ?></a></li>
                                    @endforeach
                                  </ul>
                                  <img src="/img/web/loading.gif" class="loading">
                                </div>
                                <div class="dropdown sub-interest">
                                  <a class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">选择子类</a><i></i>
                                  <ul class="dropdown-menu interest-list"></ul>
                                </div>
                                <input type="hidden" id="interestids">
                                <label class="error"></label>
                           </td>
                        </tr>
                        <tr>
                            <td>活动名称</td>
                            <td>
                                <input type="text" class="long" maxlength="30" id="name">
                                <label  class="error" style="display:block;">活动名称不超过30个字</label>
                            </td>
                        </tr>
                        <tr>
                            <td>活动介绍</td>
                            <td><textarea class="long" id="description"></textarea>
                            <label class="error" style="display:block;">活动介绍不超过300个字</label>
                            </td>
                        </tr>
                        <tr>
                            <td>开始时间</td>
                            <td class="date"><input class="Wdate" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d {%H+2}:%m',maxDate:'#F{$dp.$D(\'timeEnd\')}'})" id="timeStart" value=""><label id="name-error" class="error"></label></td>
                        </tr>
                        <tr>
                            <td>结束时间</td>
                            <td class="date"><input class="Wdate" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'timeStart\')}'})" id="timeEnd" value=""><label id="name-error" class="error"></label></td>
                        </tr>
                        <tr>
                            <td class="vTop">活动地点</td>
                            <td class="parts" style="padding-bottom:5px;">
                                {{-- 省 --}}
                                <div class="dropdown Zindex999">
                                  <a class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">选择省/市</a><i></i>
                                  <ul class="dropdown-menu" id="pro">
                                  @foreach($provinces as $province)
                                    <li><a role="button" id="<?= $province['id'] ?>" title="<?= $province['value'] ?>"><?= $province['value'] ?></a></li>
                                    @endforeach
                                  </ul>
                                  <input type="hidden" id="provinceId">
                                  <img src="/img/web/loading.gif" class="loading">
                                </div>
                                {{-- 市 --}}
                                <div class="dropdown Zindex999">
                                  <a class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">选择市/区</a><i></i>
                                  <ul class="dropdown-menu" id="city"></ul>
                                  <input type="hidden" id="cityId">
                                </div>
                                {{-- 区 --}}
                                <div class="dropdown Zindex999">
                                  <a class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">选择区/县</a><i></i>
                                  <ul class="dropdown-menu" id="area"></ul>
                                  <input type="hidden" id="areaId">
                                </div>
                                <label class="parts error"></label>{{-- 显示错误提示 --}}
                                <div style="width:100%; float:left; height:15px;"></div>{{-- 使lockMap在下面显示 --}}
                                <a role="button" id="lockMap" class="jjbtn">定位至当前区县</a>
                                {{-- 接收详细地址 --}}
                                <input  id="add" type="text" class="short" style="width:670px;" maxlength="50" value="请先点击定位按钮" disabled="disabled">
                                {{-- 接收坐标 --}}
                                <input  id="coordinate" type="hidden">
                                {{-- 接收当前市/区的值 --}}
                                <input id="nowPart" type="hidden">
                                <div style="width:100%; float:left; height:15px;" class="abc"></div>
                                {{-- 地图容器 --}}
                                <div id="partsMap"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>人数上限</td>
                            <td><input type="text" class="short" id="maxJoiners" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "><span>人</span><label class="error" style="display:block;">人数不超过11人</label></td>
                        </tr>
                        <tr>
                            <td>活动费用</td>
                            <td><input type="text" class="short" id="fee" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "><span>元</span><label class="error"></label></td>
                        </tr>
                        <tr>
                            <td>发布名义</td>
                            <td><div class="dropdown long Zindex99 group">
                              <a class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">请选择</a><i></i>
                              <ul class="dropdown-menu">
                                <li><a role="button" id="group2">个人</a></li>
                              </ul>
                            </div><label class="group error"></label><input type="hidden" id="type"><input type="hidden" id="typeId"></td>
                        </tr>
                        <tr>
                            <td>退款设置</td>
                            <td><div class="dropdown long Zindex9 refund">
                              <a class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">请选择</a><i></i>
                              <ul class="dropdown-menu">
                                <li><a role="button" id="refundjj" >委托「井井」退款</a></li>
                                <li><a role="button" id="norefund" >不接受退款</a></li>
                              </ul>
                              <input type="hidden" id="refund">
                            </div><label id="name-error" class="error"></label><span class="droptips"></span></td>
                        </tr>
                        <tr>
                            <td class="vTop">上传图片</td>
                            <td>
                                <div id="uploader-demo" class="Zindex1">
                                    <!--用来存放item-->
                                    <div id="fileList" class="uploader-list"></div>
                                    <div id="filePicker"></div>
                                </div>
                                <label class="error" style="display:block;">请勿上传相同图片</label>
                                <input type="hidden" id="upPicKey">
                            </td>
                        </tr>
                        <tr>
                          <td class="vTop">验证码：</td>
                          <td class="captcha-box"><input type="text" id="captcha" class="short" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "><a class="send">发送验证码</a><label class="error"></label><img src="/img/web/loading.gif" class="loading"><input type="hidden" id="getCaptcha"></td>
                        </tr>
                        <tr>
                            <td class="noline" colspan="2"><a class="jjbtn subform">确认发布</a></td>
                        </tr>
                    </table>
                </form>
                </div>
                <div class="tab-con-4">
                {{-- 个人资料 --}}
                  <table>
                      <tr>
                          <td>
                              <ul class="my-infor">
                                    <li>用户名：{{ array_get(session(config('app.webUser')), 'nickname')}}</li>
                                  @if(array_get(session(config('app.webUser')), 'sex') == 1)
                                    <li>性别：男</li>
                                  @else
                                  <li>性别：女</li>
                                  @endif
                                    <li>年龄：{{ array_get(session(config('app.webUser')), 'age') ? array_get(session(config('app.webUser')), 'age'):18}}</li>
                                    <li><span>兴趣：</span>
                                        @if(array_get(session(config('app.webUser')), 'interests'))
                                            @foreach(array_get(session(config('app.webUser')), 'interests') as $interest)
                                                <span class="interest">{{$interest['name']}}<i></i></span>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li class="noline"><p>个性签名：{{array_get(session(config('app.webUser')), 'signature')}}</p></li>
                              </ul>
                          </td>
                      </tr>
                  </table> 
                </div>
            </div>
        </div>
        <div class="bottom"></div>
    </div>
    {{-- 模态框 --}}
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
      </div>
    </div>
    <input type="hidden" name="mobile" id="mobileNum" value="{{array_get(session(config('app.webUser')), 'mobile')}}">

</body>
@endsection
@section('scripts')
    <script type="text/template" id="tpl">
        <% _.each(datas, function (item) { %>
        <li class="event-date"><%= item.dateStr %><span><%= item.weekStr %></span>
        </li>
        <% if (item.activities) { %>
        <% _.each(item.activities, function (activity) { %>
        <li>
            <ul class="today-meg">
                <li class="today-time"><%= activity.timeStr %></li>
                <li class="today-infor">
                    <p>
                        <% if (activity.type == 1 && activity.groupInfo) { %>
                            <%= activity.groupInfo.name %>
                            <i class="my_users"></i>
                    <% } else { %>
                            <%= activity.createUser.nickname %>
                            <i class="my_user"></i>
                    <% } %>
                    </p>
                    <p><%= activity.name %></p>
                    <p><span>人数&nbsp;<%= activity.sumJoiners %>/<%= activity.maxJoiners %>人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span>￥&nbsp;<%= activity.fee %>/人</span></p>
                </li>
                <li class="line"></li>
            </ul>
        </li>
        <% }); %>
        <% } %>
        <% }); %>
    </script>
{{-- 日期时间选择插件 --}}
<script type="text/javascript" src="/js/My97DatePicker/WdatePicker.js"></script>
{{-- 图片上传 --}}
<script type="text/javascript" src="/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="/js/underscore-min.js"></script>
{{-- 高德 --}}
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f6e2616e3614e5e2c399057375a7dedf&plugin=AMap.Geocoder,AMap.Autocomplete,AMap.PlaceSearch"></script>
<script>
   function joinedAct(start, pageCount){
       $.get('/web/joined-act', {'start':start,'pageCount':pageCount}, function (res){
           if(res['status'] == 'success') {
               datas = res['activities'];
               $('.my-event.join').html( _.template($("#tpl").html(), datas));
               $('.page-action.white.clear.join').html(res['pager']);
           } else {
               $('.my-event.join').html('');
               $('.page-action.white.clear.join').html('');
           }

       });
   }

   function createAct(start, pageCount){
       $.get('/web/create-act', {'start':start,'pageCount':pageCount}, function (res){
           if(res['status'] == 'success') {
               datas = res['activities'];
               $('.my-event.create').html( _.template($("#tpl").html(), datas));
               $('.page-action.white.clear.create').html(res['pager']);
           } else {
               $('.my-event.create').html('');
               $('.page-action.white.clear.create').html('');
           }

       });
   }
</script>
@endsection