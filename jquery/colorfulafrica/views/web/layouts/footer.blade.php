<div class="footer">
	<div class="container">
		{{-- {{trans('index.offstore')}} --}}
		<div class="outline"></div>
		<div class="branch">
			<ul class="item left">
				<li>上海</li>
				<li>{{trans('index.address')}}：上海市杨浦区长阳路1687号长阳谷创意园区1号楼二号电梯厅408室</li>
				<li>{{trans('index.phone')}}：+86(0)21-65988258</li>
				<li>{{trans('index.email')}}：info@colourfulafrica.com</li>
			</ul>
			<ul class="item center">
				<li>南非</li>
				<li>{{trans('index.address')}}：A07, Block A,Grosvenor Square,10 Park Lane,Century City 7441,Cape Town,South Africa</li>
				<li>{{trans('index.phone')}}：0027-82-2572245</li>
				<li>{{trans('index.email')}}：danny@colourfulafrica.com</li>
			</ul>
			<ul class="item right">
				<li>广州旗舰店</li>
				<li>{{trans('index.address')}}：广州市天河路199号</li>
				<li>{{trans('index.phone')}}：020-58768989</li>
				<li>{{trans('index.email')}}：cfgz@cf.com</li>
			</ul>
		</div>
		{{-- <div class="line"></div> --}}
		<div class="bottom-menu">
			<a class="contact-us" href="/{{Config::get('app.locale')}}/contactus">{{trans('index.contactus')}}</a>
			<i class="a-line"></i>
			<a class="about-us" href="/{{Config::get('app.locale')}}/aboutus">{{trans('index.aboutus')}}</a>
			<div class="look-us">
				<span>{{trans('index.focusus')}}</span>
				<a class="weibo" href="http://weibo.com/u/5894161757"></a>
				<a class="wechat" href="javascript:;"></a>
			</div>
			<div class="code">
				<img src="/dist/img/code.png">
				<p>{{trans('index.scan_add_wechat')}}</p>
			</div>
		</div>
		<div class="copy-right">
			<i></i>
			<span>2005-2016 © 多彩非洲® colourfulafrica.com All rights reserved. <a href="http://www.miitbeian.gov.cn" target="_blank">沪ICP备16033786号</a></span>
			</div>
	</div>
</div>
