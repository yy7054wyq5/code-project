@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-grow">
  <div class="uc-grow-header">
    <div class="title">我的成长值</div>
  </div>
  <div class="uc-grow-body">
    <div class="panel">
      <div class="pic">
        <img class="userIcon" src="{{ $info->imageurl }}" alt="">
        <img class="lv" src="/img/mine/lv/me_home_grow_ic_v{{ $score['level'] }}.png" alt="">
      </div>
      <div class="unit">
        <span>你好，{{ $info->username }}</span>
        <a href="/mine/grow/record" class="ubtn">查看成长记录</a>
      </div>
      <div class="meta">
        <span class="crt">我的成长值：<strong>{{ $info->growth }}</strong></span>
        在<em>+{{ $score['diff'] }}</em>成长值就成为<img src="/img/mine/lv/me_home_grow_ic2_v{{ $score['level'] + 1 }}.png">会员了哦！
      </div>
      <div class="lvline">
        <ul>
          <li><img src="/img/mine/lv/me_home_grow_ic3_v0.png"></li>
          <li><img src="/img/mine/lv/me_home_grow_ic{{ $score['level'] >= 1 ? 3 : 4 }}_v1.png"></li>
          <li><img src="/img/mine/lv/me_home_grow_ic{{ $score['level'] >= 2 ? 3 : 4 }}_v2.png"></li>
          <li><img src="/img/mine/lv/me_home_grow_ic{{ $score['level'] >= 3 ? 3 : 4 }}_v3.png"></li>
          <li><img src="/img/mine/lv/me_home_grow_ic{{ $score['level'] >= 4 ? 3 : 4 }}_v4.png"></li>
          <li><img src="/img/mine/lv/me_home_grow_ic{{ $score['level'] >= 5 ? 3 : 4 }}_v5.png"></li>
        </ul>
        <div class="line"><span class="point" style="width: {{ $score['per'] }}%;"></span></div>
      </div>
    </div>
    <div class="panel2">
      <div class="title">会员成长介绍</div>
      <p>会员成长体系包含6个会员等级， 会员等级由“<strong>成长值</strong>”决定。<br>成长值越高，会员等级越高。</p>
      <img src="/img/mine/me_home_grow_chart.png">
    </div>
    <div class="panel3">
      <div class="title">成长值介绍</div>
      <div class="cont">
        <p>成长值是蓝网会员通过购买商品、案例分享、论坛发帖、参与调研、活动奖励、用户注册、用户登录等所获的的经验值，由累积记分计算获得，它标志着您在蓝网累计的网购经验值和参与经验值，成长值越高会员等级越高，同时享受的服务及政策更多。</p>
        <div class="expression">
          <div class="lbtn">会员成长值</div>
          <span>&asymp;</span>
          <div class="rbtn">累计积分数量</div>
        </div>
        <p><em>备注：</em>成长值获得根据获得积分累加而成，与积分的区别是，积分年底清零，成长值将以滚雪球的方式递增。</p>
      </div>
    </div>
  </div>
</div>
@endsection
