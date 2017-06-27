@extends('admin.adminbase')
@section('title', '活动列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{array_get($detail, 'name')}}参与者列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>电话</th>
                        <th>昵称</th>
                        <th>性别</th>
                        <th>年龄</th>
                        <th>加入时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($joiners)
                        @foreach($joiners as $joiner)
                            <tr>
                                <td>{{$joiner['userInfo']['mobile']}}</td>
                                <td>{{$joiner['userInfo']['nickname']}}</td>
                                @if($joiner['userInfo']['sex'] == 1)
                                    <td>男</td>
                                @elseif($joiner['userInfo']['sex'] == 2)
                                    <td>女</td>
                                @else
                                    <td>未知</td>
                                @endif
                                <td>{{$joiner['userInfo']['age']? $joiner['userInfo']['age']:'18'}}</td>
                                <td>{{$joiner['createTime']}}</td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <?php echo $pager ?>
        </div>
    </div>


@endsection