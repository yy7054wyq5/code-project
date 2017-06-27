@extends('web.user.layouts.main')

@section('user-content')
<div class="user-container userinfo">
	<ul class="userinfo-menu">
		<li class="active">{{trans('index.userinfo')}}</li>
		<li>{{trans('index.address_management')}}</li>
		<li>{{trans('index.change_password')}}</li>
		<li>{{trans('index.questionnaire')}}</li>
	</ul>
	{{-- 个人信息 --}}
	<div class="con" style="display:block;">
		<table style="margin-left:100px;">
			<tr>
				<td>{{trans('index.nickname')}}：</td>
				<td><input type="text" name="nickName" value="{{$userInfo['nickname']}}"></td>
			</tr>
			<tr>
				<td>{{trans('index.realname')}}：</td>
				<td><input type="text" name="realName" value="{{$userInfo['name']}}"></td>
			</tr>
			<tr>
				<td>{{trans('index.ageRange')}}：</td>
				<td>
					<select name="ageRange">
						@foreach(App\Utils\Helpers::ageRange() as $key=>$ageRange)
						<option value="{{$key}}" @if($key==$userInfo['ageRange']) selected @endif>{{$ageRange}}</option>
						@endforeach
					</select>
				</td>
			</tr>
			<tr>
				<td>{{trans('index.sex')}}：</td>
				<td>
					<div class="sex @if($userInfo['sex']==1) active @endif" data-id="1">
						<i class="man"></i>
						<span>{{trans('index.male')}}</span>
					</div>
					<div class="sex @if($userInfo['sex']==0) active @endif" style="margin-left: 30px;" data-id="0">
						<i class="woman"></i>
						<span>{{trans('index.female')}}</span>
					</div>
					<input type="hidden" name="sex" value="{{$userInfo['sex']}}">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<a class="info-btn updateinfo-btn">{{trans('index.save')}}</a>
				</td>
			</tr>
		</table>
	</div>
	{{-- 地址管理 --}}
	<div class="con">
		<div class="line"></div>
		<div class="address-box">
			@foreach($address as $addr)
			<div class="item @if($addr['isDefault']==1) active @endif" data-id="{{$addr['id']}}" data-object="{{json_encode($addr)}}">
				<div class="name">{{$addr['name']}}</div>
				@if($addr['isDefault']==0)<a class="default">{{trans('index.defualt_address')}}</a>@endif
				<div class="address">{{$addr['detail']}}</div>
				<div class="mobile">{{$addr['mobile']}}</div>
				<div class="item-btn">
					<a class="edit">{{trans('index.edit')}}</a>
					<a class="delete">{{trans('index.delete')}}</a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="handle-address">
			<h3>{{trans('index.add_eidt_new_address')}}</h3>
			<table>
				<tr>
					<td>{{trans('index.name')}}：</td>
					<td><input type="text" name="name"></td>
				</tr>
				<tr>
					<td>{{trans('index.address')}}：</td>
					<td class="chosepart">
						<select class="pro"></select>
						<select class="city">
							<option>请先选择省</option>
						</select>
						<select class="area">
							<option>请先选择市</option>
						</select>
						<input type="text" name="detail-address">
					</td>
				</tr>
				<tr>
					<td>{{trans('index.postcode')}}：</td>
					<td><input type="text" name="postcode"></td>
				</tr>
				<tr>
					<td>{{trans('index.mobile')}}：</td>
					<td><input type="text" name="mobile"></td>
				</tr>
				<tr>
					<td colspan="2">
						<a class="info-btn address-btn">{{trans('index.save')}}</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
	{{-- 修改密码 --}}
	<div class="con">
		<table style="margin-left: 50px;">
			<tr>
				<td>{{trans('index.oldpassword')}}：</td>
				<td><input type="password" name="oldpass"></td>
			</tr>
			<tr>
				<td>{{trans('index.new_password')}}：</td>
				<td><input type="password" name="newpass"></td>
			</tr>
			<tr>
				<td>{{trans('index.confirm_newpasswor')}}：</td>
				<td><input type="password" name="confirmpass"></td>
			</tr>
			<tr>
				<td colspan="2">
					<a class="info-btn changepass-btn">{{trans('index.save')}}</a>
				</td>
			</tr>
		</table>
	</div>
	<div class="con invest">
		<ul class="QAQ">
			@foreach($invest['data'] as $invest)
			<li>
				<a href="/{{Config('app.locale')}}/user/invest/{{$invest['id']}}" title="{{$invest['title']}}" target="_self">{{$invest['title']}}</a>
				<span>{{$invest['createTime']}}</span>
			</li>
			@endforeach
		</ul>
		<div class="loading-more" data-pageIndex="1" data-pageCount="2" style="width: 800px;">{{trans('index.load_more')}}</div>
		<div class="no-product">{{trans('index.no_content')}}</div>
	</div>
</div>
@endsection
