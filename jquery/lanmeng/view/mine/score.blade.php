@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-score" id="j_uc_score">
    <div class="uc-score-header">
      <div class="title">我的积分</div>
    </div>
    <div class="uc-score-body">
      <div class="filter">
        <div class="count">您目前账户剩余积分: <em>{{ $score }}</em></div>
        <div class="side">
          <form id="search">
            <input type="hidden" name="page" value="1">
            <span>筛选日期</span>
            <input type="text" class="date" name="start" id="j_startDate" value="{{$begin}}" onclick="WdatePicker({maxDate: '#F{$dp.$D(\'j_endDate\')||\'%y-%M-%d\'}', readOnly: true})">
            -
            <input type="text" class="date" name="end" id="j_endDate" value="{{$end}}" onclick="WdatePicker({minDate: '#F{$dp.$D(\'j_startDate\')}', maxDate: '%y-%M-%d', readOnly: true})">
            <button class="ubtn" type="submit">确定</button>
          </form>
        </div>
      </div>
      <table class="tb">
        <thead>
          <tr>
            <th>积分变化</th>
            <th>日期</th>
            <th>备注</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($lists[0]))
          @foreach($lists as $value)
          <tr>
            <td class="score">{{ $value->status == 0 ? '+' : '-' }}{{ $value->score }}</td>
            <td>{{ date('Y-m-d H:i:s', $value->created) }}</td>
            <td>{{ $value->desc ? $value->desc : '---' }}</td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="3">暂无数据</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
    <div class="uc-score-footer">
      <div class="page-action white clear">
          <a class="page-up nopage" href="/mine/score?page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
          @for($i = 1; $i <= $count; $i++)
          <a role="button" href="/mine/score?page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
          @endfor
          <a class="page-down" href="/mine/score?page={{ $page + 1 >= $count ? $count : $page + 1 }}" role="button">下一页</a>
      </div>
    </div>
  </div>

  @include('mine.fragment.focus')

  <div class="uc-score-doc">
    <div class="uc-score-doc-title">蓝网积分说明</div>
    <ul>
      <li>
        <div class="title">什么是蓝网积分</div>
        <p>蓝网积分是蓝网用户在蓝网平台网站（www.lemauto.cn）购买商品、案例分享、论坛发帖、参与调研、活动奖励、用户注册、用户登录等相关活动情况给予的奖励，蓝网积分仅可在蓝网网站使用。蓝网积分可直接用于支付蓝网网站订单，在消费时100蓝网积分可抵2元现金使用，蓝网积分支付根据商品不一样，兑换价值不一样，部分商品可以享受全额兑换。</p>
      </li>
      <li>
        <div class="title">蓝网积分有效期说明</div>
        <p>蓝网积分的有效期1年，即从获得蓝网积分开始至年底。用户获得但未使用的蓝网积分，将在每年的年底过期，蓝网将定期对过期蓝网积分进行作废处理（清零）。例2015年12月31日将清空2014年度客户获得但未使用的蓝网积分。蓝网积分规则由蓝网制定并依据国家相关法律规及规章制度予以解释和修改，规则以网站公布为准。</p>
      </li>
      <li>
        <div class="title">蓝网积分的兑换比例</div>
        <p>蓝网积分和人民币兑换比例是100:2，即100个蓝网积分相当于人民币2元。</p>
      </li>
      <li>
        <div class="title">蓝网积分如何获取</div>
        <p>用户在蓝网进行购买商品、案例分享、论坛发帖、参与调研、活动奖励、用户注册、用户登录等都可以获得蓝网积分。具体获取蓝网积分规则详见蓝网积分帮助中心。</p>
      </li>
      <li>
        <div class="title">蓝网积分的扣除</div>
        <p>1、年底清零扣除<br>2、在蓝网购物消耗积分时扣除相应积分</p>
      </li>
    </ul>
  </div>
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
