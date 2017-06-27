@extends('mine.fragment.layout')

@section('uc-content')
	<div class="uc-main-main group">
		<div class="con">
			<h3>我的集团</h3>
            @if(count($currentUserRelation)>0 && $currentUserRelation->relationStatus != \App\Model\UserInfo::$NotVerificationDistributor  )
                <!-- 申请状态 -->
                <div class="apply-status">
                    <ul>
                        <li>{{$currentGrougName}}<span class="status">状态：<span>{{$statusArr[$currentUserRelation['relationStatus']]}}</span></span></li>
                        <li>
                            <span>账户</span>:{{$currentUserRelation['username']}}
                            <span style="margin-left: 30px;">申请时间:</span>{{date('Y-m-d  H:i:s',$currentUserRelation['applyTime'])}}
                            @if($currentUserRelation['relationStatus'] == \App\Model\UserInfo::$RelationSuccess)
                               <span style="margin-left: 30px;">成功时间:</span>{{date('Y-m-d  H:i:s',$currentUserRelation['successTime'])}}
                            @endif
                            @if($currentUserRelation['relationStatus'] == \App\Model\UserInfo::$AdinRefuse
                            || $currentUserRelation['relationStatus'] == \App\Model\UserInfo::$DistributorRefuse)
                               <a class="re-apply" href="/mine/apply">重新申请</a>
                            @endif
                        </li>
                    </ul>
                </div>
            @else
                <!-- 申请列表 -->
			<div class="apply-con">
                <p>
                @if(count($currentUserRelation)>0 && $currentUserRelation->relationStatus == \App\Model\UserInfo::$NotVerificationDistributor && $currentUserRelation->relationType == \App\Model\UserInfo::$AdminToDistributorRelation)
                   当前您没有绑定任何集团
                @else
                   {{$currentGrougName}}
                @endif
                @if(count($currentUserRelation)>0 && $currentUserRelation->relationStatus == \App\Model\UserInfo::$NotVerificationDistributor && $currentUserRelation->relationType == \App\Model\UserInfo::$AdminToDistributorRelation)
                    <span>{{$currentGrougName}}对您发出了邀请<a class="look">点击查看</a></span>
                @endif
                </p>
				<input type="hidden" name="apply-group" value="{{$currentGrougName}}" data-id="1111">
				<!-- 这里放发出邀请的名字 -->
				<table>
					<thead>
						<tr>
							<td>所有集团</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody>
                    @if(isset($groupUser))
                        @foreach($groupUser as $key => $value)
						<tr>
                           <input type="hidden" value="{{$value['uid']}}" />
							<td>{{$value['realname']}}</td>
							<td><a class="apply">申请</a></td>
						</tr>
                        @endforeach
                    @endif
					</tbody>
				</table>
				<div class="page-action white clear">
                    		{!!$pager!!}
				</div>
			</div>
            @endif
		</div>
	</div>
	<div class="uc-main-side">
	@include('mine.fragment.hot')
	</div>
@endsection