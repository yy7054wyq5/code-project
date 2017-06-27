@extends('mine.fragment.layout')

@section('uc-content')
<div class="uc-main-main">
  <div class="uc-score" id="j_uc_grow_record">
    <div class="uc-score-header">
      <div class="title">我的成长记录</div>
    </div>
    <div class="uc-score-body">
      <div class="filter">
        <form>
          <div class="side" style="float: none;">
            <span>筛选日期</span>
            <input type="text" class="date" id="j_startDate" onclick="WdatePicker({maxDate: '#F{$dp.$D(\'j_endDate\')||\'%y-%M-%d\'}', readOnly: true})">
            -
            <input type="text" class="date" id="j_endDate" onclick="WdatePicker({minDate: '#F{$dp.$D(\'j_startDate\')}', maxDate: '%y-%M-%d', readOnly: true})">
            <a href="javascript:;" data-url="/mine/grow/record?page=1&start={start}&end={end}" class="ubtn">确定</a>
          </div>
        </form>
      </div>
      <table class="tb">
        <thead>
          <tr>
            <th>成长值</th>
            <th>获得日期</th>
            <th>备注说明</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($lists[0]))
          @foreach($lists as $value)
          <tr>
            <td class="score">+{{ $value->score }}</td>
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
          <a class="page-up nopage" href="/mine/grow/record?page={{ $page - 1 <= 1 ? 1 : $page - 1 }}" role="button">上一页</a>
          @for($i = 1; $i <= $count; $i++)
          <a role="button" href="/mine/grow/record?page={{ $i }}" class="@if($page == $i) active @endif">{{ $i }}</a>
          @endfor
          <a class="page-down" href="/mine/grow/record?page={{ $page + 1 >= $count ? $count : $page + 1 }}" role="button">下一页</a>
      </div>
    </div>
  </div>
  @include('mine.fragment.focus')
</div>
<div class="uc-main-side">
  @include('mine.fragment.hot')
</div>
@endsection
