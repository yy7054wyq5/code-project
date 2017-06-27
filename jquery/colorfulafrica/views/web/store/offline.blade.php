@extends('web.layouts.main')

@section('index-header')
@endsection

@section('banner')
<div class="banner offline">
	<div class="container">
		<h1>线下门店</h1>
		<div class="map">
			<div class="store-address beijing">
				<div class="info">
					<div data-address="北京市劲松路180号1-1" data-phone="010-58768989" data-imgsrc="http://placehold.it/441x255" data-link="index">多彩非洲-劲松路旗舰店</div>
					<i></i>
				</div>
				<i></i>
				<span>北京</span>
			</div>
			{{-- <div class="dis-address"></div> --}}
			<div class="store-address shanghai">
				<div class="info">
					<div data-address="上海市黄浦区南京东路710号" data-phone="021-58768989" data-imgsrc="http://placehold.it/441x255" data-link="index">多彩非洲-黄浦区南京东路</div>
					<i></i>
				</div>
				<i></i>
				<span>上海</span>
			</div>
			{{-- <div class="dis-address"></div> --}}
			<div class="store-address guangzhou">
				<div class="info">
					<div data-address="广州市天河路199号" data-phone="020-58768989" data-imgsrc="http://placehold.it/441x255" data-link="index">多彩非洲-天河路199号</div>
					<i></i>
				</div>
				<i></i>
				<span>广州</span>
			</div>
			<div class="dis-address"></div>
		</div>
	</div>
</div>
@endsection
