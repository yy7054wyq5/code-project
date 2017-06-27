<div class="footer">
<div class="line"></div>
<div  class="container">
  <ul class="row">
    <li class="col-xs-1"></li>
     @foreach($ridersLink as $items)
    <li class="col-xs-2">
      <img src="/img/foot-clock.png">
      <span>{{$items['typeName']}}</span>
      @foreach($items['sub'] as $item)
      <a href="/help/{{$item['articleId']}}">{{$item['articleTitle']}}</a>
      @endforeach
    </li>
    @endforeach
    <li class="col-xs-1"></li>
  </ul>
</div>
<div class="line"></div>
  <table>
    <tr class="font12">
      <td colspan="2">
          @foreach($footerInfo as $key => $item)
              @if(count($footerInfo)-1 == $key)
                  <a href="/help/{{$item['articleId']}}">{{$item->articleTitle}}</a>
              @else
                  <a href="/help/{{$item['articleId']}}">{{$item->articleTitle}}</a>|
              @endif
          @endforeach
      </td>
    </tr>
    <tr>
      <td colspan="2">公司地址：上海市大统路988号协诚中心B座17楼（200070）</td>
    </tr>
    <tr>
      <td colspan="2">上海祎策数字科技有限公司 版权所有 Copyright © 2009-2016 沪ICP备12031561号-1  &nbsp;<img src="/img/police-icon.png">沪公网安备31010602000274号
</td>
    </tr>
    <tr>
      <td colspan="2" class="friend-link">友情链接：
      @foreach($link as $key => $value)
        <a href="{{ $value['url'] }}" target="_blank">{{ $value['title'] }}</a>&nbsp;
      @endforeach
      </td>
    </tr>
    <tr>
      <td align="right"><img src="/img/foot-floor.jpg" class="mr2" /></td>
      <td align="left"><a href="http://jubao.china.cn:13225/reportform.do" target="_blank" class="ml2" ><img src="/img/foot-report.jpg"/></a></td>
    </tr>

  </table>
</div>