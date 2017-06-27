@extends('mine.fragment.layout')

@section('uc-content')
    <div class="uc-main-main group">
        <div class="con">
            <h3>我的集团</h3>
                        <!-- 申请列表 -->
                <div class="apply-con">
                    <p>{{$currentGrougName}}</p>
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
        </div>
    </div>
    <div class="uc-main-side">
        @include('mine.fragment.hot')
    </div>
@endsection