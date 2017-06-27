<!-- left menu begin -->
<div id="sidebar" class="sidebar sidebar-fixed">
	<div class="sidebar-menu nav-collapse">
		<ul>
			@if ($menu)
			@foreach ($menu as $value)
				<li class="has-sub @if( isset($value['sub']) && strrpos(serialize($value['sub']), $now) !== false) active @endif">
					<a href="javascript:;" class="">
					<i class="fa fa-table fa-fw"></i> <span class="menu-text">{{ $value['modulename'] }}</span>
					<span class="arrow"></span>
					</a>
					@if (isset($value['sub']) && count($value['sub'])>0)
					<ul class="sub">
						@foreach ($value['sub'] as $v)
						<li @if($v['moduletag'] == $now) class="current" @endif><a class="" href="/superman/{{ $v['moduletag'] }}"><span class="sub-menu-text">{{ $v['modulename'] }}</span></a></li>
						@endforeach
					</ul>
					@endif
				</li>
			@endforeach
			@endif
		</ul>
	</div>
</div>
<!-- left menu end -->