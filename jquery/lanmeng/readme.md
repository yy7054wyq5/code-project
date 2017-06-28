* [地址](http://www.lemauto.cn/)

### 前端注意事项

* bootstrap-3.3.5为基础编写前端代码。使用less进行预编译，结合loongjoy.css。less中有对lanwang进行单独注释
* 为"按钮"类型的元素添加手型效果，需要在标签内添加属性role="button"（bootstrap默认样式）
* 默认字体 为bootstrap原生设置的.对于12号字体采用 font-family:Arial, Verdana, "\5b8b\4f53";即宋体
* .txt样式专为 限定二行文字数量，以省略号结尾的，请勿在它处另写该样式名内容。
* .carousel 需要指定长宽，不然在IE8中只有按钮大小。
* z-index值：主菜单nav>li为99。下拉框lem-drop>li为9。底部container为1（因IE兼容问题采用定位解决）。
* index-main 样式为各栏目首页 通用样式 对应的样式名

### 模版布局

* 主模版 resources\views\layouts\main.blade.php
* 头部 resources\views\layouts\header.blade.php
    * 搜索框：@section('header-search'),默认开启；
    * 菜单：@section('menu'),默认开启
    * banner：@section('banner'),默认开启；
        * banner左边：@section('banner-left'),默认开启；
        * banner幻灯片：@section('banner-right')默认开启；
* 底部 resources\views\layouts\footer.blade.php,默认开启；
* 登录页面那种头部底部的模版 login.blade.php
* 模态框（浮动层）模版 resources\views\layouts\modal.blade.php 目前注册时显示协议

### 可复用结构（需要在编辑器内看以下结构）

```html
* 搜索框
        <li class="deal-search"><input type="text" placeholder="请输入关键字"><i></i></li> 
* 交易的按钮
        <a class="deal-btn" role="button">求购汽配</a>
* 详情按钮
        <a class="detail-btn" role="button">详情</a>
* 下拉框
      <ul class="lem-drop">
        <li class="dropdown"><a class="btn" data-toggle="dropdown">交易类型</a>
        <ul class="dropdown-menu">
          <li><a href="#">出售</a></li>
          <li><a href="#">求购</a></li>
        </ul></li>
        <li class="dropdown"><a class="btn" data-toggle="dropdown">所有品牌</a>
        <ul class="dropdown-menu">
          <li><a href="#" class="sub-dropdown">热门品牌</a></li>
          <li><a href="#" class="sub-dropdown">其他品牌</a></li>
        </ul></li>
      </ul>
    *下拉菜单.dropdown注意事项
    * .lw-drop >.dropdown 为篮网专属样式结构，见交易平台首页
    * .dropdown > .dropdown-menu，必须是这样的结构，不然鼠标经过无效果!
    * .dropdown 不设置高度，为其添加.dropup可以使下拉菜单变成向上的

* 下拉框带输入框的
      <ul class="lem-drop lem-drop-input">
        <li class="dropdown"><a class="btn four-words" data-toggle="dropdown"><div class="input-result">所有主题</div></a>
        <ul class="dropdown-menu">
          <li><a href="#">今天的主题</a></li>
          <li><a href="#">3天以内的主题</a></li>
          <li><a href="#">7天以内的主题</a></li>
          <li><a href="#">30天以内的主题</a></li>
        </ul></li>
      </ul>
      *注意事项
      *单个输入框要调整A的背景定位，两个字为默认，three-words,four-words,five-words,six-words为不同字数的样式
  * 幻灯片
      <div class="infor-main">
        <div class="container">
            <div id="carousel-infor" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-infor" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-infor" data-slide-to="1"></li>
                <li data-target="#carousel-infor" data-slide-to="2"></li>
                <li data-target="#carousel-infor" data-slide-to="3"></li>
                <li data-target="#carousel-infor" data-slide-to="4"></li>
              </ol>
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <a href=""><img src="/img/test/gray.png" alt="..."></a>
                </div>
                <div class="item">
                  <a href=""><img src="/img/test/black.png" alt="..."></a>
                </div>
                <div class="item">
                  <a href=""><img src="/img/test/gray.png" alt="..."></a>
                </div>
                 <div class="item">
                  <a href=""><img src="/img/test/black.png" alt="..."></a>
                </div>
                 <div class="item">
                  <a href=""><img src="/img/test/gray.png" alt="..."></a>
                </div>
              </div>
              <!-- Controls -->
                <a class="left carousel-control" href="#carousel-infor" role="button" data-slide="prev"></a>
                <a class="right carousel-control" href="#carousel-infor" role="button" data-slide="next"></a>
            </div>
        </div>
      </div>

      <!-- 幻灯片细线 -->
      <div id="carousel-main-fl1" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel-main-fl1" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-main-fl1" data-slide-to="1"></li>
          <li data-target="#carousel-main-fl1" data-slide-to="2"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <a href="#" target="_self"><img src="http:\\placehold.it/220x294" alt="凌渡上市吊旗"></a>
            <div class="carousel-caption">
                <h3><a href="#" target="_self">凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m</a></h3>
                <p>￥248.50</p>
              </div>
          </div>
          <div class="item">
            <a href="#" target="_self"><img src="img/test/test.png" alt="..."></a>
            <div class="carousel-caption">
                <h3><a href="#" target="_self">凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m</a></h3>
                <p>￥248.50</p>
              </div>
          </div>
          <div class="item">
            <img src="img/test/gray.png" alt="...">
            <div class="carousel-caption">
                <h3><a href="#" target="_self">凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m凌渡上市吊旗1.2*3m</a></h3>
                <p>￥248.50</p>
              </div>
          </div>
        </div>
      </div>
  *选项卡
  <ul class="nav nav-tabs mouse-over-tab" role="tablist" >
    <li role="presentation" class="active"><a href="#inspect" aria-controls="inspect" role="tab" data-toggle="tab" >互动调研</a></li>
    <li role="presentation"><a href="#infor" aria-controls="infor" role="tab" data-toggle="tab">行业资讯</a></li>
    <li role="presentation"><a href="#brand" aria-controls="brand" role="tab" data-toggle="tab">品牌社区</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="inspect">
      <a  href="" target="_self" class="line-ellipsis">111蓝网致新用户的一封信蓝网致新用户的一封信dadadadada</a>
      <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
      <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
      <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
      <div style="text-align:right; padding-right:20px;"><a href="" target="_self" class="more">更多</a></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="infor">
      <a  href="" target="_self" class="line-ellipsis">222蓝网致新用户的一封信蓝网致新用户的一封信dadadadada</a>
      <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
      <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
      <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
      <div style="text-align:right; padding-right:20px;"><a href="" target="_self" class="more">更多</a></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="brand">
        <a  href="" target="_self" class="line-ellipsis">333蓝网致新用户的一封信蓝网致新用户的一封信dadadadada</a>
        <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
        <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
        <a  href="" target="_self">dad克拉的哈了很多快乐哈</a>
        <div style="text-align:right; padding-right:20px;"><a href="" target="_self" class="more">更多</a></div>
    </div>
  </div>
  * 翻页
  <!-- 红色 -->
  <div class="page-action">
      <a class="page-up" role="button">上一页</a>
      <a role="button" class="active">1</a>
      <a role="button">2</a>
      <a role="button">3</a>
      <span>......</span>
      <a class="page-down" role="button">下一页</a>
  </div>
  <!-- 白色 -->
  <div class="page-action white clear">
      <a class="page-up nopage" role="button">&lt;&nbsp;上一页</a>
      <a role="button" class="active">1</a>
      <a role="button">2</a>
      <a role="button">3</a>
      <a role="button">4</a>
      <a role="button">5</a>
      <a role="button">6</a>
      <a role="button">7</a>
      <span>......</span>
      <a class="page-down" role="button">下一页&nbsp;&gt;</a>
      <span style="margin-left:50px;">共12313页</span>
      <span>到第</span>
      <input type="text">
      <span>页</span>
      <a role="button" class="btn">确定</a>
  </div>
  
  *面包屑
  <ol class="breadcrumb">
    <li><a href="/riders" class="red-font" target="_self">车友汇</a></li><li class="arrow"></li><li>最新线路</li>
  </ol>

  *侧边栏多多
  <div class="side-bar rank">
      <h2>新闻排行</h2>
      <ul>
          <li><a href=""><span>01</span>蓝网致新用户的一封信</a></li>
          @for ($i = 0; $i < 8; $i++)
           <li><a href="" target="_self" title="我是冒泡"><span>02</span>广电TV特价车 点军宏顺活动1111111111111111111111</a></li>
          @endfor
      </ul>
  </div>
  <h2>热销宝贝</h2>
  <div class="side-bar duoduo">
      <ul>
          <li><a href="" target="_self" title="我是冒泡">
            <img src="/img/test/gray.png"/>
            <p class="side-font">LED万圣节胸章 万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）</p>
          </a>
          <span>￥19.80</span></li>
          <li><a href="" target="_self" title="我是冒泡">
            <img src="/img/test/gray.png"/>
            <p class="side-font">LED万圣节胸章万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）</p>
          </a><span>￥19.80</span></li>
      </ul>
  </div>
  <div class="side-bar duoduo">
      <h2>多多推荐<small>Best buy</small></h2>
      <ul>
          <li><a href="" target="_self" title="我是冒泡">
            <img src="/img/test/gray.png"/>
            <p class="side-font">LED万圣节胸章 万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）</p>
          </a>
          <span>￥19.80</span></li>
          <li><a href="" target="_self" title="我是冒泡">
            <img src="/img/test/gray.png"/>
            <p class="side-font">LED万圣节胸章万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）LED万圣节胸章万圣节创意礼品（4只）</p>
          </a><span>￥19.80</span></li>
      </ul>
  </div>

  *侧边栏 非多多
  <div class="side-bar-innovate">
      <div class="new-ex">最新案例<a href="" target="_blank">更多</a></div>
      <ul>
          {{-- 只有第一个LI才有图片后面的都没有 --}}
          <li class="first clear"><a href="" target="_self"><img src="/img/test/1.jpg"/><span>青春不散场同学会海报设计psd素材下载</span></a></li>
          <li><a href="" target="_self"><span>青春不散场同学会海报设计psd素材</span></a></li>
          <li><a href="" target="_self"><span>缤纷盛夏商场夏季低价促销海报PSD</span></a></li>
          {{-- 最后一个LI需要加last样式 --}}
          <li class="last"><a href="" target="_self"><span>缤纷盛夏商场夏季低价促销海报PSD</span></a></li>
      </ul>
      <div class="hot">人气案例<a href="" target="_blank">更多</a></div>
      <ul>
          {{-- 只有第一个LI才有图片后面的都没有 --}}
          <li class="first clear"><a href="" target="_self"><img src="/img/test/1.jpg"/><span>青春不散场同学会海报设计psd素材下载</span></a></li>
          <li><a href="" target="_self"><span>青春不散场同学会海报设计psd素材大大大大</span></a></li>
          <li><a href="" target="_self"><span>哒哒哒青春不散场同学会海报设计psd素材</span></a></li>
          {{-- 最后一个LI需要加last样式 --}}
          <li class="last"><a href="" target="_self"><span>大大大大青春不散场同学会海报设计psd素材</span></a></li>
      </ul>
      <div class="new-co">最新发帖<a href="" target="_blank">更多</a></div>
      <ul class="co-box">
          <li><a href="" target="_self"><span>青春不散场同学会海报设计psd素材大大大大</span></a></li>
          <li><a href="" target="_self"><span>哒哒哒青春不散场同学会海报设计psd素材</span></a></li>
          {{-- 最后一个LI需要加last样式 --}}
          <li class="last"><a href="" target="_self"><span>大大大大青春不散场同学会海报设计psd素材</span></a></li>
      </ul>
  </div>

  *分享按钮
  <div class="share clear"><span>分享到：</span>{!!HTML::script('common/bshare.js') !!}</div>
  <div class="myclear"></div>
  
  *myFocus图片幻灯片效果带放大镜效果
  <div id="slideBox"><!--焦点图盒子-->
    <div class="pic"><!--内容列表(li数目可随意增减)-->
      <ul>
          <li><div class="jqzoom"><img src="/img/test/1.jpg" thumb="" alt="" text="" jqimg="/img/test/1.jpg"/></div></li>
          <li><div class="jqzoom"><img src="/img/test/2.jpg" thumb="" alt="" text="" jqimg="/img/test/2.jpg"/></div></li>
          <li><div class="jqzoom"><img src="/img/test/3.jpg" thumb="" alt="" text="" jqimg="/img/test/3.jpg"/></div></li>
          <li><div class="jqzoom"><img src="/img/test/4.jpg" thumb="" alt="" text="" jqimg="/img/test/4.jpg"/></div></li>
          <li><div class="jqzoom"><img src="/img/test/5.jpg" thumb="" alt="" text="" jqimg="/img/test/5.jpg"/></div></li>
      </ul>
    </div>
  </div>

*评论
<div class="comment-box">
    <h3>我有话说</h3>
      <form class="form-horizontal" id="form" onsubmit="return false;" >
          <input type="hidden" name="_token" id="token" value="">
          <input type="hidden" name="cid"  value="">
            <textarea class="conmment-field" name="comment" id="conmment">亲，内容是否喜欢？快说点什么吧！</textarea>
            <a class="btn" role="button">发表评论</a>
      </form>
    <div class="myclear"></div>
    <h4>全部评论<small>已有111名用户发表了评论</small></h4>
    <ul class="all-conmment">
      {{-- 用户评论 --}}
      <li>
        <div class="img-round"></div>
        <img src="/img/test/test.png" alt="">
        <a href="">dajd</a>
        <span>发表时间：29381831831</span>
        <p>大家都加大了就打架啊第六届啊</p>
      </li>
      {{-- 用户评论 --}}
    </ul>
    <!-- 翻页 -->
    <div class="page-action white clear">
        <a class="page-up nopage" role="button">上一页</a>
        <a role="button" class="active">1</a>
        <a role="button">2</a>
        <a role="button">3</a>
        <span>......</span>
        <a role="button">15</a>
        <a class="page-down" role="button">下一页</a>
    </div>
  </div>
```